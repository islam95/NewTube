<?php

namespace App\Jobs;

use App\Models\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;
    public $file_id;

    /**
     * Create a new job instance.
     *
     * @param Channel $channel
     * @param         $file_id
     */
    public function __construct(Channel $channel, $file_id)
    {
        $this->channel = $channel;
        $this->file_id = $file_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get image from the path
        $path = storage_path() . '/uploads/' . $this->file_id;
        $fileName = $this->file_id . '.png';

        // resize
        Image::make($path)->encode('png')->fit(40, 40, function ($constraint){
            $constraint->upsize(); // upsize if image is less than 40px
        })->save();

        // upload to s3
        if (Storage::disk('s3images')->put('profile/' . $fileName, fopen($path, 'r+'))){
            File::delete($path); // delete temporary file from - storage/uploads
        }

        // update channel image
        $this->channel->image_filename = $fileName;
        $this->channel->save();
    }
}
