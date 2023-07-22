<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $fillable = ['name', 'start_year', 'manager_id', 'aliases'];

    protected $casts = [
        'aliases' => 'json',
    ];

    public function manager()
    {
        return $this->belongsTo(FundManager::class, 'manager_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'fund_company', 'fund_id', 'company_id');
    }

}
