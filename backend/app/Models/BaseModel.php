<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * @var list<string>
     */
    protected $guarded = ['id'];
}
