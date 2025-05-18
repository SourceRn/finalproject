<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamSubmission extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'user_id', 'score', 'started_at', 'submitted_at'];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class, 'submission_id');
    }
}