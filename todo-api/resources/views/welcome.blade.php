<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            .App {
                min-height: 100vh;
                background-color: #282c34;
                text-align: center;
                color: white;
                width: 25vw;
                margin: 0 auto;
            }

            .title {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                font-size: calc(10px + 4vmin);
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .flex-between{
                display: flex;
                justify-content: space-between;
            }
            .align-center {
                align-items: center;
            }
            input {
                width: 100%;
            }
        </style>
    </head>
    <body class="App">

            <div>

                <div class="title m-b-md">
                    ToDo - List
                </div>

                <form method="POST" action="{{ route('addItem') }}" class="flex-between">
                    <input type='text' id="text" name="text"/>
                    <button type='submit'>add</button>
                </form>

                <ul style="list-style: none; padding: 0;">

                    @forelse ($items as $item)
                        <li style="display: flex; justify-content: space-between;">
                            <div>{{ $item->text }}</div>
                            <button style="color: #FF5555">delete</button>
                        </li>
                    @empty
                        <p>Nothing to do</p>
                    @endforelse

                </ul>
        </div>
    </body>
</html>
