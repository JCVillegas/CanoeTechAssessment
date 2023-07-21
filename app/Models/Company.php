<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];

    public function funds()
    {
        return $this->belongsToMany(Fund::class, 'fund_company', 'company_id', 'fund_id');
    }

}
