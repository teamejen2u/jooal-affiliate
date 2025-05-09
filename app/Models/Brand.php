<?php
// app/Models/Brand.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'commission_rate',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLink::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}