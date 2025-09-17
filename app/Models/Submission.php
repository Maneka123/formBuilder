<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = ['form_id','answers'];

    public function form()
{
    return $this->belongsTo(Form::class);
}

public function answerItems()
{
    return $this->hasMany(Answer::class);
}

}
