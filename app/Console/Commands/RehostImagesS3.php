<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class RehostImagesS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rehostimagess3';

    public function handle()
    {
        // THIS IS DEAD NOW
        $unhosted = \App\Models\Image::whereNull('path');
        $this->info(sprintf('Going in to rehost %u images!', $unhosted->count()));

        foreach ($unhosted->get() as $image) {
            $pathS3 = $image->host_id . '.' . $image->format;

            $cloudinaryUrl = cloudinary_url($image->host_id);
            $contents = file_get_contents($cloudinaryUrl);

            Storage::disk('s3')->put($pathS3, $contents, 'public');

            $image->update([
                'path' => $pathS3,
            ]);

            $this->info('Updated image ' . $image->id);
            usleep(50);
        }
    }
}
