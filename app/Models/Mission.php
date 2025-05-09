<?php
// app/Models/Mission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'target_value',
        'reward_points',
        'expires_at',
    ];

    protected $casts = [
        'target_value' => 'decimal:2',
        'expires_at' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_missions')
            ->withPivot('progress', 'completed', 'reward_claimed')
            ->withTimestamps();
    }

    public function scopeDaily($query)
    {
        return $query->where('type', 'daily');
    }

    public function scopeAchievement($query)
    {
        return $query->where('type', 'achievement');
    }
}