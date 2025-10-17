<?php
namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['sender_id', 'receiver_id', 'amount', 'status'];
    protected $casts    = ['amount' => 'decimal:2'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
