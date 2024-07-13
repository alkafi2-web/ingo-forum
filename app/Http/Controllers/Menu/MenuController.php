<?php

namespace App\Http\Controllers\Menu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Page;

class MenuController extends Controller
{
    public function index(){
        $menus = Menu::orderBy('position')->get();
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
        $sortedIDs = $request->input('sortedIDs');

        if (!is_array($sortedIDs)) {
            return response()->json(['error' => 'Invalid input format'], 400);
        }

        foreach ($sortedIDs as $index => $id) {
            $menu = Menu::find($id);
            if ($menu) {
                $menu->position = $index;
                $menu->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Menu order updated successfully']);
    }

}
