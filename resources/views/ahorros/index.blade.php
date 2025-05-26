<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Ahorros') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('ahorros.create') }}"
               class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
               Nuevo Ahorro
            </a>

            <!-- Contenedor para hacer scroll horizontal -->
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Periodo</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Fecha Inicio</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Fecha Fin</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Valor Calculado</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($ahorros as $ahorro)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $ahorro->idahorro }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $ahorro->periodo->cantidaddias ?? 'Sin periodo' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ \Carbon\Carbon::parse($ahorro->fechainicio)->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ \Carbon\Carbon::parse($ahorro->fechafin)->format('Y-m-d') }}</td>
                                <td class="px-6 py-4 text-sm text-green-700 font-semibold whitespace-nowrap">COP {{ number_format($ahorro->calcularValorAhorro(), 2) }}</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('ahorros.show', $ahorro) }}" class="text-blue-600 hover:underline">Ver</a>
                                        <a href="{{ route('ahorros.edit', $ahorro) }}" class="text-yellow-600 hover:underline">Editar</a>
                                        <form action="{{ route('ahorros.destroy', $ahorro) }}" method="POST" onsubmit="return confirm('¿Eliminar este ahorro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay ahorros registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <strong class="text-gray-700">Total general de ahorros:</strong>
                <span class="text-green-700 font-semibold">COP {{ number_format(\App\Models\Ahorro::total(), 2) }}</span>
            </div>
        </div>
    </div>
</x-app-layout>
