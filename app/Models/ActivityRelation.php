<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityRelation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activities_relations';

    protected $fillable = [
        'activity_id',
        'trigger_id',
    ];

     public function activity() : BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

}
