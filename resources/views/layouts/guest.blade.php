<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen flex items-center justify-center p-4 md:p-8 lg:p-12">
        <div class="container mx-auto max-w-6xl">

            <div class="flex flex-col md:flex-row items-center gap-12 lg:gap-20">

                <div class="w-full md:w-1/2 flex justify-center">
                    <div class="relative w-full max-w-md rounded-[2rem] flex flex-col items-center text-center">
                        <div class="w-full mb-6 flex items-center justify-center">
                            <img src="{{ asset('/images/logo.png') }}" alt="LogLingo Logo">
                        </div>
                        <div class="space-y-4">
                            <p>This app is for language learners. You can log your day in the language you are studying, and interact with your friends and teachers! <br> Let's enjoy and practice together!!</p>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-1/2 max-w-md justify-center">
                    {{ $slot }}
                </div>

            </div>
        </div>
    </div>

    <div x-data="{ 
                show: false, 
                message: '',
                type: 'success',
                showToast(detail) {
                    this.message = typeof detail === 'string' ? detail : detail.message;
                    this.type = detail.type || 'success';
                    this.show = true;
                    setTimeout(() => { this.show = false }, 3000);
                }
            }"
        @toast.window="showToast($event.detail)"
        style="display: none;"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 z-[100] min-w-[200px]">
        <div class="bg-[#B178CC] text-white px-4 py-3 rounded-2xl shadow-2xl flex items-center gap-3">
            <template x-if="type === 'error'">
                <i class="fa-solid fa-circle-exclamation text-red-200"></i>
            </template>
            <span x-text="message" class="text-sm font-medium"></span>
        </div>
    </div>

    @if (session('error'))
    <script>
        setTimeout(() => {
            window.dispatchEvent(new CustomEvent('toast', {
                detail: {
                    message: "{{ session('error') }}",
                    type: 'error'
                }
            }));
        }, 200);
    </script>
    @endif
    
</body>

</html>