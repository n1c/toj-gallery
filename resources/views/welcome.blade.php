@extends('app')

@section('content')
    <div class="row">
        <div class="col-sm-12 text-center">
            <a href="{{ route('enquire') }}" class="btn btn-success btn-lg btn-block">Enquire!</a>
        </div>
    </div>

    <div class="row">
        <div class="page-header">
            <h1>The unofficial Falcon Garments gallery.</h1>
        </div>
    </div>

    @for ($x = 0; $x < ceil($albumsFg->count() / $albumsFgPerRow); $x++)
        <div class="row">
            @for ($y = 0; $y < $albumsFgPerRow; $y++)
                <?php
                    $index = ($x * $albumsFgPerRow) + $y;
                    if (!isset($albumsFg[$index])) continue;
                    $a = $albumsFg[$index];
                ?>
                <div class="col-sm-3">
                    <div class="thumbnail">
                        <a href="/album/{{ $a->slug }}">
                            <img src="{{ $a->images->first()->urlThumb() }}" alt="{{ $a->title }} album" />
                        </a>

                        <div class="caption text-center">
                            <h3>{{ $a->title }}</h3>

                            <p class="lead">
                                <span class="label label-info">
                                    {{ $a->images->count() }} {{ str_plural('image', $a->images->count()) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    @endfor

    <div class="row">
        <div class="page-header">
            <h1>The unofficial Temple of Jawnz gallery.</h1>
        </div>
    </div>

    @for ($x = 0; $x < ceil($albumsToj->count() / $albumsTojPerRow); $x++)
        <div class="row">
            @for ($y = 0; $y < $albumsTojPerRow; $y++)
                <?php
                    $index = ($x * $albumsTojPerRow) + $y;
                    if (!isset($albumsToj[$index])) continue;
                    $a = $albumsToj[$index];
                ?>
                <div class="col-sm-2">
                    <div class="thumbnail">
                        <a href="/album/{{ $a->slug }}">
                            <img src="{{ $a->images->first()->urlThumb() }}" alt="{{ $a->title }} album" />
                        </a>

                        <div class="caption text-center">
                            <h4>{{ $a->title }}</h4>

                            <p class="lead">
                                <span class="label label-info">
                                    {{ $a->images->count() }} {{ str_plural('image', $a->images->count()) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    @endfor

    <hr>

    <div class="row">
        <div class="col-sm-7 col-sm-offset-2 text-center lead">
            <p>If you need to leave some feedback or get in contact with the gallery, you can send an e-mail to: <a href="mailto:info@toj-gallery.com">info@toj-gallery.com</a></p>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="page-header">
            <h1>Older</h1>
        </div>

        @for ($c = 0; $c < $albumsOldCols; $c++)
            <div class="col-sm-4">
                @for ($x = 0; $x < ceil($albumsOld->count() / $albumsOldCols); $x++)
                    <?php
                      $index = ($x * $albumsOldCols) + $c;
                      if (!isset($albumsOld[$index])) continue;
                      $a = $albumsOld[$index];
                    ?>
                    <ul class="list-unstyled">
                        <li>
                            <a href="/album/{{ $a->slug }}">{{ $a->title }}</a>
                            <small>{{ $a->images->count() }} {{ str_plural('image', $a->images->count()) }}</small>
                        </li>
                    </ul>
                @endfor
            </div>
        @endfor
    </div>

    <div class="row">
        <hr />
    </div>
@endsection
