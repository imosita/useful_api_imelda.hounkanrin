<?php
namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_modules', 'module_id', 'user_id')
            ->withPivot('active');
            // ->withTimestamps();
    }
}

