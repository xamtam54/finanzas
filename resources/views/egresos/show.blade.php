<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Detalle del Egreso</h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
            <p><strong>Valor:</strong> COP {{ number_format($egreso->valor, 2) }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($egreso->fecha)->format('d/m/Y') }}</p>
            <p><strong>Descripción:</strong> {{ $egreso->descripcion }}</p>

            <a href="{{ route('egresos.index') }}" class="inline-block mt-4 text-blue-600">← Volver a la lista</a>
        </div>
    </div>
</x-app-layout>
