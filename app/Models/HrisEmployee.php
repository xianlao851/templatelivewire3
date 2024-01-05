<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrisEmployee extends Model
{
    use HasFactory;
    protected $connection = 'hris', $table = 'tbl_employee', $primaryKey = 'emp_id';
}
