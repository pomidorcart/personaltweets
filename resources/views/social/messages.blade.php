<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Personal Tweets') }}</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<body>
<div class="container">
    <table class="table table-bordered">
        <tr>
            <th>Id</th>
            <th>Messages</th>
        </tr>
        @foreach($messages as $message)
        <tr>
            <td>{{ $message->getId() }}</td>
            <td>{{ $message->getSocialTXT() }}</td>
        </tr>
        @endforeach
    </table>
    {{ $messages->links() }}
</div>

</body>
</html> 