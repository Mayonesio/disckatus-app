<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disckatus - Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-[#10163f] to-[#0c1129] min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-lg shadow-xl overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo-gray.png') }}" alt="Disckatus Logo" class="mx-auto h-24 mb-4">
                    <h1 class="text-3xl font-bold text-[#10163f] hidden">Disckatus</h1>
                    <p class="text-gray-600 mt-2">Ultimate Frisbee Team Management</p>
                </div>

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Error</p>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="mt-8 space-y-6">
                    <a href="{{ url('auth/google') }}"
                        class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#10163f] hover:bg-[#1c2a6a] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#ffd200] transition duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12.545,12.151L12.545,12.151c0,1.054,0.855,1.909,1.909,1.909h3.536c-0.367,1.332-1.02,2.436-1.855,3.271 c-1.331,1.331-3.093,2.065-4.973,2.065c-3.886,0-7.04-3.154-7.04-7.04s3.154-7.04,7.04-7.04c1.88,0,3.642,0.734,4.973,2.065 l2.512-2.512C16.982,3.204,14.611,2.1,12,2.1c-5.466,0-9.9,4.434-9.9,9.9s4.434,9.9,9.9,9.9c2.611,0,4.982-1.104,6.647-2.769 c1.665-1.665,2.769-4.036,2.769-6.647V12.151H12.545z" />
                        </svg>
                        Iniciar sesión con Google
                    </a>
                </div>

                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Al iniciar sesión, aceptas nuestros
                        <a href="#" class="font-medium text-[#10163f] hover:text-[#ffd200]">Términos de Servicio</a> y
                        <a href="#" class="font-medium text-[#10163f] hover:text-[#ffd200]">Política de Privacidad</a>.
                    </p>
                </div> <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    ¿Necesitas ayuda? <a href="#" class="font-medium text-[#10163f] hover:text-[#ffd200] hover:underline">Contáctanos</a>
                </p>
            </div>
            </div>
           
        </div>


    </div>

    <div class="fixed bottom-4 right-4">
        <a href="#" class="text-white hover:text-[#ffd200] transition duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                </path>
            </svg>
        </a>
    </div>
</body>

</html>