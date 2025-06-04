<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Request $request, String $id)
    {
        if($request->input('select_construction') !== null){
            $id = $request->input('select_construction');
        }
        $construction = Construction::with([
            'construction_status',
            'region',
            'region.province',
            'allocations' => function ($query) {
                $query->orderByRaw('end_date IS NULL DESC'); // NULLs primero
            },
            'allocations.machine',
            'allocations.machine.machine_model',
            'allocations.machine.machine_model.machine_type',
            'allocations.machine.machine_model.machine_brand',
            'allocations.machine.trails',
            'allocations.allocation_end_motive',
        ])->find($id);
            
        ///Verificar si esta en una obra o es deposito
        return view('obras', compact('construction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Construction $construction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Construction $construction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Construction $construction)
    {
        //
    }

    public function get_by_province($id)
    {
        $obras = Construction::with("region.province")
            ->whereHas('region.province', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        return response()->json($obras);
    }

    public function prueba(String $id)
    {
        $construction = Construction::with([
            'construction_status',
            'region',
            'region.province',
            'allocations' => function ($query) {
                $query->orderByRaw('end_date IS NULL DESC'); // NULLs primero
            },
            'allocations.machine',
            'allocations.machine.machine_model',
            'allocations.machine.machine_model.machine_type',
            'allocations.machine.machine_model.machine_brand',
            'allocations.machine.trails',
            'allocations.allocation_end_motive',
        ])->find($id);

            
        ///Verificar si esta en una obra o es deposito
        return response()->json($construction);
    }
}
