<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Construction;
use Carbon\Carbon;

class AllocationController extends Controller
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
    public function create(Request $request)
    {
        $id_construction = $request->input('id_construction');

        $construction = Construction::with(
            'construction_status',
            'region',
            'region.province',
            'allocations'
        )->find($id_construction);
        //Aca se lleva al form
        return view('allocate', compact('construction'));
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
    public function show(Allocation $allocation, String $id)
    {
        //ACA ADAPTAR para que traila las allocations con 
       $allocation = Allocation::with("machine_model.machine_type")
            ->whereHas('machine_model.machine_type', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        return response()->json($maquinas);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allocation $allocation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        ////// HACER QUE CIERRE LA ALLOCATION!!!!
        $id = $request->input('id');
        $allocation = Allocation::find($id);

        $end_date_unsupported = $request->input("end_date");
        $end_date = Carbon::parse($end_date_unsupported)->format('Y-m-d');
        $allocation->end_date = $end_date;

        $allocation->allocation_end_motive_id = $request->input("allocation_end_motive_id");

        $allocation->save();
        $machine_id = $request->input("machine_id");

        $destino = $request->input('destino');

        switch($destino){
            case "construction": 
                $id_show = $allocation->construction_id;
                break;
            case "machine":
                $id_show = $machine_id;
                break;
        }
        
        return redirect()->route($destino.".show", ['id' => $id_show]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allocation $allocation)
    {
        //
    }
}
