@extends('layouts.app')
@section('content')
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
@endsection