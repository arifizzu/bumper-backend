<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Spatie\Permission\Models\Role;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'participants';

    protected $fillable = [
        'type',
        'activity_id',
    ];

    public function activity() : BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'participant_is_user', 'participant_id', 'user_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'participant_is_role', 'participant_id', 'role_id');
    }
}

