<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use SoftDeletes;

    protected $fillable = ['id','code','discharge_date','name','first_name','last_name','contract_type_id','period_type_id','real_daily_salary','imss_daily_salary','contribution_base_salary','contribution_base_id','department_id','job_id','employee_type_id','payment_method_id','work_shift_id','number_afore','social_security_number','rfc','curp','sex_id','birth_city','birth_date','umf','fathers_name','mothers_name','current_address','current_population','current_state','cp','telephone','back_electronic_payment','acount_number','branch_office','fonacot_number','email','key_account','state','infonavit_credit_number','discount_type_id','monthly_factor','created_at', 'updated_at'];
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function ContractType()
    {
        return $this->belongsTo('App\ContractTypes');
    }//ContractType

    public function PeriodType()
    {
        return $this->belongsTo('App\PeriodTypes');
    }//PeriodType

    public function ContributionBase()
    {
        return $this->belongsTo('App\ContributionBases');
    }//ContributionBase

    public function Department()
    {
        return $this->belongsTo('App\Department');
    }//Department

    public function Job()
    {
        return $this->belongsTo('App\Job');
    }//Job

    public function EmployeeType()
    {
        return $this->belongsTo('App\EmployeeTypes');
    }//EmployeeType

    public function PaymentMethod()
    {
        return $this->belongsTo('App\PaymentMethods');
    }//PaymentMethod

    public function WorkShift()
    {
        return $this->belongsTo('App\WorkShifts');
    }//WorkShift

    public function Sex()
    {
        return $this->belongsTo('App\Sex');
    }//Sex

    public function DiscountType()
    {
        return $this->belongsTo('App\DiscountTypes');
    }//DiscountType

}
