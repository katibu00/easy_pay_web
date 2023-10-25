<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'combo_id',
        'order_number',
        'state',
        'status',
        'city',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function combo()
    {
        return $this->belongsTo(Combo::class);
    }
}
