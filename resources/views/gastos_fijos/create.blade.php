<x-app-layout>
    <div class="max-w-lg mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-6">Crear Gasto Fijo</h1>

        <form action="{{ route('gastos-fijos.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            <div>
                <label for="descripcion" class="block font-medium mb-1">Descripción</label>
                <input
                    type="text"
                    name="descripcion"
                    id="descripcion"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                    value="{{ old('descripcion') }}"
                >
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="valor" class="block font-medium mb-1">Valor</label>
                <input
                    type="number"
                    step="0.01"
                    name="valor"
                    id="valor"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                    value="{{ old('valor') }}"
                >
                @error('valor')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="periodo_id" class="block font-medium mb-1">Periodo</label>
                <select
                    name="periodo_id"
                    id="periodo_id"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                    <option value="">Seleccione un periodo</option>
                    @foreach($periodos as $periodo)
                        <option value="{{ $periodo->idperiodo }}" {{ old('periodo_id') == $periodo->idperiodo ? 'selected' : '' }}>
                            {{ $periodo->cantidaddias }} días
                        </option>
                    @endforeach
                </select>
                @error('periodo_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="fecha_inicio" class="block text-gray-700 font-bold mb-2">Fecha Inicio:</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 @error('fecha_inicio')  @enderror">
                @error('fecha_inicio')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex space-x-4">
                <button
                    type="submit"
                    class="flex-1 bg-blue-600 text-white rounded-md py-3 text-lg font-semibold hover:bg-blue-700 transition"
                >
                    Guardar
                </button>

                <a
                    href="{{ route('gastos-fijos.index') }}"
                    class="flex-1 text-center py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
