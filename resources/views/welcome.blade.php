<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>My Notes Demo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Reenie+Beanie:regular" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link href="{{ asset('css/notes.css') }}" rel="stylesheet" media="screen">
        <!-- jquery -->
        <script src="{{ asset('js/app.js') }}"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body>
        <div class="position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    <ul id="notes">
                        <!---->
                    </ul>
                </div>
            </div>
        </div>
        <script>
            $( document ).ready(function() {
                $.getJSON( "notes/json", function( data ) {
                    $('#notes').html('');
                    for(c=0;c<data.length;c++){
                        oNote=data[c];
                        note='<li><a href="#"><h2>#'+oNote.id+' '+oNote.name+'</h2><p>'+oNote.txNote+'</p></a></li>';
                        $(note).appendTo('#notes');
                    }
                }).fail(function(e){
                    alert("Un error impidió que obtuvieramos las notas");
                    console.log(e.responseText)
                });
            });
        </script>
    </body>
</html>
