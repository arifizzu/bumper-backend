<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Condition extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'conditions';

    protected $fillable = [
        'label',
        'condition_variable',
        'condition_operator',
        'condition_value',
    ];

    public function relation() : HasOne
    {
        return $this->hasOne(ActivityRelation::class, 'condition_id');
    }
}
