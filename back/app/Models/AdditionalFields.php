<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalFields extends Model
{
    use HasFactory;

    public function typeField()
    {
        return $this->belongsTo(TypeFields::class);
    }

    protected $fillable=[
        'name',
        'active',
        'symbol_code',
        'type_fields_id',
        'info_block_id',
        'needFill',
    ];
}
