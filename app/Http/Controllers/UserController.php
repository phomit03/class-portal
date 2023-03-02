<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Specify the middleware for this controller
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user's profile
     */
    public function show($user_id = NULL)
    {
        $user = NULL;

        if ($user_id) {
            $user = User::find($user_id);
        } else {
            $user = Auth::user();
        }

        return view('pages.profile')->with('user', $user);
    }

    /**
     * Updates the user's profile
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'avatar'=>'nullable',
            'first_name' => 'required|max:50',
            'last_name' => 'max:50',
            'phone' => 'nullable|min:10|max:15|',
            'date_of_birth' => 'nullable|before:today',
        ]);

        $user = Auth::user();

        if($request->avatar != ''){
            $path = public_path().'/uploads/avatar/';

            //code for remove old file
            if($user->avatar != ''  && $user->avatar != null){
                $file_old = $path.$user->avatar;
                unlink($file_old);
            }

            //upload new file
            $file = $request->avatar;
            $filename = $file->getClientOriginalName();
            $file->move($path, $filename);

            //for update in table
            $user->update(['avatar' => $filename]);
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone = $request->input('phone');
        $user->date_of_birth = $request->input('date_of_birth');

        //dd($request->all());

        if ($user->save()) {
            return redirect('/profile')->with('success', 'Profile updated successfully!');
        }
    }

    /**
     * Display all users that are students
     */
    public function showAll($class_id)
    {
        return view('pages.teacher.students.show_all', [
            'users' => User::all(),
            'class_id' => $class_id
        ]);
    }
}
