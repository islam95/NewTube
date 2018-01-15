<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;
use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel)
    {
        $this->authorize('edit', $channel);

        return view('channel.settings.edit', [
            'channel' => $channel
        ]);
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
        $this->authorize('update', $channel);

        $channel->update([
            'name'          => $request->name,
            'slug'          => $request->slug,
            'description'   => $request->description,
        ]);

        if ($request->file('image')){
            // move to temporary location: storage folder
            $request->file('image')->move(storage_path() . '/uploads', $file_id = uniqid(true));
            // dispatch a job
            $this->dispatch(new UploadImage($channel, $file_id));
        }

        return redirect()->to("/channel/{$channel->slug}/edit");
    }

}
