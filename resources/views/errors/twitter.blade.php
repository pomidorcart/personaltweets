@extends('layouts.app')
@section('content')
<div class="container">
    Twitter Exceptions: <b>{{ $exception->getMessage() }}</b>
</div>
@endsection