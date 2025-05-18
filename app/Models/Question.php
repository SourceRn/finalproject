<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'question_text', 'type'];

    // Relación con el examen
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relación con las opciones (para preguntas de opción múltiple)
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    // Relación con la respuesta verdadero/falso
    public function trueFalseAnswer()
    {
        return $this->hasOne(TrueFalseAnswer::class);
    }

    // Método de utilidad para saber si es de opción múltiple
    public function isMultipleChoice()
    {
        return $this->type === 'multiple_choice';
    }

    // Método de utilidad para saber si es de verdadero/falso
    public function isTrueFalse()
    {
        return $this->type === 'true_false';
    }
}