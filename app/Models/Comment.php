<?php

namespace App\Models;


class Comment extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'content',
        'is_approved',
        'user_id',
        'created_on'
    ];

    /**
     * @return
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
