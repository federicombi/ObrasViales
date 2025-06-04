<?php

namespace App\Http\Controllers;

use App\Models\Trail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrailController extends Controller
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
        $machine_id = $request->input('machine_id');

        $trail = new Trail();
        $trail->km = $request->input('km');
        $trail->date = Carbon::parse($request->input('date'))->format('Y-m-d');
        $trail->use_time = $request->input('use_time');
        $trail->machine_id = $machine_id;
        $trail->save();

        $destino = $request->input('destino');

        switch($destino){
            case "construction": 
                $id_show = $request->input('id_destino');
                break;
            case "machine":
                $id_show = $machine_id;
                break;
        }
        
        return redirect()->route($destino.".show", ['id' => $id_show]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Trail $trail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trail $trail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trail $trail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trail $trail)
    {
        //
    }
}
