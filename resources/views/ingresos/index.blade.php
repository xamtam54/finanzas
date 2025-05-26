<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ingresos') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('ingresos.create') }}"
                   class="inline-block px-5 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Nuevo Ingreso
                </a>
            </div>
            
            <form method="GET" action="{{ route('ingresos.index') }}"
            class="mb-10 bg-white p-6 rounded-lg shadow max-w-4xl mx-auto">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Fecha inicio --}}
                <div class="flex flex-col">
                <label for="inicio" class="mb-2 text-sm font-medium text-gray-700">Fecha inicio</label>
                <input type="date" id="inicio" name="inicio" value="{{ request('inicio') }}"
                    class="w-full rounded border border-gray-300 px-3 py-2 text-gray-700
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                </div>

                {{-- Fecha fin --}}
                <div class="flex flex-col">
                <label for="fin" class="mb-2 text-sm font-medium text-gray-700">Fecha fin</label>
                <input type="date" id="fin" name="fin" value="{{ request('fin') }}"
                    class="w-full rounded border border-gray-300 px-3 py-2 text-gray-700
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                </div>

                {{-- Valor mínimo --}}
                <div class="flex flex-col">
                <label for="min" class="mb-2 text-sm font-medium text-gray-700">Valor mínimo</label>
                <input type="number" step="0.01" id="min" name="min" value="{{ request('min') }}" placeholder="0"
                    class="w-full rounded border border-gray-300 px-3 py-2 text-gray-700
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                </div>

                {{-- Valor máximo --}}
                <div class="flex flex-col">
                <label for="max" class="mb-2 text-sm font-medium text-gray-700">Valor máximo</label>
                <input type="number" step="0.01" id="max" name="max" value="{{ request('max') }}" placeholder="1000"
                    class="w-full rounded border border-gray-300 px-3 py-2 text-gray-700
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
                </div>

            </div>

            {{-- Mensaje --}}
            <p class="mt-6 mb-6 text-center text-sm text-gray-500 italic">
                Ingrese ambos valores para filtrar por rango (mínimo y máximo).
            </p>

            {{-- Botones --}}
            <div class="flex justify-end space-x-4">
                <button type="submit"
                class="px-5 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700
                        focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                Aplicar filtros
                </button>
                <a href="{{ route('ingresos.index') }}"
                class="text-blue-600 font-semibold hover:underline focus:outline-none focus:ring-2 focus:ring-blue-500">
                Limpiar filtros
                </a>
            </div>

            </form>



            {{-- Lista de ingresos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse ($ingresos as $ingreso)
                    <div
                        class="bg-white rounded-lg shadow p-5 hover:shadow-lg transition flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Ingreso #{{ $ingreso->idingreso }}</h3>
                            <p><span class="font-semibold">Valor:</span> COP {{ number_format($ingreso->valor, 2, ',', '.') }}</p>
                            <p><span class="font-semibold">Fecha:</span> {{ \Carbon\Carbon::parse($ingreso->fecha)->format('d/m/Y') }}</p>
                            <p class="mt-2"><span class="font-semibold">Descripción:</span> {{ $ingreso->descripcion }}</p>
                        </div>
                        <div class="mt-4 flex space-x-4 text-sm">
                            <a href="{{ route('ingresos.show', $ingreso) }}" class="text-blue-600 hover:underline">Ver</a>
                            <a href="{{ route('ingresos.edit', $ingreso) }}" class="text-yellow-600 hover:underline">Editar</a>
                            <form action="{{ route('ingresos.destroy', $ingreso) }}" method="POST" onsubmit="return confirm('¿Eliminar ingreso?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-600">No hay ingresos para mostrar.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
