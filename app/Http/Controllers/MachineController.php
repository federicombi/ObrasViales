<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMachineRequest;
use App\Http\Requests\UpdateMachineRequest;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machines = Machine::all(); // o con filtros, orden, etc.
        return view('maquinas', compact('machines'));
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
    public function store(StoreMachineRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, String $id)
    {
        if($request->input('select_maquina') !== null){
            $id = $request->input('select_maquina');
        }
        $machine = Machine::with(
            'machine_model.machine_type', 
            'machine_model.machine_brand', 
            'machine_status', 
            'allocations', 
            'allocations.construction', 
            'allocations.construction.region',
            'allocations.construction.region.province',
            'allocations.allocation_end_motive',
            'trails'
            )->find($id);
            
        ///Verificar si esta en una obra o es deposito
        return view('maquinas', compact('machine'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Machine $machine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMachineRequest $request, Machine $machine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Machine $machine)
    {
        //
    }

    public function prueba(String $id)
    {
        /// $machine = Machine::with('machine_model.machine_type', 'machine_model.machine_brand', 'machine_status')->find($id);
        $machine = Machine::with(
            'machine_model.machine_type', 
            'machine_model.machine_brand', 
            'machine_status', 
            'allocations', 
            'allocations.construction', 
            'allocations.construction.region',
            'allocations.construction.region.province',
            'trails',
            )->find($id);
        return response()->json($machine);
    }

    public function get_by_type($id)
    {
        $maquinas = Machine::with("machine_model.machine_type")
            ->whereHas('machine_model.machine_type', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        return response()->json($maquinas);
    }


}
