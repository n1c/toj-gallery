@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1>Success!</h1>

            <p class="lead">We've sent your enquiry (and a copy to your address as well!)</p>

            <p class="lead">
                &raquo; <a href="{{ route('welcome') }}">Home</a>
            </p>
        </div>
    </div>

    <div class="row">
        <hr />
    </div>
@endsection
