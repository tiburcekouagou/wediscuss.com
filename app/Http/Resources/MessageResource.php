<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'message' => $this->message,
            'sender_id' => $this->sender_id,
            'sender' => new UserResource($this->sender),
            'receiver_id' => $this->receiver_id,
            'group_id' => $this->group_id,
            'attachments' => $this->attachments->count() ? new MessageAttachmentResource($this->attachments) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
