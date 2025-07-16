<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Question extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['question', 'response'];

    /**
     * Specify the fields to be indexed for full-text search.
     */
    public function toSearchableArray()
    {
        return [ 
            'id' => $this->id,

            'question' => $this->question,
             'response' => $this->response,
        ];
    }
}
