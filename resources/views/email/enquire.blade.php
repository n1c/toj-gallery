@extends('email.base')

@section('content')
    <h1>New toj-galery.com enquiry:</h1>

    <strong>Jacket</strong>: {{ array_get($data, 'jacket') }}
    <br />

    <strong>Size</strong>: {{ array_get($data, 'size') }}
    <br />

    <strong>Hide</strong>: {{ array_get($data, 'hide') }}
    <br />

    <strong>Color</strong>: {{ array_get($data, 'color') }}
    <br />

    <strong>Details</strong>:<br />
    {!! nl2br(array_get($data, 'details')) !!}
@endsection
