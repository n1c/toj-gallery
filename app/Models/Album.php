<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public static function getFgAll()
    {
        return \Cache::remember('album::fgAll', 10, function () {
            return self::where('order', '>', 22)
                ->orWhere('order', '=', -1)
                ->with('images')
                ->orderBy('order', 'DESC')
                ->get()
                ;
        });
    }

    public static function getFg()
    {
        return \Cache::remember('album::fg', 10, function () {
            return self::where('order', '>', 22)
                ->with('images')
                ->orderBy('order', 'DESC')
                ->get()
                ;
        });
    }

    public static function getFgDisabled()
    {
        return \Cache::remember('album::fgdisabled', 10, function () {
            return self::where('order', '=', -1)
                ->with('images')
                ->orderBy('order', 'DESC')
                ->get()
                ;
        });
    }

    public static function getToj()
    {
        return \Cache::remember('album::toj', 10, function () {
            return self::whereBetween('order', [ 1, 22 ])
                ->with('images')
                ->orderBy('order', 'DESC')
                ->get()
                ;
        });
    }

    public static function getOlder()
    {
        return \Cache::remember('album::older', 10, function () {
            return self::where('order', 0)
                ->with('images')
                ->orderBy('created_at', 'DESC')
                ->get()
                ;
        });
    }
}
