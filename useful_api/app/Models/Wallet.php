<?php
namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'balance'];
    protected $casts    = ['balance' => 'decimal:2'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}