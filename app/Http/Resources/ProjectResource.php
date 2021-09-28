<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $available = 1;

        // Check if user is the owner of the project.
        if (Auth::user()->id === $this->user->id) {
            $available = 0;
        }

        // Check if the user already requested to join the project.
        foreach (UserResource::collection($this->applications) as $user) {
            if (Auth::user()->id === $user['id']) {
                $available = 0;
                break;
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'academies' => $this->academies,
            'applications' => count($this->applications),
            'author' => new UserResource($this->user),
            'available' => $available,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
