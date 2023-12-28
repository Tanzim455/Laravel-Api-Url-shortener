<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlVisit extends Model
{
    use HasFactory;

    protected $fillable=['short_url','visits','user_id'];
}
