<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdhaarInfoData extends Model
{
    use HasFactory;
    
    protected $table = 'adhaar_info_data';

    protected $fillable = [
        'uid',
        'adhaar',
        'additional_info'
    ];

    // Define relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }
}
