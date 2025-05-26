<x-app-layout>
    <div class="container mx-auto py-6 px-4">
        <h1 class="text-4xl font-extrabold mb-8 text-gray-900">Dashboard Financiero</h1>

                <!-- Alerta Financiera -->


    @if ($alertaFinanciera)
        @php
            $isDanger = $alertaFinanciera['tipo'] === 'danger';

            $bgColor = $isDanger ? 'bg-red-100' : 'bg-yellow-100';
            $textColor = $isDanger ? 'text-red-800' : 'text-yellow-800';
            $icon = $isDanger
                ? '<svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.918-.816 1.994-1.85l.007-.15V6c0-1.054-.816-1.918-1.85-1.994L19.918 4H4.082C3.028 4 2.164 4.816 2.088 5.85L2.081 6v12c0 1.054.816 1.918 1.85 1.994l.15.006z"/></svg>'
                : '<svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m0-4h.01M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.918-.816 1.994-1.85l.007-.15V6c0-1.054-.816-1.918-1.85-1.994L19.918 4H4.082C3.028 4 2.164 4.816 2.088 5.85L2.081 6v12c0 1.054.816 1.918 1.85 1.994l.15.006z"/></svg>';
        @endphp

        <div class="flex items-start {{ $bgColor }} {{ $textColor }} border-l-4 {{ $isDanger ? 'border-red-600' : 'border-yellow-500' }} p-4 rounded-lg shadow-sm mb-6 relative">
            <div class="mr-3">{!! $icon !!}</div>
            <div class="flex-1">
                <p class="font-bold">
                    {{ $isDanger ? 'Alerta' : 'Advertencia' }}
                </p>
                <p class="text-sm mt-1">{{ $alertaFinanciera['mensaje'] }}</p>
            </div>
            <button onclick="this.parentElement.remove();" class="ml-4 text-xl font-bold leading-none focus:outline-none hover:text-gray-700">&times;</button>
        </div>
    @endif
        <!-- Cards resumen -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="p-6 rounded-xl bg-gradient-to-tr from-green-200 to-green-400 text-green-900 shadow-sm transform hover:scale-105 transition-transform">
            <h5 class="text-xl font-semibold mb-2 tracking-wide">Total Ingresos</h5>
            <p class="text-3xl font-bold">{{ number_format($totalIngresos, 2) }}</p>
            <p class="text-sm mt-1 opacity-80">Después de Ahorros: <strong>{{ number_format($totalIngresosMenosAhorro, 2) }}</strong></p>
            <p class="text-sm mt-1 opacity-80">Después de Egresos: <strong>{{ number_format($totalIngresosMenosEgresos, 2) }}</strong></p>

        </div>

        <div class="p-6 rounded-xl bg-gradient-to-tr from-red-200 to-red-400 text-red-900 shadow-sm transform hover:scale-105 transition-transform">
            <h5 class="text-xl font-semibold mb-2 tracking-wide">Total Egresos</h5>
            <p class="text-3xl font-bold">{{ number_format($totalEgresos, 2) }}</p>
        </div>

        <div class="p-6 rounded-xl bg-gradient-to-tr from-blue-200 to-blue-400 text-blue-900 shadow-sm transform hover:scale-105 transition-transform">
            <h5 class="text-xl font-semibold mb-2 tracking-wide">Total Ahorros</h5>
            <p class="text-3xl font-bold">{{ number_format($totalAhorros, 2) }}</p>
        </div>

        <div class="p-6 rounded-xl bg-yellow-50 text-yellow-900 shadow-sm overflow-auto max-h-48">
            <h5 class="text-xl font-semibold mb-3 tracking-wide">Gastos con Alerta (&lt; {{ $limiteAlerta }})</h5>
            <ul class="list-disc list-inside space-y-1 text-yellow-900">
                @forelse($gastosAlerta as $gasto)
                    <li>{{ $gasto->descripcion }}: <span class="font-semibold">{{ number_format($gasto->valor, 2) }}</span></li>
                @empty
                    <li>No hay gastos con alerta</li>
                @endforelse
            </ul>
        </div>

</div>

        <!-- Gráficas -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-12">
            <div class="bg-white rounded-xl shadow p-6">
                <h4 class="text-2xl font-semibold mb-6 text-gray-800">Ingresos vs Egresos (últimos 6 meses)</h4>
                <canvas id="chartIngresosEgresos" class="w-full h-64"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h4 class="text-2xl font-semibold mb-6 text-gray-800">Ahorros Mensuales (últimos 6 meses)</h4>
                <canvas id="chartAhorros" class="w-full h-64"></canvas>
            </div>
        </div>

        <!-- Listados últimos movimientos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <div class="bg-white rounded-xl shadow p-6 overflow-auto max-h-96">
                <h4 class="text-2xl font-semibold mb-6 text-gray-800">Últimos 10 Ingresos</h4>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    @foreach($ultimosIngresos as $ingreso)
                        <li>
                            <span class="font-semibold">{{ $ingreso->fecha }}</span> - {{ $ingreso->descripcion }}: <span class="text-green-600 font-bold">{{ number_format($ingreso->valor, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="bg-white rounded-xl shadow p-6 overflow-auto max-h-96">
                <h4 class="text-2xl font-semibold mb-6 text-gray-800">Últimos 10 Egresos</h4>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    @foreach($ultimosEgresos as $egreso)
                        <li>
                            <span class="font-semibold">{{ $egreso->fecha }}</span> - {{ $egreso->descripcion }}: <span class="text-red-600 font-bold">{{ number_format($egreso->valor, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos ejemplo para las gráficas, cámbialos por tus datos reales en PHP o JSON
        const meses = @json($mesesUltimos6); // ej: ['Nov', 'Dic', 'Ene', 'Feb', 'Mar', 'Abr']
        const ingresosMes = @json($ingresosPorMes); // ej: [1000, 1200, 900, 1300, 1250, 1400]
        const egresosMes = @json($egresosPorMes); // ej: [700, 850, 800, 750, 900, 850]
        const ahorrosMes = @json($ahorrosPorMes); // ej: [300, 350, 100, 550, 350, 550]

        // Ingresos vs Egresos
        const ctxIE = document.getElementById('chartIngresosEgresos').getContext('2d');
        new Chart(ctxIE, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [
                    {
                        label: 'Ingresos',
                        data: ingresosMes,
                        backgroundColor: 'rgba(34,197,94, 0.7)', // verde
                        borderRadius: 6,
                    },
                    {
                        label: 'Egresos',
                        data: egresosMes,
                        backgroundColor: 'rgba(239,68,68, 0.7)', // rojo
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false },
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Ahorros Mensuales
        const ctxAhorros = document.getElementById('chartAhorros').getContext('2d');
        new Chart(ctxAhorros, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Ahorros',
                    data: ahorrosMes,
                    fill: true,
                    backgroundColor: 'rgba(59,130,246,0.3)', // azul claro
                    borderColor: 'rgba(59,130,246,1)', // azul
                    tension: 0.3,
                    pointRadius: 5,
                    pointBackgroundColor: 'rgba(59,130,246,1)',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { mode: 'index', intersect: false },
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</x-app-layout>
