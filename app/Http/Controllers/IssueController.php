<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IssueController extends Controller
{
//    public function list() {
//        $issues = Issue::all();
//        return view('layouts.navigation', [
//            'issues' => $issues
//        ]);
//    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255|',
            'describe' => 'required|string|max:255',
            'attachments' => 'file|mimes:jpg,jpeg,png|nullable'
        ]);

        $attachments = null;
        $user_id = Auth::id();
        if ($request->hasFile("attachments")) {
            $file = $request->file("attachments");
            $path = "uploads/";
            $fileName = time().rand(0,9).$file->getClientOriginalName();
            $file->move($path,$fileName);
            $attachments = $path.$fileName;
        }

        Issue::create([
            "phone" => $request->get('phone'),
            "email" => $request->get('email'),
            "describe" => $request->get('describe'),
            "attachments" => $attachments,
            "user_id" => $user_id
        ]);
        return back()->with('success', 'We have received your problem, we will respond as soon as possible!');
    }
}
