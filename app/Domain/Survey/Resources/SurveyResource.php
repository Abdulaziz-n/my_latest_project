<?php

namespace Usoft\Survey\Resources;

use Usoft\Organization\Resources\OrganizationResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
//            'organization' => $this->whenLoaded('organization', new OrganizationResource($this->organization)),
            'is_draft' => $this->is_draft,
            'position' => $this->position,
//            'questions' => $this->whenLoaded('questions', $this->questions),
            'dependent_survey' => $this->whenLoaded('dependentSurvey', $this->dependentSurvey),
            'is_dependent' => $this->is_dependent
        ];

    }
}
