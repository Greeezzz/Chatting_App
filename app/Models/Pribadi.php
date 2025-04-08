<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pribadi extends Model
{
    protected $fillable = ['user_id', 'tujuan_id', 'pesan', 'status', 'file'];
    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tujuan()
    {
        return $this->belongsTo(User::class);
    }
}
