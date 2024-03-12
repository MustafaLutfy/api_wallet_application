<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myGoals = Goal::where('user_id', auth()->user())->get();
        return response()->json([
            'myGoals' => $myGoals,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $goal = Goal::create([
            'user_id' => auth()->user()->id,
            'target' => $request->target,
            'description'=> $request->description,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goal $goal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goal)
    {
        //
    }
}
