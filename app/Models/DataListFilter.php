<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataListFilter extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'data_lists_filters';

    protected $fillable = [
        'list_id',
        'label',
        'order',
        'table_name',
        'column_name',
    ];

    public function dataList() : BelongsTo
    {
        return $this->belongsTo(DataList::class, 'list_id');
    }
}
