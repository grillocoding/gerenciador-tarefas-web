<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descricao',
        'status',
        'prioridade',
        'data_entrega',
    ];

    protected $casts = [
        'data_entrega' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}