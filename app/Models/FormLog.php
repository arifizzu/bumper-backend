<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'forms_logs';

    protected $fillable = [
        'user_id',
        'form_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function form() : BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
