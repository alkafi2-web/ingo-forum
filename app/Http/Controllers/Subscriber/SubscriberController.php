<?php

namespace App\Http\Controllers\Subscriber;

use App\Http\Controllers\Controller;
use App\Models\Subsciber;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriberController extends Controller
{
    public function abc(Request $request)
    {
        // if (!Auth::guard('admin')->user()->hasPermissionTo('contact-list-view')) {
        //     abort(401);
        // }
        if ($request->ajax()) {
            $subscriberList = Subsciber::latest();

            return DataTables::of($subscriberList)
                ->make(true);
        }
        return view('admin.subs.subs-list');
    }
}
