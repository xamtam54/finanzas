<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Agregar Ingreso al Ahorro #{{ $ahorro->idahorro }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto">

        {{-- Mensajes de alerta --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                {{ session('warning') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ahorros.ingresos.store', $ahorro) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="ingreso_id" class="block font-medium mb-1">Ingreso</label>
                <select name="ingreso_id" id="ingreso_id" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione un ingreso</option>
                    @foreach ($ingresos as $ingreso)
                        <option value="{{ $ingreso->idingreso }}" {{ old('ingreso_id') == $ingreso->idingreso ? 'selected' : '' }}>
                            Ingreso #{{ $ingreso->idingreso }} - ${{ number_format($ingreso->valor, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-6">
                <label for="porcentaje" class="block font-medium mb-1">Porcentaje (%)</label>
                <input
                    type="number"
                    name="porcentaje"
                    id="porcentaje"
                    class="w-full border rounded px-3 py-2"
                    min="0" max="100" step="0.01"
                    value="{{ old('porcentaje') }}"
                    required
                >
            </div>

            <div class="flex space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Asociar Ingreso
                </button>

                <a href="{{ route('ahorros.show', $ahorro) }}" class="inline-block px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
