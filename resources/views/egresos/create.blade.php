<x-app-layout>
    <div class="max-w-lg mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-6">Crear Egreso</h1>

        <form action="{{ route('egresos.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            <div>
                <label for="valor" class="block font-medium mb-1">Valor</label>
                <input
                    type="number"
                    step="0.01"
                    name="valor"
                    id="valor"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('valor') }}"
                    placeholder="0.00"
                >
                @error('valor')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fecha" class="block font-medium mb-1">Fecha</label>
                <input
                    type="date"
                    name="fecha"
                    id="fecha"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('fecha', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                >
                @error('fecha')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descripcion" class="block font-medium mb-1">Descripción</label>
                <textarea
                    name="descripcion"
                    id="descripcion"
                    rows="4"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
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
                    href="{{ route('egresos.index') }}"
                    class="flex-1 text-center py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
