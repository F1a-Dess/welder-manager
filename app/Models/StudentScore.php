<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentScore extends Model
{
    use HasFactory;

    protected $table ="student_scores";

    protected $fillable = [
        "id",
        "student_id",
        "date",
        
        // weekly
        "language",
        "attitude",
        "total_score",
        "grade",
        "type_weld",
        
        // daily
        "welding_skill", // total score of the scores below
        "UC",
        "OV",
        "PO",
        "UFVi",
        "root_visual",
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }

    
}
