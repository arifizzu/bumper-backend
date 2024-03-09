<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activities';

    protected $fillable = [
        'name',
        'process_id',
        'form_id',
        'reference_id',
        'status',
    ];

    public function process() : BelongsTo
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function relations() : HasMany
    {
        return $this->hasMany(ActivityRelation::class);
    }
}
