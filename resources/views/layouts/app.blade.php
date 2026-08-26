<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>

        <nav class="scroll-dark flex-1 overflow-y-auto overflow-x-hidden px-3 py-4 text-sm">
            <ul class="flex gap-2">
                <li>
                    <a href="/"
                        wire:navigate
                    >
                        <span class="ml-2 text-base font-medium">Home</span>
                    </a>
                </li>
                <li>
                    <a href="/products"
                        wire:navigate
                    >
                        <span class="ml-2 text-base font-medium">Products</span>
                    </a>
                </li>
                <li>
                    <a href="/users"
                        wire:navigate
                    >
                        <span class="ml-1 text-base font-medium">Users</span>
                    </a>
                </li>
            </ul>
        </nav>

        <main>
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
