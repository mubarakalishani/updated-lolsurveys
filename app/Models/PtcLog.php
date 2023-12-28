<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtcLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'worker_id', 'ad_id', 'reward', 'ip'
    ];
}
