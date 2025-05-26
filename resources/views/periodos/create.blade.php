<x-app-layout>
    <div class="max-w-lg mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-6">Crear Periodo</h1>

        <form action="{{ route('periodos.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            <div>
                <label for="cantidaddias" class="block font-medium mb-1">Cantidad de Días</label>
                <input
                    type="number"
                    name="cantidaddias"
                    id="cantidaddias"
                    required
                    value="{{ old('cantidaddias') }}"
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('cantidaddias')
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
                    href="{{ route('periodos.index') }}"
                    class="flex-1 text-center py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
