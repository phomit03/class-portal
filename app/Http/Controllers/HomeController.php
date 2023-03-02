<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Classes;
use App\Models\User;
use App\Models\classes_user;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        $recent_activity = array();

        $user = User::query()->whereId(Auth::user()->id)
            ->with(['classes' => function($q) {
                return $q->with(['usersIsStudent', 'usersIsTeacher']);
            }])
            ->first();
        // lấy class của user đang đăng nhập
        $classes = $user->classes;

//        dd($classes->toArray());

        /*$class1 = Classes::whereHas('users', function ($query){
            $query->where('user_id', '=', Auth::user()->id);
        });*/

//        foreach ($classes  as $class){
//            dd($class->pivot->pivotParent->email);
//        }



        if (Auth::user()->role == 'teacher'){
            return view('pages.teacher.home', [
                'recent_activity' => $recent_activity,
                'classes' => $classes,
            ]);
        } else {
            return view('pages.student.home',[
                'classes' => $classes,
            ]);
        }
    }

}
