<?php namespace App\Console\Commands;

use Illuminate\Console\Command;

class RehostImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rehostimages';

    public function handle()
    {
        // THIS IS DEAD NOW
        $unhosted = \App\Models\Image::whereNull('host_id');
        $this->info(sprintf('Going in to rehost %u images!', $unhosted->count()));

        foreach ($unhosted->get() as $image) {
            $path = public_path('img/' . $image->filename);
            if (!file_exists($path)) {
                $this->error(sprintf('File does not exist %s for image %d', $image->filename, $image->id));
                continue;
            }

            $upload = \Cloudinary\Uploader::upload($path);
            $image->update([
                'host_id' => $upload['public_id'],
                'format' => $upload['format'],
                'width' => $upload['width'],
                'height' => $upload['height'],
                'size' =>  $upload['bytes'],
            ]);

            $this->info('Updated image ' . $image->id);
            usleep(50);
        }
    }
}
