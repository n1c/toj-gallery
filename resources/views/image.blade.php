@extends('app')

@section('meta')
    <meta property="twitter:card" content="photo" />
    <meta property="twitter:title" content="{{ $image->title }}" />
    <meta property="twitter:description" content="{{ $image->description ?: '' }}" />
    <meta property="twitter:image" content="{{ asset('img/' . $image->filename) }}" />
    <meta property="twitter:url" content="{{ Request::url() }}" />

    <meta property="og:type" content="website" />
    <meta property="og:site_name" content="The unofficial Temple of Jawnz gallery" />
    <meta property="og:url" content="{{ Config::get('app.url') }}/{{ Request::url() }}" />
    <meta property="og:title" content="{{ $image->title }}" />
    <meta property="og:image" content="{{ asset('img/' . $image->filename) }}" />
    <meta property="og:description" content="{{ $image->description ?: '' }}" />
    <meta property="og:updated_time" content="{{ $image->updated_at }}" />
@endsection

@section('content')
    <div class="row" style="padding-bottom: 15px">
        <div class="col-sm-12 text-center">
            <a href="{{ route('enquire') }}" class="btn btn-success btn-lg btn-block">Enquire!</a>
        </div>
    </div>

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li><a href="/album/{{ $image->album->slug }}">{{ $image->album->title }}</a></li>
            <li class="active">{{ $image->title }}</li>
            @if ($image->next()) <li class="pull-right"><a href="/album/{{ $image->album->slug }}/image/{{ $image->next()->id }}">next</a></li> @endif
            @if ($image->prev()) <li class="pull-right"><a href="/album/{{ $image->album->slug }}/image/{{ $image->prev()->id }}">prev</a></li> @endif
        </ol>

        <div class="page-header">
            <h1>
                {{ $image->title }}
                <small>created {{ $image->created_at->toFormattedDateString() }}</small>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img src="{{ $image->url() }}" alt="{{ $image->title }}" class="img-responsive" />

            @if ($image->description)
                <blockquote>
                    <p style="white-space: pre-wrap;">{{ $image->description }}</p>
                </blockquote>
            @endif
        </div>
    </div>

    <div class="row">
        <hr />
    </div>
@endsection
