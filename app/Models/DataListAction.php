<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataListAction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_lists_actions';

    protected $fillable = [
        'list_id',
        'name',
        'segment',
        'order',
    ];

    public function dataList() : BelongsTo
    {
        return $this->belongsTo(DataList::class, 'list_id');
    }
}
