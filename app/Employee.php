<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['emp_name', 'emp_status'];
    public $table = 'employee';
}
