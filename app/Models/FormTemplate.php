<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


// use App\Models\Form;

class FormTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'forms_templates';

    protected $fillable = [
        'form_id',
    ];

    public function form(): HasMany
    {
        return $this->hasMany(Form::class, 'id');
    }
}
