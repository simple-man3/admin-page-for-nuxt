<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoBlock extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function  additionalField()
    {
        return $this->hasMany(AdditionalFields::class);
    }

    protected $fillable = [
        'name',
        'active',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i:s',
        'updated_at' => 'datetime:d.m.Y H:i:s',
    ];
}
