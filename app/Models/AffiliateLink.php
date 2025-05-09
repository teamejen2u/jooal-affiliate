<?php// app/Models/AffiliateLink.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'brand_id',
        'link_code',
        'clicks',
        'conversions',
        'earnings',
    ];

    protected $casts = [
        'earnings' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getConversionRateAttribute()
    {
        if ($this->clicks == 0) {
            return 0;
        }
        
        return ($this->conversions / $this->clicks) * 100;
    }
}