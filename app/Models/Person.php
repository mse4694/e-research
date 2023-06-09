<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    use HasFactory;

    protected $table = 'persons';
    protected $appends = ['person_type', 'image_url'];
    //protected $guarded = [];

    protected $casts = [
        'profiles' => 'array',
        'status' => 'boolean',
    ];

    public function getPersonTypeAttribute()
    {
        switch ($this->type) {
            case 'a':
                $person_type = 'สายวิชาการ (ก)';
                break;
            case 'b':
                $person_type = 'สายสนับสนุน (ข)(แพทย์)';
                break;
            case 'c':
                $person_type = 'สายสนับสนุน (ข)(เจ้าหน้าที่)';
                break;
            case 'd':
                $person_type = 'สายสนับสนุน (ค)(เจ้าหน้าที่)';
                break;
            case 'z':
                $person_type = 'ที่ปรึกษา';
                break;
            default:
                $person_type = 'xxxx';
        }
        return $person_type;
    }

    public function getImageUrlAttribute()
    {
        //return Storage::url($this->image);
        return $this->image ? Storage::disk('s3')->url($this->image) : url('fallbackimage/default-blank-image.jpg');
    }

    public function research(): HasMany
    {
        return $this->hasMany(Research::class);
    }

}
