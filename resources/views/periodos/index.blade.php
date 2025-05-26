<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Periodos</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-gray-700">Listado de periodos activos</h3>
                <a href="{{ route('periodos.create') }}"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    + Nuevo Periodo
                </a>
            </div>

            @forelse($periodos as $periodo)
                <div class="bg-white shadow rounded-lg mb-4 p-5 border border-gray-100 hover:shadow-md transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">Periodo de {{ $periodo->cantidaddias }} días</h4>
                            <p class="text-sm text-gray-500 mt-1">Creado el {{ $periodo->created_at->format('d M Y') }}</p>
                        </div>
                        <form action="{{ route('periodos.destroy', $periodo) }}" method="POST" onsubmit="return confirm('¿Eliminar periodo?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-800 text-sm">Eliminar</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg text-center">
                    No hay periodos registrados aún.
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
