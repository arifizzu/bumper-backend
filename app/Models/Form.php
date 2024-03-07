<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

// use App\Models\FormTemplate;

class Form extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'forms';

    protected $fillable = [
        'name',
        'short_name',
        'table_name',
    ];

    // public function formTemplate()
    // {
    //     return $this->belongsTo(FormTemplate::class);
    // }
}
