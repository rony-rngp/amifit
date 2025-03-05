<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        $exercises = DB::table('exercises')
            ->select('id', 'Exercise', 'Difficulty_Level', 'Target_Muscle_Group', 'Prime_Mover_Muscle', 'Primary_Equipment', 'Body_Region', 'Force_Type', 'Short_YouTube_Demonstration', 'gif_file');
        if ($request->name){
            $request->flash();
            $exercises =  $exercises->where('Exercise', 'LIKE', '%' . $request->query('name') . '%');
        }
        $exercises = $exercises->paginate(100);
        return view('backend.exercises.index', compact('exercises'));
    }

    public function create()
    {
        return view('backend.exercises.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Exercise' => 'required|unique:exercises,Exercise',
            'Target_Muscle_Group' => 'required',
            'Prime_Mover_Muscle' => 'required',
            'Primary_Equipment' => 'required',
            'Body_Region' => 'required',
            'Force_Type' => 'required',
        ]);

        $exercise = new Exercise();
        $exercise->Exercise = $request->Exercise;
        $exercise->Difficulty_Level = $request->Difficulty_Level;
        $exercise->Target_Muscle_Group = $request->Target_Muscle_Group;
        $exercise->Prime_Mover_Muscle = $request->Prime_Mover_Muscle;
        $exercise->Primary_Equipment = $request->Primary_Equipment;
        $exercise->Body_Region = $request->Body_Region;
        $exercise->Force_Type = $request->Force_Type;
        $exercise->Short_YouTube_Demonstration = $request->Short_YouTube_Demonstration;
        if($request->hasFile('gif_file')){
            $file = $request->file('gif_file');
            $file_name = time() . rand(1, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/upload/exercise/'), $file_name);
            $exercise->gif_file = $file_name;
        }
        $exercise->save();

        return redirect()->back()->with('success', 'Custom exercise created successfully');
    }

    public function edit($id)
    {
        $exercise = Exercise::find($id);
        return view('backend.exercises.edit', compact('exercise'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Exercise' => 'required|unique:exercises,Exercise,'.$id,
            'Target_Muscle_Group' => 'required',
            'Prime_Mover_Muscle' => 'required',
            'Primary_Equipment' => 'required',
            'Body_Region' => 'required',
            'Force_Type' => 'required',
        ]);

        $exercise = Exercise::find($id);
        $exercise->Exercise = $request->Exercise;
        $exercise->Difficulty_Level = $request->Difficulty_Level;
        $exercise->Target_Muscle_Group = $request->Target_Muscle_Group;
        $exercise->Prime_Mover_Muscle = $request->Prime_Mover_Muscle;
        $exercise->Primary_Equipment = $request->Primary_Equipment;
        $exercise->Body_Region = $request->Body_Region;
        $exercise->Force_Type = $request->Force_Type;
        $exercise->Short_YouTube_Demonstration = $request->Short_YouTube_Demonstration;

        if($request->hasFile('gif_file')){
            $file = $request->file('gif_file');
            $file_name = time() . rand(1, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/upload/exercise/'), $file_name);
            if ($exercise->gif_file != '' && file_exists(public_path('backend/upload/exercise/'.$exercise->gif_file))){
                unlink(public_path('backend/upload/exercise/'.$exercise->gif_file));
            }
            $exercise->gif_file = $file_name;
        }
        $exercise->save();
        if($request->page != ''){
            return redirect()->route('admin.exercises.index', ['page' => $request->page])->with('success', 'Custom exercise updated successfully');
        }else{
            return redirect()->back()->with('success', 'Custom exercise updated successfully');
        }
    }

}
