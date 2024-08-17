<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Brian2694\Toastr\Toastr;
use App\Models\MainContent;
use App\Models\Widget;
use App\Models\Menu;

class FooterController extends Controller
{
    public static function index(Request $request)
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('footer-content-manage')) {
            abort(401);
        }
        return view('admin.content.footer.index');
    }
}
