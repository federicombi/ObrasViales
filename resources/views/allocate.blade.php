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
                    
                    <div id="container" class="container flex items-center justify-center flex-col gap-4" style="width: 30%">
                        <form method="POST" action="" >
                            <h1 class="titulito">Asignar a obra:</h1>
                            <select id="select_tipo" name="select_tipo">
                                <option selected disabled> Tipo de maquina... </option>
                                @foreach ($tipos_de_maquinas as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->name }}</option>
                                @endforeach
                            </select><br>
                        </form >
                        
                    </div><br>

                    @isset($construction)
                        {{'aca esta la construction:'.$construction->name}}<br>
                    @endisset

                    @isset($tipos_de_maquinas)
                        @foreach($tipos_de_maquinas as $type)
                        {{$type->name}}<br>
                        @endforeach
                    @endisset

                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
