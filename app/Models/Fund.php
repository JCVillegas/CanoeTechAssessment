<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $fillable = ['name', 'start_year', 'manager_id', 'aliases'];

    public function manager()
    {
        return $this->belongsTo(FundManager::class, 'manager_id');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'fund_company', 'fund_id', 'company_id');
    }

}
