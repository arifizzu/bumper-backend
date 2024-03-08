<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fields_types';

    protected $fillable = [
        'name',
    ];

    public function fields() : HasMany
    {
        return $this->HasMany(Field::class);
    }
}
