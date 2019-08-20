<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Generation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Generation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Generation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Generation query()
 * @mixin \Eloquent
 */
class Generation extends Model
{
    protected $table = 'generations';

    protected $fillable = [
        'type', 'result'
    ];

    public $timestamps = false;

    const TYPE_INT = 'int';
    const TYPE_STRING = 'str';
    const TYPE_INT_STRING = 'int_str';
    const TYPE_SET_VALUE = 'set';
    const TYPE_GUID = 'guid';
}
