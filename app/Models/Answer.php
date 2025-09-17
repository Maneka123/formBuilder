<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['submission_id', 'field_id', 'answer'];

    public function submission()
{
    return $this->belongsTo(Submission::class);
}

public function field()
{
    return $this->belongsTo(Field::class);
}

}
