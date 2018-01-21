<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        dd('ok');

        // generate uniqueId
        $uniqueId = uniqid(true);

        $channel = $request->user()->channel()->first();

        $video = $channel->videos()->create([
            'uniqueId' => $uniqueId,
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'video_filename' => "{$uniqueId}.{$request->extension}",
        ]);

        return response()->json([
            'data' => [
                'uniqueId' => $uniqueId,
            ]
        ]);

    }
}
