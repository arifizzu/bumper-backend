<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fields';

    protected $fillable = [
        'caption',
        'form_id',
        'type_id',
        'is_required',
        'column_name',
        'width',
        'height',
        'x_coordinate',
        'y_coordinate',
    ];
}
