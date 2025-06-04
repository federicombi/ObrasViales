<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Obras por provincia') }}
        </h2>
        <link rel="stylesheet" href="{{ asset('css/general.css') }}">
        <link rel="stylesheet" href="{{ asset('css/obras.css') }}">
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="contenedor sm:flex space-x-4 sm:-my-px sm:ms-2 overflow-x-auto">
                    <!-- BUSCADOR  -->
                    <div id="buscador" class="buscador flex items-center justify-center flex-col gap-4" style="width: 30%">
                        <form method="GET" action="{{route('construction.show', '0')}}" >
                            <h1 class="titulito">Buscar una Obra:</h1>
                            <select id="select_provincia" name="select_provincia">
                                <option selected disabled> Provincia... </option>
                                @foreach ($provincias as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select><br>
                            <select id="select_construction" name="select_construction" disabled>
                                <option selected disabled> Obra... </option>
                            </select><br>
                            <button type="submit" class="boton ok_button">Cargar datos</button>
                        </form >
                        
                    </div><br>
                    <!-- MOSTRADOR  -->

                    <div id="mostrador" class="mostrador" style="width: 70%">
                        
                        @isset($construction)
                            <div class='header_obra'>
                                <img src="{{ asset('images/obra.JPG') }}" alt="{{$construction->name}}" class="foto_obra" >
                                <h1> <span class="dato_destacado">{{$construction->name}}</span> </h1>
                                <div class="presentacion">
                                    <ul style="display: flex; gap: 2rem; list-style: none; padding: 0;">
                                        <li>
                                            <h2>Inicio: <span class="dato_destacado">{{$construction->start_date->format('d/m/y')}}</span></h2>
                                        </li>
                                        <li>
                                            <h2>Fin programado: <span class="dato_destacado">{{ $construction->initial_end_date->format('d/m/y') }}</span></h2>
                                        </li>
                                        <li>
                                            <h2>Fin: <span class="dato_destacado">
                                            @if (isset($construction->end_date))
                                                {{ $construction->end_date->format('d/m/y')}}
                                            @else
                                                {{'- - -'}}
                                            @endif</span>
                                        </h2>
                                        </li>
                                    </ul>
                                    <h2>Estado actual: 
                                        <span @class(['dato_destacado', 'en_actividad' => !isset($construction->end_date)])>
                                            {{$construction->construction_status->name}}
                                        </span>
                                    </h2>
                                    <h2>Ubicacion: <span class="dato_destacado">{{$construction->region->name}}, {{$construction->region->province->name}}</span>
                                    </h2>
                                    <form id="allocate_form" class="allocate_form" method="GET" action="{{route('allocation.create')}}">
                                        @csrf
                                        <input type="number" id="id_construction" name="id_construction" value="{{$construction->id}}" hidden>
                                        <button type="submit" id="allocate_button" class="boton allocate_button"> Asignar máquina</button>
                                    </form>
                                </div>
                            </div><br>
                            <h3 style="text-align:center;"> MÁQUINAS ASIGNADAS </h3>
                            <!-- Body: asignaciones de la maquina  -->
                             <div class="asignaciones">
                                @if ($construction->allocations->isNotEmpty())
                                    @foreach ($construction->allocations as $allocation)
                                        <div @class(['asignacion','asignacion_abierta' => !isset($allocation->allocation_end_motive),'asignacion_cerrada' => isset($allocation->allocation_end_motive)])>
                                            <img src="{{ asset('images/'.$allocation->machine->machine_model->machine_type->code.'.png') }}" alt="{{$allocation->machine->machine_model->machine_type->name}}" class="foto_maquina" >
                                            <h2 style=""><span class="dato_asignacion">{{$allocation->machine->machine_model->machine_type->name.', '.$allocation->machine->machine_model->machine_brand->name.' '.$allocation->machine->machine_model->name}}</span></h2>                                            
                                            <ul style="display: flex; gap: 1rem; list-style: none; padding: 0;">
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
                                                        @isset($allocation->machine->trails)
                                                            @php
                                                                $suma = 0;
                                                                $ahora = new DateTime;
                                                                foreach ($allocation->machine->trails as $trail) {
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

                                            <form id="add_km_form" class="add_km_form"  method="POST" action="{{route('trail.store')}}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" id="add_km_button{{$allocation->machine->id}}" class="boton add_km_button" data-id_machine="{{$allocation->machine->id}}" data-id_destino="{{$construction->id}}"> Registrar KM </button>
                                            </form>
                                            @unless(isset($allocation->allocation_end_motive))
                                                <form id="end_allocation_form" method="POST" action="{{route('allocation.update')}}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button" id="end_allocation" class="boton end_allocation_button" data-id_allocation="{{$allocation->id}}" data-machine="{{$allocation->machine->series}}" data-construction="{{$construction->name}}, {{$construction->region->name}} - {{$construction->region->province->name}}" data-machine_type="{{$allocation->machine->machine_model->machine_type->name}}" data-link_motivos="{{route('end_motives')}}" data-allocation="{{$allocation}}"> Finalizar </button>
                                                </form>
                                            @endunless
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
@vite('resources/js/obras.js')