<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientOrder extends Model
{
    use HasFactory;
    protected $guarded = ['status'];
    protected $fillable = ['client_id', 'post_id'];
    protected $casts = [];
    protected $hidden = [];
    public function client() {
        return $this->belongsTo(Client::class)->select('id', 'name');
    }
    public function post() {
        return $this->belongsTo(Post::class)->select('id', 'content');
    }
}
