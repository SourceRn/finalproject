<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'question_id',
        'selected_option_id',
        'true_false_answer',
        'is_correct',
    ];

    public function submission()
    {
        return $this->belongsTo(ExamSubmission::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption()
    {
        return $this->belongsTo(Option::class, 'selected_option_id');
    }
}