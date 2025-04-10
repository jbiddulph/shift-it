<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'status',
        'priority',
        'description',
        'completed',
    ];

    protected $attributes = [
        'status' => 'Pending',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
