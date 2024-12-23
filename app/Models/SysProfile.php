<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysProfile extends Model
{
    use HasFactory;

    protected $table = 'sys_profile';

    protected $fillable = [
        'id',
        'syslogo',
        'systitle',
        'sysname',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}
