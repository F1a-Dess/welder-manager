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

        // language detail
        "language", // summary of all data below
        "class_prep",
        "understanding",
        "conversation",
        "vocabulary",
        "weekly",
        "k_song",

        // attitude detail
        "attitude", // summary of all data below
        "rci",
        "opa",
        "ncd",

        // summary
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
