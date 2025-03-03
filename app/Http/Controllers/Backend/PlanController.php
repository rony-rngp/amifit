<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::paginate(pagination_limit());
        return view('backend.plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|unique:plans,name',
           'duration' => 'required|integer',
           'price' => 'required|numeric',
           'discount' => 'required|integer|min:0|max:99',
           'badge_title' => 'required',
           'status' => 'required',
           'options.*' => 'required',
        ]);

        $plan = new Plan();
        $plan->name = $request->name;
        $plan->duration = $request->duration;
        $plan->price = $request->price;
        $plan->discount = $request->discount;
        $plan->badge_title = $request->badge_title;
        $plan->status = $request->status;
        $plan->options = json_encode($request->options);
        $plan->save();

        return redirect()->route('admin.plans.index')->with('success', 'Plan created successfully');

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
        $plan = Plan::find($id);
        return view('backend.plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:plans,name,'.$id,
            'duration' => 'required|integer',
            'price' => 'required|numeric',
            'discount' => 'required|integer|min:0|max:99',
            'badge_title' => 'required',
            'status' => 'required',
            'options.*' => 'required',
        ]);

        $plan = Plan::find($id);
        $plan->name = $request->name;
        $plan->duration = $request->duration;
        $plan->price = $request->price;
        $plan->discount = $request->discount;
        $plan->badge_title = $request->badge_title;
        $plan->status = $request->status;
        $plan->options = json_encode($request->options);
        $plan->save();

        return redirect()->route('admin.plans.index')->with('success', 'Plan updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = Plan::find($id);
        $plan->delete();
        return redirect()->route('admin.plans.index')->with('success', 'Plan deleted successfully');
    }
}
