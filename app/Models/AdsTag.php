<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'ads_id','tag_id',
    ];

    public function ads()
    {
        return $this->belongsTo(Ads::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
