<x-app-layout>
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Editar Gasto Fijo #{{ $gastoFijo->idgastofijo }}</h1>

    <form action="{{ route('gastos-fijos.update', $gastoFijo->idgastofijo) }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
        @csrf
        @method('PUT')

        <div>
            <label for="descripcion" class="block text-gray-700 font-medium mb-2">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" required
                class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                value="{{ old('descripcion', $gastoFijo->descripcion) }}">
            @error('descripcion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="valor" class="block text-gray-700 font-medium mb-2">Valor</label>
            <input type="number" step="0.01" name="valor" id="valor" required
                class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                value="{{ old('valor', $gastoFijo->valor) }}">
            @error('valor')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="fecha_inicio" class="block text-gray-700 font-bold mb-2">Fecha Inicio:</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio"
                value="{{ old('fecha_inicio', $gastoFijo->fecha_inicio ? \Carbon\Carbon::parse($gastoFijo->fecha_inicio)->format('Y-m-d') : '') }}"
                class="w-full border border-gray-300 rounded px-3 py-2 @error('fecha_inicio') @enderror">
            @error('fecha_inicio')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="periodo_id" class="block text-gray-700 font-medium mb-2">Periodo</label>
            <select name="periodo_id" id="periodo_id" required
                class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                <option value="">Seleccione un periodo</option>
                @foreach($periodos as $periodo)
                    <option value="{{ $periodo->idperiodo }}" {{ old('periodo_id', $gastoFijo->periodo_id) == $periodo->idperiodo ? 'selected' : '' }}>
                        {{ $periodo->cantidaddias }} días
                    </option>
                @endforeach
            </select>
            @error('periodo_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4 mt-6">
            <button type="submit"
                class="flex-1 bg-yellow-600 text-white rounded-md py-3 font-semibold hover:bg-yellow-700 shadow-md transition">
                Actualizar
            </button>

            <a href="{{ route('gastos-fijos.index') }}"
                class="flex-1 text-center border border-gray-300 rounded-md py-3 font-semibold text-gray-700 hover:bg-gray-100 shadow-sm transition">
                Cancelar
            </a>
        </div>
    </form>
</x-app-layout>
