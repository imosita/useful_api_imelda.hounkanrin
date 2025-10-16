<?php
namespace App\Models;

// use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Shortlink extends Model
{

    protected $fillable = [
        'original_url',
        'user_id',
        'custom_code',
    ];
    protected $attributes = [
        'clicks' => 0,
    ];
    public function incrementClicks()
    {
        $this->increment('clicks');
    }
}
