<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FieldLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fields_locations';

    protected $fillable = [
        'field_id',
        'width',
        'height',
        'x_coordinate',
        'y_coordinate',
    ];

    public function field() : BelongsTo
    {
        return $this->belongsTo(Field::class, 'field_id');
    }
}
