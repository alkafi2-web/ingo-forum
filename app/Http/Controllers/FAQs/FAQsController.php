<?php

namespace App\Http\Controllers\FAQs;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class FAQsController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->user()->hasPermissionTo('faqs-manage')) {
            abort(401);
        }
        if ($request->ajax()) {
            $banners = Faqs::latest();

            return DataTables::of($banners)
                ->make(true);
        }
        return view('admin.faqs.index');
    }

    public function create(Request $request)
    {
        // Custom validation messages
        $messages = [
            'question.required' => 'The FAQ question is required.',
            'question.string' => 'The FAQ question must be a string.',
            'question.max' => 'The FAQ question cannot exceed 255 characters.',
            'answer.required' => 'The FAQ answer is required.',
            'answer.string' => 'The FAQ answer must be a string.',
            'answer.max' => 'The FAQ answer cannot exceed 1000 characters.',
        ];

        // Create a validator instance with custom messages
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:1000',
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        try {
            $faq = Faqs::create([
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'added_by' => Auth::guard('admin')->id(),
            ]);
            Helper::log("Create FAQs");
            return response()->json(['success' => ['success' => 'You have successfully Create FAQ!']]);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'success' => false,
                'errors' => ['Unexpected error occurred.'],
            ], 500);
        }
    }

    public function status(Request $request)
    {
        $faq = Faqs::findOrFail($request->id);
        $newStatus = $request->status == 0 ? 1 : 0;
        $faq->status = $newStatus;
        $faq->save();
        $statusMessage = $newStatus == 0 
        ? "$faq->question FAQs status deactive" 
        : "$faq->question FAQs status active";
        Helper::log($statusMessage);
        return response()->json(['success' => 'FAQ status updated successfully']);
    }

    public function delete(Request $request)
    {
        $faq = Faqs::findOrFail($request->id);
        $faq->delete();
        Helper::log("Delete $faq->question FAQs");
        return response()->json(['success' => 'FAQ deleted successfully']);
    }

    public function edit(Request $request)
    {
        $faq = Faqs::findOrFail($request->id);

        return response()->json(['faq' => $faq]);
    }

    public function update(Request $request)
    {
        // Custom validation messages
        $messages = [
            'question.required' => 'The FAQ question is required.',
            'question.string' => 'The FAQ question must be a string.',
            'question.max' => 'The FAQ question cannot exceed 255 characters.',
            'answer.required' => 'The FAQ answer is required.',
            'answer.string' => 'The FAQ answer must be a string.',
            'answer.max' => 'The FAQ answer cannot exceed 1000 characters.',
            'id.required' => 'The FAQ ID is required.',
            'id.exists' => 'The specified FAQ does not exist.',
        ];

        // Create a validator instance with custom messages
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:faqs,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:1000',
        ], $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Return a JSON response with validation errors
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }
        try {
            // Find the FAQ entry by ID and update it
            $faq = Faqs::findOrFail($request->input('id'));
            $faq->update([
                'question' => $request->input('question'),
                'answer' => $request->input('answer'),
                'updated_by' => Auth::guard('admin')->id(), // You might want to update who made the changes
            ]);
            Helper::log("Update FAQs");
            // Return a success response
            return response()->json(['success' => ['success' => 'You have successfully updated the FAQ!']]);
        } catch (\Exception $e) {
            // Return an error response
            return response()->json([
                'success' => false,
                'errors' => ['Unexpected error occurred.'],
            ], 500);
        }
    }
}
