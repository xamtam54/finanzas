<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name', 'FinanzasApp') }}</title>

    {{-- Estilos y scripts compilados por Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">

    {{-- Header fijo con sombra --}}
    @include('partials.header')

    {{-- Contenido principal con padding y animación --}}
    <main class="flex-1 container mx-auto px-6 py-8 animate-fade-in">
        {{ $slot ?? '' }}
    </main>

    {{-- Footer opcional --}}
    <footer class="bg-white text-sm text-gray-500 border-t py-4 mt-auto">
        <div class="container mx-auto px-6 text-center">
            © {{ now()->year }} {{ config('app.name', 'FinanzasApp') }}. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
