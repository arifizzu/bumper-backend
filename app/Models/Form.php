<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'forms';

    protected $fillable = [
        'name',
        'short_name',
        'group_id',
        'created_by',
    ];

    public function formTemplate() : BelongsTo
    {
        return $this->belongsTo(FormTemplate::class);
    }

    public function fields() : HasMany
    {
        return $this->hasMany(Field::class);
    }

    public function activities() : HasMany
    {
        return $this->hasMany(Activity::class, 'form_id');
    }

    public function group() : BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function createdBy() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
