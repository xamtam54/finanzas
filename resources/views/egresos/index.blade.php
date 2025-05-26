<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Egresos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('egresos.create') }}"
               class="inline-block mb-6 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Nuevo Egreso
            </a>

            {{-- Formulario de filtros --}}
<form method="GET" action="{{ route('egresos.index') }}" class="mb-6 space-y-4 bg-white p-4 rounded-md shadow">
    {{-- Texto explicativo fuera del grid, centrado --}}
    <p class="text-sm text-gray-500 italic mb-4 max-w-3xl mx-auto text-center">
        Para filtrar por rango de valores, ingrese ambos campos de Valor Mínimo y Valor Máximo.
        Si solo ingresa uno, el filtro no se aplicará correctamente.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="fecha" class="block font-semibold mb-1">Filtrar por Fecha</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}"
                class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>
        <div>
            <label for="min" class="block font-semibold mb-1">Valor Mínimo</label>
            <input type="number" step="0.01" name="min" id="min" value="{{ request('min') }}"
                class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>
        <div>
            <label for="max" class="block font-semibold mb-1">Valor Máximo</label>
            <input type="number" step="0.01" name="max" id="max" value="{{ request('max') }}"
                class="w-full border border-gray-300 rounded px-3 py-2" />
        </div>
    </div>

    <div class="mt-4 flex items-center space-x-4">
        <div>
            <label for="ultimos" class="font-semibold">Mostrar últimos:</label>
            <select name="ultimos" id="ultimos" class="border border-gray-300 rounded px-3 py-2">
                <option value="" {{ request('ultimos') == '' ? 'selected' : '' }}>--</option>
                <option value="5" {{ request('ultimos') == '5' ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('ultimos') == '10' ? 'selected' : '' }}>10</option>
                <option value="20" {{ request('ultimos') == '20' ? 'selected' : '' }}>20</option>
            </select>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Filtrar
        </button>

        <a href="{{ route('egresos.index') }}" class="text-gray-600 hover:underline ml-4">Limpiar filtros</a>
    </div>
</form>


            {{-- Resultados filtrados --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($egresos as $egreso)
                    <div class="bg-white rounded-lg shadow-md p-5 hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold mb-2">Egreso #{{ $egreso->idegreso }}</h3>
                        <p><span class="font-semibold">Valor:</span> COP {{ number_format($egreso->valor, 2, ',', '.') }}</p>
                        <p><span class="font-semibold">Fecha:</span> {{ \Carbon\Carbon::parse($egreso->fecha)->format('d/m/Y') }}</p>
                        <p class="mb-4"><span class="font-semibold">Descripción:</span> {{ $egreso->descripcion }}</p>

                        <div class="flex space-x-3">
                            <a href="{{ route('egresos.show', $egreso) }}" class="text-blue-600 hover:underline">Ver</a>
                            <a href="{{ route('egresos.edit', $egreso) }}" class="text-yellow-600 hover:underline">Editar</a>
                            <form action="{{ route('egresos.destroy', $egreso) }}" method="POST" onsubmit="return confirm('¿Eliminar egreso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p>No hay egresos para mostrar.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
