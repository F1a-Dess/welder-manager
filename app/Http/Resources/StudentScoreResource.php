<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentScoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            "student_id"=> $this->student_id,
            "date"=> $this->date,

            "class_prep"=> $this->class_prep,
            "understanding"=> $this->understanding,
            "conversation"=> $this->conversation,
            "vocabulary"=> $this->vocabulary,
            "weekly"=> $this->weekly,
            "k_song"=> $this->k_song,
            "language"=> $this->language, // total
            
            "rci"=> $this->rci,
            "opa"=> $this->opa,
            "ncd"=> $this->ncd,
            "attitude"=> $this->attitude, // total

            "total_score"=> $this->total_score,
            "grade"=> $this->grade,
            "type_weld"=> $this->type_weld,

            "UC"=> $this->UC,
            "OV"=> $this->OV,
            "PO"=> $this->PO,
            "UFVi"=> $this->UFVi,
            "root_visual"=> $this->root_visual,
            "welding_skill"=> $this->welding_skill, // total
        ];
    }
}
