<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class HandymanService extends Pivot
{
 protected $table = 'handyman_services';

    protected $fillable = [
        'handyman_id',
        'service_id',
        'is_primary',
        'experience_years',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];}
