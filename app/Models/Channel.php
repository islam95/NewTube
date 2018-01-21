<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    /**
     * Variable for avoiding MassAssignmentException in using forms.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_filename',
    ];

    /**
     * Database relation back to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function videos()
    {
        return $this->hasMany(Video::class);
    }

}
