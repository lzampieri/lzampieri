<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>@yield('title')</title>

        <livewire:styles />
    </head>
    <body class="px-8 py-4">
            <div class="flex flex-col items-center w-full md:w-3/4 mx-auto">
                <img class="w-full md:w-2/3" src="{{ asset('img/logotitolo_grigio.png') }}" />
                <div class="flex flex-row w-full">
                    <div class="basis-1/5">
                        <livewire:sections-list />
                    </div>
                    <div class="basis-4/5 m-2 p-2 drop-shadow-lg border rounded border-bg_grey">
                        @yield('content')
                    </div>
                </div>
            </div>
    </body>
</html>
