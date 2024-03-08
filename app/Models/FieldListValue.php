<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldListValue extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fields_lists_values';

    protected $fillable = [
        'label',
        'value',
        'field_id',
    ];

    public function field() : BelongsTo
    {
        return $this->belongsTo(Field::class, 'field_id');
    }
}
