<?php

namespace App\Http\Controllers\Menu;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Page;
use App\Models\PostCategory;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('subMenus', 'page')->where('parent_id', 0)->orderBy('position')->get();
        return view('admin.menu.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu_title' => 'required_if:menu_type,post,route,url|nullable|string|max:255',
            'menu_type' => 'required|in:page,post,route,url',
            'page_id' => 'required_if:menu_type,page|nullable|exists:pages,id',
            'postCat_id' => 'required_if:menu_type,post|nullable|exists:post_categories,id',
            'route_name' => 'required_if:menu_type,route|nullable|string|max:255',
            'custom_url' => 'required_if:menu_type,url|nullable|url|max:255',
        ]);

        $menu = new Menu();
        $menu->type = $request->menu_type;

        if ($request->menu_type == 'page') {
            $pageTitle = Page::where('id', $request->page_id)->first()->title;
            $menu->page_id = $request->page_id;
            $menu->name = $pageTitle;
        } elseif ($request->menu_type == 'post') {
            $pageTitle = PostCategory::where('id', $request->postCat_id)->first()->name;
            $menu->post_cat_id = $request->postCat_id;
            $menu->name = $request->menu_title;
        } elseif ($request->menu_type == 'route') {
            $menu->name = $request->menu_title;
            $menu->route = $request->route_name;
        } elseif ($request->menu_type == 'url') {
            $menu->name = $request->menu_title;
            $menu->url = $request->custom_url;
        }

        $menu->save();
        Helper::log("$menu->name save menu");
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
        Helper::log("Menu position reorder");
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
        } else {
            Menu::where('id', $parentId)->update(['has_sub_menu' => 1]);
        }
        Helper::log("Submenu create or update");
        return response()->json(['status' => 'success']);
    }

    public function toggleVisibility(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);
        $menu->visibility = $request->visibility;
        $menu->save();
        $visibilityMessage = $request->visibility == 0
            ? "Menu Invisible"
            : "Menu Visible";
        Helper::log($visibilityMessage);
        return response()->json(['status' => 'success']);
    }

    public function delete(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);
        $menu->delete();
        Helper::log("Menu delete");
        return response()->json(['status' => 'success']);
    }

    public function edit(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);

        return response()->json(['menu' => $menu]);
    }

    public function update(Request $request)
    {
        $menu = Menu::findOrFail($request->menu_id);

        $request->validate([
            'menu_title' => 'required_if:menu_type,post,route,url|nullable|string|max:255',
            'menu_type' => 'required|in:page,post,route,url',
            'page_id' => 'required_if:menu_type,page|nullable|exists:pages,id',
            'postCat_id' => 'required_if:menu_type,post|nullable|exists:post_categories,id',
            'route_name' => 'required_if:menu_type,route|nullable|string|max:255',
            'custom_url' => 'required_if:menu_type,url|nullable|max:255',
        ]);

        $menu->type = $request->menu_type;

        if ($request->menu_type == 'page') {
            $pageTitle = Page::where('id', $request->page_id)->first()->title;
            $menu->page_id = $request->page_id;
            $menu->name = $pageTitle;
        } elseif ($request->menu_type == 'post') {
            $pageTitle = PostCategory::where('id', $request->postCat_id)->first()->name;
            $menu->post_cat_id = $request->postCat_id;
            $menu->name = $request->menu_title;
        } elseif ($request->menu_type == 'route') {
            $menu->name = $request->menu_title;
            $menu->route = $request->route_name;
        } elseif ($request->menu_type == 'url') {
            $menu->name = $request->menu_title;
            $menu->url = $request->custom_url;
        }
        $menu->save();
        Helper::log("$menu->name menu update");
        return response()->json(['success' => true, 'message' => 'Menu updated successfully']);
    }

    public function getPostCat(Request $request)
    {
        if ($request->ajax()) {
            $postCats = PostCategory::select('id', 'name')->get();
            return response()->json($postCats);
        }
    }
}
