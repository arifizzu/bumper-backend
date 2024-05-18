<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activities_locations';

    protected $fillable = [
        'activity_id',
        'w',
        'h',
        'x',
        'y',
    ];

    public function activity() : BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }
}
