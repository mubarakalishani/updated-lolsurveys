<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PtcAd extends Model
{
    use HasFactory;
    protected $fillable = [
        'employer_id', 'unique_id', 'ad_balance', 'temp_locked_balance', 'reward_per_view', 'views_needed', 'views_completed', 
        'title', 'description', 'url', 'targeted_countries', 'excluded_countries', 'status', 'type'
    ];
}
