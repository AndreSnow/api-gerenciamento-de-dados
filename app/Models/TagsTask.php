<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tag_name',
        'task_id'
    ];
}
