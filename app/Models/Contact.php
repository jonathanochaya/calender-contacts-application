<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Contact extends Model
{
    use HasFactory, Searchable;

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

    public function scopeBirthdays($query)
    {
        return $query->whereRaw('birthday like "%-'. now()->format('m')  .'-%"');
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'company' => $this->company,
            'author' => $this->author
        ];
    }
}
