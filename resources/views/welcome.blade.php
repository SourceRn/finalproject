<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">
            <div class="flex flex-col">
                    <header class="absolute w-full p-6 text-white bg-[#1E293B] flex justify-center">
                        <div class="flex justify-center items-center">
                           <span class="text-lg">Logo</span> 
                        </div>
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </header>

                    <main class="flex justify-center w-100 h-screen bg-[#EEF2FF]">
                        <div class="p-6 justify-center content-center">
                            <p class="w-100 text-center text-5xl text-[#1E293B]">Bienvenidos</p>
                            <br><br>
                            <div class="flex flex-rows">
                                <a
                                    href="{{ route('login') }}"
                                    class="rounded-md  mr-8 text-white px-6 py-10 hover:bg-[#4F46E5] bg-[#6366F1] text-xl border border-black"
                                >
                                    Iniciar Sesion
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="rounded-md ml-8 px-6 py-10 hover:bg-[#4F46E5] bg-[#6366F1] text-xl border text-white border-black"
                                    >
                                         Registrarse
                                    </a>
                                @endif
                            </div>
                        </div>
                    </main>
            </div>
    </body>
</html>