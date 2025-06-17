<link rel="stylesheet" href="{{ asset('css/general.css') }}">
<link rel="stylesheet" href="{{ asset('css/allocate.css') }}">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Asignar máquinas a obras') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 text-gray-900">
                    
                    <div id="container" class="container flex items-center justify-center flex-col gap-4">
                        <form method="POST" action="" id="allocate_form" class="allocate_form" >
                            <h1 class="titulito">Asignar a obra:</h1>
                            <select id="select_obra" name="select_obra">
                                <option selected disabled> Obra... </option>
                                @foreach ($obras as $construction)
                                    <option value="{{ $construction->id }}">{{ $construction->name }}</option>
                                @endforeach
                            </select><button type="button" class="boton ok_button" id="new_construction">Nueva Obra</button><br><br>
                            <select id="select_tipo" name="select_tipo">
                                <option selected disabled> Tipo de maquina... </option>
                                @foreach ($tipos_de_maquinas as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                @endforeach
                            </select><br><br>
                            <select id="select_maquina" name="select_maquina" disabled>
                                <option selected disabled> Maquina... </option>
                            </select><br>
                            <button type="button" class="boton ok_button" id="ok_button" >Confirmar</button>
                        </form >
                        
                    </div><br>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite('resources/js/allocate.js')
