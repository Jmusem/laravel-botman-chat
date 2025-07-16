<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Faq extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'question',
        'answer',
    ];

    /**
     * Specify the fields to be indexed for full-text search.
     */
    public function toSearchableArray()
    {
        return [
            'question' => $this->question,
        ];
    }
}
