<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'department_id', 'created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function Department()
    {
        return $this->belongsTo('App\Department');
    }//Department
}
