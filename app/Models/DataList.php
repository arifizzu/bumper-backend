<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DataList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_lists';

    protected $fillable = [
        'title',
        'description',
        'form_id',
    ];

    public function items() : HasMany
    {
        return $this->hasMany(DataListItem::class, 'list_id', 'id');
    }

    public function filters() : HasMany
    {
        return $this->hasMany(DataListFilter::class, 'list_id', 'id');
    }

    public function form() : HasOne
    {
        return $this->hasOne(Form::class, 'id', 'form_id');
    }
}
