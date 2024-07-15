<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Page;

class MenuController extends Controller
{
    public function index(){
        $menus = Menu::with('subMenus')->where('parent_id', 0)->orderBy('position')->get();
        return view('admin.menu.index', compact('menus'));
    }
    // store the menu 
    public function store(Request $request)
    {
        $request->validate([
            'menu_title' => 'required_if:menu_type,route,url|nullable|string|max:255',
            'menu_type' => 'required|in:page,route,url',
            'page_id' => 'required_if:menu_type,page|nullable|exists:pages,id',
            'route_name' => 'required_if:menu_type,route|nullable|string|max:255',
            'custom_url' => 'required_if:menu_type,url|nullable|url|max:255',
        ]);        

        $menu = new Menu();
        $menu->type = $request->menu_type;

        if ($request->menu_type == 'page') {
            $pageTitle = Page::where('id', $request->page_id)->first()->title;
            $menu->page_id = $request->page_id;
            $menu->name = $pageTitle;
        } elseif ($request->menu_type == 'route') {
            $menu->name = $request->menu_title;
            $menu->route = $request->route_name;
        } elseif ($request->menu_type == 'url') {
            $menu->name = $request->menu_title;
            $menu->url = $request->custom_url;
        }

        $menu->save();

        return response()->json(['success' => true, 'message' => 'Menu added successfully']);
    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order');
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data'], 400);
        }

        foreach ($order as $index => $item) {
            if (!isset($item['item_id'])) {
                continue; // Skip items without an ID
            }
            $id = str_replace('menu-', '', $item['item_id']);
            $parentId = isset($item['parent_id']) && $item['parent_id'] ? str_replace('menu-', '', $item['parent_id']) : 0;
            Menu::where('id', $id)->update(['position' => $index, 'parent_id' => $parentId]);
        }

        return response()->json(['status' => 'success']);
    }

    public function createOrRemoveSubmenu(Request $request)
    {
        $submenu = $request->input('submenu');
        if (!$submenu) {
            return response()->json(['status' => 'error', 'message' => 'Invalid data'], 400);
        }

        $id = $submenu[0];
        $parentId = $submenu[1];

        $oldParentId = Menu::where('id', $id)->first()->parent_id;

        Menu::where('id', $id)->update(['parent_id' => $parentId]);
        if ($parentId == 0) {
            $oldParentChilds = Menu::where('parent_id', $oldParentId)->count();
            if ($oldParentChilds > 0) {
                Menu::where('id', $oldParentId)->update(['has_sub_menu' => 1]);
            } else {
                Menu::where('id', $oldParentId)->update(['has_sub_menu' => 0]);
            }
            
        }
        else{
            Menu::where('id', $parentId)->update(['has_sub_menu' => 1]);
        }

        return response()->json(['status' => 'success']);
    }
}
