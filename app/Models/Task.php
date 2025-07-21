<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model

{
    public function user()
{
    return $this->belongsTo(User::class);
}

    protected $fillable = ['title', 'completed', 'due_date', 'priority', 'user_id'];

    //
}
