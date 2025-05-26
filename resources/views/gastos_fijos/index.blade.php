<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Gastos Fijos') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <a href="{{ route('gastos-fijos.create') }}"
               class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
               Nuevo Gasto Fijo
            </a>

            <!-- Contenedor para scroll horizontal -->
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Descripción</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Periodo</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Valor</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Fecha de Inicio</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($gastosFijos as $gasto)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $gasto->idgastofijo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $gasto->descripcion }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $gasto->periodo->cantidaddias ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">COP {{ number_format($gasto->valor, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">{{ $gasto->fecha_inicio }}</td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <a href="{{ route('gastos-fijos.show', $gasto) }}" class="text-blue-600 hover:underline mr-3">Ver</a>
                                    <a href="{{ route('gastos-fijos.edit', $gasto) }}" class="text-yellow-600 hover:underline mr-3">Editar</a>
                                    <form action="{{ route('gastos-fijos.destroy', $gasto) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar gasto fijo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
