@extends('app')

@section('content')
    <div class="row" style="padding-bottom: 15px">
        <div class="col-sm-12 text-center">
            <a href="{{ route('enquire') }}" class="btn btn-success btn-lg btn-block">Enquire!</a>
        </div>
    </div>

    <div class="row">
        <ol class="breadcrumb">
            <li><a href="/">Home</a></li>
            <li class="active">{{ $album->title }}</li>
        </ol>

        <div class="page-header">
            <h1>
                {{ $album->title }}
                @if ($album->link)
                    <small><a href="{{ $album->link }}" target="_blank"><span class="glyphicon glyphicon-link"></span></a></small>
               @endif
            </h1>
        </div>
    </div>

    @for ($x = 0; $x < ceil($images->count() / $imagesPerRow); $x++)
        <div class="row">
            @for ($y = 0; $y < $imagesPerRow; $y++)
                <?php
                    $index = ($x * $imagesPerRow) + $y;
                    if (!isset($images[$index])) continue;
                    $i = $images[$index];
                ?>

                <div class="col-md-2">
                    <div class="thumbnail">
                        <a href="/album/{{ $album->slug }}/image/{{ $i->id }}">
                            <img src="{{ $i->urlThumb() }}" alt="{{ $i->title }}" />
                        </a>
                    </div>
                </div>
            @endfor
        </div>
    @endfor

    <div class="row">
        <div class="col-md-12 lead text-center">
            <?= $images->render() ?>
        </div>
    </div>
@endsection
