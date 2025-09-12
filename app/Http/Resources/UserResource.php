<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return
        [
            'identifier'=>$this->id ,
            'name'=>$this->name  ,
            'email'=>$this->email  ,
            'created_at'=>$this->created_at->format('Y-m-d') ,
            'profile'=> new ProfileResource($this->whenLoaded('profile')) ,
            'tasks'=> $this->whenLoaded('tasks') ,
            'Favorite_Tasks'=>$this->whenLoaded('favoriteTask')
        ] ;
    }
}
