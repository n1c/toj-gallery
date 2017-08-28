<?php

use \App\Models\Album;
use \App\Models\Image;
use \App\Models\Contact;

use \Image as ImageLib;

Route::get('/', [ 'as' => 'welcome', function () {
    return Response::view('welcome', [
        'albumsFgPerRow' => 4,
        'albumsFg' => Album::getFg(),
        'albumsTojPerRow' => 6,
        'albumsToj' => Album::getToj(),
        'albumsOld' => Album::getOlder(),
        'albumsOldCols' => 3,
    ]);
}]);

Route::get('/album/{slug}', function ($albumSlug) {
    $album = Album::where('slug', $albumSlug)->firstOrFail();

    return response()->view('album', [
        'album' => $album,
        'images' => $album->images()->paginate(48), // 48 per page.
        'imagesPerRow' => 6,
    ]);
});

Route::get('/album/{slug}/image/{id}', function ($albumSlug, $image_id) {
    $image = Image::findOrFail($image_id);
    return response()->view('image', [ 'image' => $image ]);
});

Route::get('/thumb/{url}', function ($url) {
    $pathThumb = 'thumb_' . $url;

    if (Storage::exists($pathThumb)) {
        $img = ImageLib::make(storage_path('app/' . $pathThumb));
    } else {
        $tempPath = $url;

        $path = 'http://s3.amazonaws.com/' . config('filesystems.disks.s3.bucket') . '/' . $url;
        Storage::put($tempPath, file_get_contents($path));

        $img = ImageLib::make(storage_path('app/' . $tempPath))->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $img->save(storage_path('app/' . $pathThumb));
    }

    return $img->response('jpg');
});

Route::get('/enquire', [ 'as' => 'enquire', function () {
    return Response::view('enquire', [
        'items' => Album::getFgAll(),
    ]);
}]);

Route::post('/enquire', [ 'as' => 'enquire:post', function () {
    $v = \Validator::make(Input::all(), [
        'email' => 'required|email',
    ]);

    if ($v->fails()) {
        return redirect()->back()->withInput()->withErrors($v->errors());
    }

    $data = Input::all();
    array_forget($data, '_token');
    $data = (object) $data;

    $contact = Contact::create([
        'data' => $data,
    ]);

    Mail::queue('email.enquire', [ 'data' => $contact->data ], function ($message) use ($contact) {
        $message->to(config('mail.enquire'));
        $message->replyTo($contact->data->email);
        $message->cc(config('mail.from.address'));
        $message->cc($contact->data->email);

        $message->subject(sprintf('%s TOJ Gallery enquiry', $contact->created_at));
    });

    return Redirect::to(route('enquire.success'));
}]);

Route::get('/enquire/success', [ 'as' => 'enquire.success', function () {
    return Response::view('enquire_success');
}]);

Route::get('main.php', function () {
    $item_id = Input::get('g2_itemId') ?: Input::get('g2_highlightId');
    if (!$item_id || !Input::get()) {
        return Redirect::to('/');
    }

    $album = Album::find($item_id);
    if ($album) {
        if (Input::get('g2_page')) {
            return Redirect::to('/album/' . $album->slug . '/?page=' . Input::get('g2_page'), 301);
        }

        return Redirect::to('/album/' . $album->slug, 301);
    }

    $image = Image::find($item_id);
    if ($image) {
        return Redirect::to('/album/' . $image->album->slug . '/image/' . $image->id, 301);
    }

    return response()->view('404', [], 404);
});

Route::group([ 'prefix' => 'auth', 'as' => 'auth.' ], function () {

    Route::get('login', [
        'as' => 'login',
        'uses' => 'Auth\AuthController@getLogin',
    ]);

    Route::post('login', [
        'as' => 'login:post',
        'uses' => 'Auth\AuthController@postLogin',
    ]);

    Route::get('logout', [
        'as' => 'logout',
        'uses' => 'Auth\AuthController@getLogout',
    ]);

});

Route::group([ 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth', ], function () {

    Route::get('upload', [ 'as' => 'upload', function () {
        return Response::view('admin.upload', [
            'albums' => Album::getFg(),
            'albumsDisabled' => Album::getFgDisabled(),
        ]);
    }]);

    Route::post('upload', [ 'as' => 'upload:post', function () {
        $upload = Input::file('image');
        $contents = file_get_contents($upload->getRealPath());
        $ext = $upload->getExtension() ?: $upload->guessExtension();
        $path = uniqid() . '.' . $ext;
        \Storage::disk('s3')->put($path, $contents, 'public');

        Image::create([
            'title' => Input::get('title'),
            'description' => Input::get('description'),
            'album_id' => Input::get('album_id'),
            'format' => $ext,
            'width' => 0,
            'height' => 0,
            'size' => $upload->getClientSize(),
            'path' => $path,
        ]);

        return Redirect::to(route('admin.upload'));
    }]);

});
