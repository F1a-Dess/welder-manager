<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";

    protected $fillable = [
        'id',
        'name',
        'wave',
        'no_test'
        ];

    public function scores() {
        return $this->hasMany(StudentScore::class, 'student_id');
    }

    

}
