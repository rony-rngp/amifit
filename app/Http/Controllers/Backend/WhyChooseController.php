<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\WhyChoose;
use Illuminate\Http\Request;

class WhyChooseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $why_chooses = WhyChoose::paginate(pagination_limit());
        return view('backend.why_choose.index', compact('why_chooses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (WhyChoose::count() < 3){
            return view('backend.why_choose.create');
        }else{
            return redirect()->back();
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required',
           'sub_title' => 'required',
        ]);

        $why_choose = new WhyChoose();
        $why_choose->title = $request->title;
        $why_choose->sub_title = $request->sub_title;
        $why_choose->save();
        return redirect()->route('admin.why-choose.index')->with('success', 'Data created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $why_choose = WhyChoose::find($id);
        return view('backend.why_choose.edit', compact('why_choose'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'sub_title' => 'required',
        ]);

        $why_choose = WhyChoose::find($id);
        $why_choose->title = $request->title;
        $why_choose->sub_title = $request->sub_title;
        $why_choose->save();
        return redirect()->route('admin.why-choose.index')->with('success', 'Data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $why_choose = WhyChoose::find($id);
        $why_choose->delete();
        return redirect()->route('admin.why-choose.index')->with('success', 'Data deleted successfully');
    }
}
