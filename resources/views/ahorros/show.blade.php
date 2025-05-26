<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detalle del Ahorro') }}</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2 text-gray-700">Información General</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-800">
                    <p><strong>ID:</strong> {{ $ahorro->idahorro }}</p>
                    <p><strong>Fecha Inicio:</strong> {{ $ahorro->fechainicio->format('d/m/Y') }}</p>
                    <p><strong>Fecha Fin:</strong> {{ $ahorro->fechafin->format('d/m/Y') }}</p>
                    <p><strong>Periodo:</strong> {{ $ahorro->periodo->cantidaddias ?? 'N/A' }} días</p>
                </div>
            </div>

            <hr class="my-6 border-gray-300">

            <div class="mb-4 flex items-center justify-between">
                <h3 class="font-semibold text-lg text-gray-700">Ingresos relacionados</h3>
                <a href="{{ route('ahorros.ingresos.create', $ahorro) }}"
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm font-semibold shadow">
                    + Agregar Ingreso
                </a>
            </div>

            @if($ahorro->ingresos->isEmpty())
                <p class="text-gray-600">No hay ingresos asociados a este ahorro.</p>
            @else
                <table class="min-w-full border border-gray-300 rounded overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">Valor</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">Porcentaje (%)</th>
                            <th class="border border-gray-300 px-4 py-2 text-right">Valor aplicado</th>
                            <th class="border border-gray-300 px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ahorro->ingresos as $ingreso)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 px-4 py-2">{{ $ingreso->idingreso }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-right">${{ number_format($ingreso->valor, 2) }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-right">{{ $ingreso->pivot->porcentaje }}%</td>
                                <td class="border border-gray-300 px-4 py-2 text-right">
                                    ${{ number_format(($ingreso->valor * $ingreso->pivot->porcentaje) / 100, 2) }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <form action="{{ route('ahorros.ingresos.eliminar', ['ahorro' => $ahorro->idahorro, 'ingreso' => $ingreso->idingreso]) }}"
                                          method="POST" onsubmit="return confirm('¿Eliminar este ingreso del ahorro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs font-semibold">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div class="mt-6 text-right">
                <a href="{{ route('ahorros.index') }}" class="text-blue-600 hover:underline font-medium">← Volver a la lista</a>
            </div>
        </div>
    </div>
</x-app-layout>
