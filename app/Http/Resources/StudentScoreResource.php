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

            "welding_skill"=> $this->welding_skill,
            "language"=> $this->language,
            "attitude"=> $this->attitude,
            "total_score"=> $this->total_score,
            "grade"=> $this->grade,
        ];
    }
}
