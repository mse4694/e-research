<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Research extends Model
{
    use HasFactory;

    protected $table = 'researchs';
    protected $guarded = [];

    protected $casts = [
        'other' => 'array',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function scopeFilterByKeyword($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('tags', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByFirstAuthor($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('first_author', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByCorrespondingAuthor($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('corresponding_author', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByJournalName($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('journal_name', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByIsbn($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('isbn', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByIssn($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('issn', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByDoi($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('doi', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByPublicationDate($query, $filter)
    {
        $year =  date(NOW()->year) - $filter;
        $query->where(function ($query) use ($year) {
            $query->whereYear('publish_date', '>=', "{$year}");
        });
    }
}
