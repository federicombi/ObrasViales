<?php

namespace App\Http\Controllers;

use App\Models\AllocationEndMotive;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AllocationEndMotiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $motivos = AllocationEndMotive::all();
        return response()->json($motivos);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AllocationEndMotive $allocationEndMotive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AllocationEndMotive $allocationEndMotive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AllocationEndMotive $allocationEndMotive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AllocationEndMotive $allocationEndMotive)
    {
        //
    }
}
