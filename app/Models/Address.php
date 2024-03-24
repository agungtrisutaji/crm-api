<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $table = 'addresses';
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'street',
        'city',
        'province',
        'country',
        'postal_code'
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }
}
