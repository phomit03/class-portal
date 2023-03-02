<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Result;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function sendResult(Request $request, $id)
    {
        $request->validate([
            'source'  => 'required',
            'description'  => 'nullable',
        ]);

        $userId = Auth::user()->id;
        $result = Result::where(['user_id' => $userId, 'assignment_id' => $id])->first();
        $assignment = Assignment::find($id);

        DB::beginTransaction();
        try {
            if (!$result) {
                $result = new Result();
            }
            $result->assignment_id = $id;
            $result->user_id = $userId;
            $result->subject_id = $assignment->subject_id;
            $result->description = $request->description;
            $result->status = 1;

            if ($request->source){
                $result->source = $request->source;
            }
            if($request->hasfile('source'))
            {
                $file = $request->file('source');
                $source = date('YmdHms'). $userId .'_assignment_'.$id. '_subject_'.$assignment->subject_id .$file->getClientOriginalName();
                $file->move(public_path().'/uploads/answers/', $source);
                $result->source = $source;
            }

            $result->save();

            DB::commit();
            return redirect()->back()->with('success', 'Submit resulted successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while saving data');
        }
    }
}
