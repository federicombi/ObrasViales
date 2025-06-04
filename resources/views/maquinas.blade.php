<div>
    <!-- aca se van a ver las maquinas por tipo y modelo y etc. -->
     <link rel="stylesheet" href="{{ asset('css/general.css') }}">
    <link rel="stylesheet" href="{{ asset('css/maquinas.css') }}">
</div>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('MAQUINAS') }}
        </h2>
        
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class=" bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="contenedor sm:flex space-x-4 sm:-my-px sm:ms-2 overflow-x-auto">
                    <!-- BUSCADOR  -->
                    <div id="buscador" class="buscador flex items-center justify-center flex-col gap-4" style="width: 30%">
                        <form method="GET" action="{{route('machine.show', 0)}}" >
                            <h1 class="titulito">Buscar una maquina:</h1>
                            <select id="select_tipo" name="select_tipo">
                                <option selected disabled> Tipo de maquina... </option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                @endforeach
                            </select><br>
                            <select id="select_maquina" name="select_maquina" disabled>
                                <option selected disabled> Maquina... </option>
                            </select><br>
                            <button type="submit" class="boton ok_button">Cargar datos</button>
                            
                        </form >
                        
                    </div>
                    <!-- MOSTRADOR  -->

                    <div id="mostrador" class="mostrador" style="width: 70%">
                        
                        @isset($machine)
                            <!-- Header: datos de la maquina  -->
                            <div class='header_maquina'>
                                <img src="{{ asset('images/'.$machine->machine_model->machine_type->code.'.png') }}" alt="{{$machine->machine_model->machine_type->code}}" class="foto_maquina" >
                                <h1>{{$machine->machine_model->machine_type->name}}: <span class="dato_destacado">{{$machine->series}}</span></h1>
                                <div class="presentacion">
                                    <ul style="display: flex; gap: 2rem; list-style: none; padding: 0;"><!-- MArca, modelo y serie  -->
                                        <li>
                                            <h2>Marca: <span class="dato_destacado">{{ $machine->machine_model->machine_brand->name }}</span></h2>
                                        </li>
                                        <li>
                                            <h2>Modelo: <span class="dato_destacado">{{ $machine->machine_model->name }}</span></h2>
                                        </li>
                                        <li>
                                            <h2>Serie: <span class="dato_destacado">{{ $machine->series }}</span></h2>
                                        </li>
                                    </ul>
                                    <h2>Kilometraje: <span class="dato_destacado">
                                        @isset($machine->trails)
                                            @php
                                                $suma = 0;
                                                foreach ($machine->trails as $trail) {
                                                        $suma+= $trail->km;
                                                }
                                                echo $suma.' km';
                                            @endphp
                                        @endisset
                                    </span></h2>
                                    <h2>Estado actual: <span class="dato_destacado">{{$machine->machine_status->name}}</span></h2>
                                    <h2>Ubicacion: <span class="dato_destacado">
                                        @if ($machine->allocations->isNotEmpty())
                                            {{ $machine->allocations->first()->construction->region->name.', '.$machine->allocations->first()->construction->region->province->name}}
                                        @else
                                            No asignada
                                        @endif</span>
                                    </h2>
                                    <form id="add_km_form" class="add_km_form"  method="POST" action="{{route('trail.store')}}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" id="add_km_button" class="boton add_km_button" data-id_machine="{{$machine->id}}"> Registrar KM </button>
                                    </form>
                                    @unless(isset($allocation->allocation_end_motive))
                                    <!-- FORM O LINK PARA LA PAGINA DONDE SE HACE LA ALLOCATION.  -->
                                        <form id="allocate_form" class="allocate_form" method="POST" action="">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" id="allocate_button" class="boton allocate_button" data-id="{{$machine->id}}"> Asignar a obra</button>
                                        </form>
                                    @endunless
                                </div>
                            </div>
                            <h3 style="text-align:center;">ASIGNACIONES</h3>
                            <!-- Body: asignaciones de la maquina  -->
                            <div class="asignaciones">
                                @if ($machine->allocations->isNotEmpty())
                                    @foreach ($machine->allocations as $allocation)
                                    <!--      ACA VA CADA ASIGNACIÓN -->
                                        <div @class(['asignacion','asignacion_abierta' => !isset($allocation->allocation_end_motive),'asignacion_cerrada' => isset($allocation->allocation_end_motive)])> 
                                            @unless(isset($allocation->allocation_end_motive))
                                                <form id="end_allocation_form" method="POST" action="{{route('allocation.update')}}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <h1 style="text-align:center;"><b>Obra Actual</b></h1>
                                                    <button type="button" id="end_allocation" class="boton end_allocation_button" data-id="{{$allocation->id}}" data-machine="{{$machine->series}}" data-construction="{{$allocation->construction->name}}, {{$allocation->construction->region->name}} - {{$allocation->construction->region->province->name}}" data-machine_type="{{$machine->machine_model->machine_type->name}}" data-link_motivos="{{route('end_motives')}}" data-allocation="{{$allocation}}"> Finalizar </button>
                                                </form>
                                            @endunless
                                            <h2>Obra: <span class="dato_asignacion">{{$allocation->construction->name.', '.$allocation->construction->region->province->name}}</span></h2>                                            
                                            <ul style="display: flex; gap: 2rem; list-style: none; padding: 0;">
                                                <li><h2>Desde: <span class="dato_asignacion">{{$allocation->start_date->format('d/m/y')}}</span></h2></li>
                                                <li><h2>Hasta: <span class="dato_asignacion">
                                                    @isset($allocation->end_date)
                                                        {{$allocation->end_date->format('d/m/y')}}
                                                    @else
                                                       {{'Completar etapa'}}
                                                    @endisset 
                                                </span></h2></li>
                                                <li><h2>Motivo de fin: <span class="dato_destacado">
                                                    @isset($allocation->allocation_end_motive)
                                                        {{$allocation->allocation_end_motive->motive}}
                                                    @else
                                                        <i><span class="en_actividad">{{"(Aun en Produccion)"}}</span></i>
                                                    @endisset 
                                                </span></h2></li>
                                            </ul>
                                            <h2>KM utilizados: <span class="dato_asignacion">
                                                        @isset($machine->trails)
                                                            @php
                                                                $suma = 0;
                                                                $ahora = new DateTime;
                                                                foreach ($machine->trails as $trail) {
                                                                    $fecha_trail = new DateTime($trail->date);
                                                                    $start_date = new DateTime($allocation->start_date);
                                                                    if(isset($allocation->end_date)){
                                                                        $end_date = new DateTime($allocation->end_date);
                                                                    }else{
                                                                        $end_date = $ahora;
                                                                    }

                                                                    if ($fecha_trail >= $start_date && $fecha_trail <= $end_date) {
                                                                        $suma+= $trail->km;
                                                                    }
                                                                }
                                                                echo $suma.' km';
                                                            @endphp
                                                        @endisset
                                            </span></h2>
                                            
                                        </div>
                                    @endforeach
                                @else
                                    No asignada
                                @endif
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite('resources/js/maquinas.js')
