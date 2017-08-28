@extends('app')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="{{ route('enquire:post') }}" method="POST" enctype="multipart/form-data">
                <fieldset>
                    <legend>Falcon Garments order enquiry</legend>

                    @if (!$errors->isEmpty())
                        <ul>
                            @foreach ($errors->all() as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="input_email">Your Email</label>
                        <input type="email" id="input_email" name="email" value="{{ old('email') }}" class="form-control input-lg" autofocus required>
                    </div>

                    <div class="form-group">
                        <label for="input_jacket">Jacket</label>
                        <input type="text" id="input_jacket" name="jacket" value="{{ old('jacket') }}" class="form-control input-lg" placeholder="{{ implode(', ', array_pluck($items, 'title')) }}">
                    </div>

                    <div class="form-group">
                        <label for="input_size">Size</label>
                        <input type="text" id="input_size" name="size" value="{{ old('size') }}" class="form-control input-lg" placeholder="45, 46, 47, 48... MTM">
                    </div>

                    <div class="form-group">
                        <label for="input_hide">Hide</label>
                        <input type="text" id="input_hide" name="hide" value="{{ old('hide') }}" class="form-control input-lg" placeholder="Lambskin, Calfskin, Goatskin, Lamb Suede, Calf Suede...">
                    </div>

                    <div class="form-group">
                        <label for="input_color">Color</label>
                        <input type="text" id="input_color" name="color" value="{{ old('color') }}" class="form-control input-lg" placeholder="Blood Red, Bright Royal, Dark Wine, Navy, Olive, Sand, Whiskey...">
                    </div>

                    <div class="form-group">
                        <label for="input_details">Details</label>
                        <textarea class="form-control" rows="8" name="details" id="input_details" placeholder="Details">{{ old('details') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">Send</button>
                </fieldset>
            </form>
        </div>
    </div>

    <div class="row">
        <hr />
    </div>
@endsection
