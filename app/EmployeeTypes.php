<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeTypes extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'company_id', 'created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function Company(){
        return $this->belongsTo('App\Company');
    }
}
