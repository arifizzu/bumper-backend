<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

// use App\Models\Form;

class FormTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'forms_templates';

    protected $fillable = [
        'form_id',
    ];

    // public function form()
    // {
    //     return $this->hasMany(Form::class);
    // }
}
