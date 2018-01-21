<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'uniqueId',
        'video_filename',
        'video_id',
        'processed',
        'visibility',
        'allow_votes',
        'allow_comments',
        'processed_percentage',
    ];

    public function channel(){
        return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName(){
        return 'uniqueId';
    }

}
