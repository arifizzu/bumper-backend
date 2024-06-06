<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataListItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_lists_items';

    protected $fillable = [
        'list_id',
        'label',
        'order',
        'column_key',
        'table_name',
        'column_name',
        'is_hidden',
        'include_filter',
        'filter_type',
    ];

    public function dataList() : BelongsTo
    {
        return $this->belongsTo(DataList::class, 'list_id');
    }
}
