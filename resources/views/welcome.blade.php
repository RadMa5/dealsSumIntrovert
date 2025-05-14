<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
    </head>
    <body>
        <table>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Total sum</th>
                <th>Status</th>
            </tr>
            @foreach ($deals as $deal)
                <tr>
                    <td>{{ $deal["id"] }}</td>
                    <td>{{ $deal["name"] }}</td>
                    <td>{{ $deal["sum"] }}</td>
                    <td>{{ $deal["status"] }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
