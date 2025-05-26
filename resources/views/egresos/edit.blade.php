<x-app-layout>
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Editar Egreso #{{ $egreso->idegreso }}</h1>

    <form action="{{ route('egresos.update', $egreso) }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
        @csrf
        @method('PUT')

        <div>
            <label for="valor" class="block text-gray-700 font-medium mb-2">Valor</label>
            <input type="number" step="0.01" name="valor" id="valor" required
                class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                value="{{ old('valor', $egreso->valor) }}">
            @error('valor')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="fecha" class="block text-gray-700 font-medium mb-2">Fecha</label>
            <input type="date" name="fecha" id="fecha" required
                class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                value="{{ old('fecha', \Carbon\Carbon::parse($egreso->fecha)->format('Y-m-d')) }}">
            @error('fecha')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="descripcion" class="block text-gray-700 font-medium mb-2">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4"
                class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition">{{ old('descripcion', $egreso->descripcion) }}</textarea>
            @error('descripcion')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex space-x-4 mt-6">
            <button type="submit"
                class="flex-1 bg-yellow-600 text-white rounded-md py-3 font-semibold hover:bg-yellow-700 shadow-md transition">
                Actualizar
            </button>

            <a href="{{ route('egresos.index') }}"
                class="flex-1 text-center border border-gray-300 rounded-md py-3 font-semibold text-gray-700 hover:bg-gray-100 shadow-sm transition">
                Cancelar
            </a>
        </div>
    </form>
</x-app-layout>
