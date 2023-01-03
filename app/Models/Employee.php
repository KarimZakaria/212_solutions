<?php

namespace App\Models;

use App\Events\EmployeeCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $dispatchesEvents = [
        'created' => EmployeeCreated::class
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
