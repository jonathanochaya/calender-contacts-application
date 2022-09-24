<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'birthday' => 'date'
    ];

    const url_path = '/contacts/';

    public function path()
    {
        return url(self::url_path . $this->id);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }
}
