<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resident extends Model
{
    protected $fillable = [
        'nik',
        'family_card_number',
        'full_name',
        'address',
        'rt',
        'rw',
        'hamlet',
        'birth_place',
        'birth_date',
        'gender',
        'religion',
        'marital_status',
        'occupation',
        'last_education',
        'blood_type',
        'citizenship',
        'life_status',
        'mother_name',
        'father_name',
        'family_relationship_status',
        'disability_type',
    ];

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }
}
