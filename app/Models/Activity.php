<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activities';

    protected $fillable = [
        'name',
        'process_id',
        'form_id',
        'status',
        // 'width',
        // 'height',
        // 'x_coordinate',
        // 'y_coordinate',
    ];

    public function process() : BelongsTo
    {
        return $this->belongsTo(Process::class, 'process_id');
    }

    public function relations() : HasMany
    {
        return $this->hasMany(ActivityRelation::class, 'source_id');
    }

    public function form() : HasOne
    {
        return $this->hasOne(Form::class, 'id');
    }

    public function participants() : HasMany
    {
        return $this->hasMany(Participant::class, 'activity_id');
    }

        public function location() : HasOne
    {
        return $this->hasOne(ActivityLocation::class);
    }
}
