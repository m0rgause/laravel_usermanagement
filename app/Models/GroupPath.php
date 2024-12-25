<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupPath extends Model
{
    use HasFactory;

    protected $table = 'group_path';

    protected $fillable = [
        'id',
        'nama',
        'deskripsi',
        'landing_page',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function groupAccesses()
    {
        return $this->hasMany(GroupAccess::class, 'group_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(Users::class, 'group_id', 'id');
    }
}
