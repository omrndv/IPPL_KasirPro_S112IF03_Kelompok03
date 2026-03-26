<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard - KasirPro' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            "50": "#eff6ff",
                            "100": "#dbeafe",
                            "200": "#bfdbfe",
                            "300": "#93c5fd",
                            "400": "#60a5fa",
                            "500": "#3b82f6",
                            "600": "#2563eb",
                            "700": "#1d4ed8",
                            "800": "#1e40af",
                            "900": "#1e3a8a"
                        }
                    }
                }
            }
        }
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-50 antialiased text-gray-900">

    @include('componen.navbar')

    @include('componen.sidebar')

    <div class="p-4 sm:ml-64 pt-20 min-h-screen flex flex-col bg-gray-50 border-l border-gray-200">
        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="mt-auto py-4 text-center text-sm text-gray-500">
            &copy; 2026 KasirPro - Kelompok 3.
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>
