<x-app-layout>
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Editar Ahorro #{{ $ahorro->idahorro }}</h1>

    <form action="{{ route('ahorros.update', $ahorro) }}" method="POST" class="space-y-6 bg-white p-8 rounded-lg shadow-lg max-w-lg mx-auto">
        @csrf
        @method('PUT')

        <div>
            <label for="fechainicio" class="block text-gray-700 font-medium mb-2">Fecha Inicio</label>
            <input type="date" name="fechainicio" id="fechainicio" required
                class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition"
                value="{{ old('fechainicio', $ahorro->fechainicio ? \Carbon\Carbon::parse($ahorro->fechainicio)->format('Y-m-d') : '') }}">
            @error('fechainicio')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="fechafin" class="block text-gray-700 font-medium mb-2">Fecha Fin</label>
            <input type="date" name="fechafin" id="fechafin" required readonly
                class="w-full border border-gray-300 rounded-md px-4 py-3 bg-gray-100 cursor-not-allowed focus:outline-none"
                value="{{ old('fechafin', $ahorro->fechafin ? \Carbon\Carbon::parse($ahorro->fechafin)->format('Y-m-d') : '') }}">

            @error('fechafin')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="periodo_id" class="block text-gray-700 font-medium mb-2">Periodo</label>
            <select name="periodo_id" id="periodo_id" required
                class="w-full border border-gray-300 rounded-md px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent transition">
                <option value="">Seleccione un periodo</option>
                @foreach ($periodos as $periodo)
                    <option value="{{ $periodo->idperiodo }}" {{ old('periodo_id', $ahorro->periodo_id) == $periodo->idperiodo ? 'selected' : '' }}>
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

            <a href="{{ route('ahorros.index') }}"
                class="flex-1 text-center border border-gray-300 rounded-md py-3 font-semibold text-gray-700 hover:bg-gray-100 shadow-sm transition">
                Cancelar
            </a>
        </div>
    </form>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fechainicioInput = document.getElementById('fechainicio');
        const periodoSelect = document.getElementById('periodo_id');
        const fechafinInput = document.getElementById('fechafin');

        const periodos = @json($periodos->pluck('cantidaddias', 'idperiodo'));

        function calcularFechaFin() {
            const inicio = new Date(fechainicioInput.value);
            const dias = parseInt(periodos[periodoSelect.value]);

            if (!isNaN(inicio.getTime()) && !isNaN(dias)) {
                inicio.setDate(inicio.getDate() + dias);
                const year = inicio.getFullYear();
                const month = String(inicio.getMonth() + 1).padStart(2, '0');
                const day = String(inicio.getDate()).padStart(2, '0');
                fechafinInput.value = `${year}-${month}-${day}`;
            }
        }

        fechainicioInput.addEventListener('change', calcularFechaFin);
        periodoSelect.addEventListener('change', calcularFechaFin);

        // Ejecutar al cargar por si ya hay valores
        calcularFechaFin();
    });
</script>
