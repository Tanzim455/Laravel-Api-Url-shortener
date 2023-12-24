<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Url extends Model
{
    use HasFactory;
    protected $fillable = ['long_url', 'param_url', 'short_url', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($url) {
        $url->param_url = Str::random(5);
        $url->short_url = config('app.url') . '/' . $url->param_url;
        $url->user_id = auth()->user()->id;
        });
    }
}
