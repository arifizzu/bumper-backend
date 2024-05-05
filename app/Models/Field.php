<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Field extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fields';

    protected $fillable = [
        'caption',
        'form_id',
        'type_id',
        'is_required',
        'table_name',
        'column_name',
        'width',
        'height',
        'x_coordinate',
        'y_coordinate',
    ];

    public function fieldType() : BelongsTo
    {
        return $this->belongsTo(FieldType::class, 'type_id');
    }

    public function form() : BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }

    public function listValues() : HasMany
    {
        return $this->HasMany(FieldListValue::class);
    }
}
