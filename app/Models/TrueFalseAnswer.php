<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrueFalseAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'correct_answer'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}