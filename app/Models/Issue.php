<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;
    protected $table = 'issues';
    protected $primaryKey = 'id';
    protected $keyType ='integer';

    protected $fillable = [
        'phone', 'email', 'describe', 'attachments','is_resolved','user_id'
    ];
}
