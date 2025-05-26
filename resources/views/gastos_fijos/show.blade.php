<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Detalle del Gasto Fijo</h2>
    </x-slot>

    <div class="py-4 max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <p><strong>Descripción:</strong> {{ $gastoFijo->descripcion }}</p>
        <p><strong>Valor:</strong> COP {{ number_format($gastoFijo->valor, 2) }}</p>
        <p><strong>Fecha de inicio:</strong> {{ $gastoFijo->fecha_inicio->format('d/m/Y') }}</p>
        <p><strong>Periodo:</strong> {{ $gastoFijo->periodo->cantidaddias }} días</p>

        <h3 class="mt-6 font-semibold">Egresos relacionados:</h3>
        @if($gastoFijo->egresos->isEmpty())
            <p>No hay egresos asociados.</p>
        @else
            <ul class="list-disc list-inside">
                @foreach($gastoFijo->egresos as $egreso)
                    <li>
                        {{ $egreso->fecha->format('d/m/Y') }} - ${{ number_format($egreso->valor, 2) }} - {{ $egreso->descripcion ?? 'Sin descripción' }}
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('gastos-fijos.index') }}" class="inline-block mt-6 text-blue-600 hover:underline">Volver al listado</a>
    </div>
</x-app-layout>
