<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>@yield('title', 'Laravel')</title>
        
        <!-- Fonts -->
       <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700&family=Lora:wght@400;600&display=swap" rel="stylesheet">
        <script>
            tailwind.config = {
            theme: {
                extend: {
                colors: {
                    pastel: {
                    bg: '#fdf6f0',
                    primary: '#ff8c69',
                    primaryHover: '#ff7043',
                    accent: '#ffd8cc',
                    text: '#6d5d52',
                    textSecondary: '#938278',
                    textMuted: '#b5a9a2',
                    textHeading: '#5c4d44',
                    border: '#ffe8d9',
                    inputBorder: '#ffe0c2',
                    input: '#fffefc'
                    }
                },
                fontFamily: {
                    sans: ['Nunito Sans', 'sans-serif'],
                    serif: ['Lora', 'serif']
                },
                boxShadow: {
                    'pastel-sm': '0 3px 6px rgba(180, 160, 150, 0.08)',
                    'pastel-md': '0 6px 12px rgba(180, 160, 150, 0.1)',
                    'pastel-lg': '0 10px 20px rgba(180, 160, 150, 0.12)'
                }
                }
            }
            }
        </script>
        @stack('styles')
    </head>
    <body class="bg-pastel-bg font-sans text-pastel-text min-h-screen flex items-center justify-center p-5">
        @yield('content')
        
        @stack('scripts')
    </body>
</html>
