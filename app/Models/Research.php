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

    public function scopeFilterByTitle($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('title', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByKeyword($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('author_keyword', 'like', "%{$filter}%");
        });
    }

    public function scopeFilterByAuthor($query, $filter)
    {
        $query->where(function ($query) use ($filter) {
            $query->where('author', 'like', "%{$filter}%");
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

    public function scopeFilterByBetweenYear($query, array $filter)
    {
        return $query->whereYear('publish_date', '>=', $filter[0])
            ->whereYear('publish_date', '<=', $filter[1]);
    }
}
