<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';
    protected $fillable = [ 'host_id', 'album_id', 'format', 'title', 'description', 'filename', 'path', 'width', 'height', 'size', 'created_at', ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    public function prev()
    {
        return Image::where('album_id', $this->album_id)->where('id', '<', $this->id)->orderBy('id', 'DESC')->first();
    }

    public function next()
    {
        return Image::where('album_id', $this->album_id)->where('id', '>', $this->id)->orderBy('id', 'ASC')->first();
    }

    public function url()
    {
        return '//s3.amazonaws.com/' . config('filesystems.disks.s3.bucket') . '/' . $this->path;
    }

    public function urlThumb()
    {
        return '/thumb/' . $this->path;
    }
}
