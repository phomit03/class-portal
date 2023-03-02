<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Classes_Subject;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Specify the middleware for this controller
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showAll()
    {
        $userId = Auth::user()->id;

        $user = User::query()
            ->with(['classes' => function($q) {
                $q->with(['subjects']);
            }])->whereId($userId)->first();

        $arrSubjectId = [];

        foreach($user->classes as $class) {
            $arrSubjectId = array_merge($arrSubjectId, $class->subjects->pluck('id')->toArray());
        }

        $subjects = Subject::query()
            ->with('classes')
            ->withCount('assignments')
            ->whereIn('id',$arrSubjectId)
            ->get();
        //dd($subjects, $arrSubjectId);

        if (Auth::user()->role == 'student'){
            return view('pages.student.subject.show_all', compact('subjects'));
        } else{
            return view('pages.teacher.subject.show_all', compact('subjects'));
        }
    }

    public function show($id)
    {
        $subject = Subject::find($id);
        $instructor = $subject->users()->where('role', 'teacher')->first();

        $assignments = $subject->assignments()->orderBy('due_date', 'desc')->get();

        // Grab all the recent activity, which includes
        // assignments and annoucement, then sort date that
        // it was created
        $recent_activity = array();

        return view('pages.teacher.subject.show', [
            'subject' => $subject,
            'instructor' => $instructor,
            'subject_id' => $id,
            'assignments' => $assignments,
            'recent_activity' => $recent_activity
        ]);
    }


    public function form()
    {
        $classesList = Classes::all();
        return view('pages.teacher.subject.form', [
            'classesList'=>$classesList
        ]);
    }

    public function create(Request $request, $class_id)
    {
        DB::beginTransaction();
        try {
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->description = $request->description;
            if ($subject->save()) {
                $class_subject =  new Classes_Subject();
                $class_subject->class_id = $request->class_id;
                $class_subject->subject_id = $subject->id;
                $class_subject->save();
            }
            DB::commit();
            return redirect()->route('subject.show_all')->with('Success', 'Subject added successfully!');
        } catch (\Exception $exception) {
            DB::rollback();
            return redirect()->back()->with('error', 'An error occurred while saving data');
        }
    }

    public function edit($id)
    {
        $subjects = Subject::find($id);
        $classes = Classes::with('subjects');

        return view('pages.teacher.subject.edit', compact('subjects','classes'));
    }

    /**
     * Update the class' information [PUT]
     */
    public function update(Subject $subject, Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'string|max:255|nullable',   // Roadmap To Computing
        ]);

        $subject = Subject::find($id);
        $subject->name = $request->input('name');
        $subject->description = $request->input('description');

        if ($subject->save()) {
            return redirect('/subject/' . $id)->with('success', 'Subject updated successfully!');
        }
    }

    /**
     * Delete a particular class - DELETE
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);
        if (!$subject) {
            return redirect()->back()->with('error', 'Data does not exist');
        }
        DB::beginTransaction();
        try {
            $subject->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Delete subject successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'There was an error that could not be deleted');
        }
    }
}
