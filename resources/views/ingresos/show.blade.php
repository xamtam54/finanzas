<x-app-layout>
    <div class="max-w-3xl mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-6">Detalle del Ingreso #{{ $ingreso->idingreso }}</h1>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <p><strong>Valor:</strong> COP {{ number_format($ingreso->valor, 2) }}</p>
            <p><strong>Fecha:</strong> {{ $ingreso->fecha->format('d/m/Y') }}</p>
            <p><strong>Descripción:</strong> {{ $ingreso->descripcion ?? 'N/A' }}</p>
            <p><strong>Creado:</strong> {{ $ingreso->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Actualizado:</strong> {{ $ingreso->updated_at->format('d/m/Y H:i') }}</p>

            <a href="{{ route('ingresos.index') }}"
                class="inline-block mt-6 text-blue-600 hover:underline">
                &larr; Volver al listado
            </a>
        </div>


    </div>
</x-app-layout>
