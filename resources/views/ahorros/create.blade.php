<x-app-layout>
    <div class="max-w-lg mx-auto py-6 px-4">
        <h1 class="text-2xl font-bold mb-6">Crear Ahorro</h1>

        <form action="{{ route('ahorros.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
            @csrf

            <div>
                <label for="fechainicio" class="block font-medium mb-1">Fecha Inicio</label>
                <input
                    type="date"
                    name="fechainicio"
                    id="fechainicio"
                    required
                    class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                    value="{{ old('fechainicio', now()->toDateString()) }}"
                >
                @error('fechainicio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fechafin" class="block font-medium mb-1">Fecha Fin</label>
                <input
                    type="date"
                    name="fechafin"
                    id="fechafin"
                    required
                    readonly
                    class="w-full bg-gray-100 cursor-not-allowed border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                    value="{{ old('fechafin') }}"
                >


                @error('fechafin')
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
                    @foreach ($periodos as $periodo)
                        <option value="{{ $periodo->idperiodo }}"
                            data-dias="{{ $periodo->cantidaddias }}"
                            {{ old('periodo_id') == $periodo->idperiodo ? 'selected' : '' }}>
                            {{ $periodo->cantidaddias }} días
                        </option>
                    @endforeach

                </select>
                @error('periodo_id')
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
                    href="{{ route('ahorros.index') }}"
                    class="flex-1 text-center py-3 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition"
                >
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const periodoSelect = document.getElementById('periodo_id');
        const fechainicioInput = document.getElementById('fechainicio');
        const fechafinInput = document.getElementById('fechafin');

        function calcularFechaFin() {
            const dias = parseInt(periodoSelect.options[periodoSelect.selectedIndex]?.dataset.dias || 0);
            const fechaInicio = new Date(fechainicioInput.value);

            if (!isNaN(dias) && fechainicioInput.value) {
                const nuevaFecha = new Date(fechaInicio);
                nuevaFecha.setDate(nuevaFecha.getDate() + dias);
                fechafinInput.value = nuevaFecha.toISOString().split('T')[0];
            }
        }

        // Al cambiar el periodo o fecha de inicio
        periodoSelect.addEventListener('change', calcularFechaFin);
        fechainicioInput.addEventListener('change', calcularFechaFin);

        // Inicializar al cargar si hay valor seleccionado
        calcularFechaFin();
    });
</script>
