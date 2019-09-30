<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'contact', 'rfc', 'telephone', 'created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

}
