<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';
    protected $guarded = [];

    protected $casts = [
        'profiles' => 'array',
    ];

    public function research(): HasMany
    {
        return $this->hasMany(Research::class);
    }

}
