<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ActivityRelation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activities_relations';

    protected $fillable = [
        'source_id',
        'target_id',
        'condition_id',
    ];

    public function sourceActivity() : BelongsTo
    {
        return $this->belongsTo(Activity::class, 'source_id');
    }

    public function targetActivity() : BelongsTo
    {
        return $this->belongsTo(Activity::class, 'target_id');
    }

    public function condition() : HasOne
    {
        return $this->hasOne(Condition::class, 'id');
    }

}
