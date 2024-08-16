<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\MessageAttachment;
use App\Models\User;
use App\Models\Group;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MessageResource;
use App\Http\Requests\StoreMessageRequest;

class MessageController extends Controller
{

    /**
     * Récupère les messages échangé entre l'utilisateur authentifié et un autre utilisateur spécifique
     * @param \App\Models\User $user
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function byUser(User $user)
    {
        $messages = Message::where('sender_id', Auth::user()->id)
            ->where('receiver_id', $user->id)
            ->orWhere(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', Auth::user()->id);
            })
            ->latest()
            ->paginate(50);

        return inertia('Home', [
            'selectedConversation' => $user->toConversationArray(),
            'messages' => MessageResource::collection($messages),
        ]);
    }

    /**
     * Récupère les messages échangés dans un groupe
     * @param \App\Models\Group $group
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function byGroup(Group $group)
    {
        $messages = Message::where('group_id', $group->id)
            ->latest()
            ->paginate(50);

        return inertia('Home', [
            'selectedConversation' => $group->toConversationArray(),
            'messages' => MessageResource::collection($messages),
        ]);
    }

    /**
     * Récupère les messages plus anciens qu'un message spécifique
     * @param \App\Models\Message $message
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function loadOlder(Message $message)
    {
        if ($message->group_id) { // on récupère les anciens messages d'un groupe
            $messages = Message::where('created_at', '<', $message->created_at)
                ->where('group_id', $message->group_id)
                ->latest()
                ->paginate(50);
        } else {
            $messages = Message::where('created_at', '<', $message->created_at)
                ->where(function ($query) use ($message) {
                    $query->where('sender_id', $message->sender_id)
                        ->where('receiver_id', $message->receiver_id)

                        ->orWhere('sender_id', $message->receiver_id)
                        ->where('receiver_id', $message->sender_id);
                })->latest()
                ->paginate(50);
        }

        return response()->json(MessageResource::collection($messages));
    }

    /**
     * Sauvegarde un message dans la BDD
     * @param \App\Http\Requests\StoreMessageRequest $request
     * @return void
     */
    public function store(StoreMessageRequest $request)
    {
        $data = $request->validated(); // on récupère les données validées
        $data['sender_id'] = Auth::user()->id; // on grèffe l'id de l'envoyeur de msg

        $files = $data['attachments'] ?? [];

        $message = Message::create($data); // sauvegarde le msg
        $attachments = []; // tableau où on stock les pièces jointes

        if ($files) {
            foreach ($files as $file) {
                $directory = 'attachments/' . Str::random(32); // on cré un dossier du genre "attachments/aXdktzeERe"
                Storage::makeDirectory($directory);

                $attachment = MessageAttachment::create([
                    'message_id' => $message->id,
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                    'path' => $file->store($directory, 'public'),
                ]);

                // array_push($attachments, $attachment);
                $attachments[] = $attachment;
            }
            $message->attachments = $attachments;

            // mettre à jour l'id du dernier message
            $receiverId = $data['receiver_id'];
            $groupId = $data['group_id'];

            if ($receiverId) { // si le message est envoyé à quelqu'un (conversation directe)
                // m-a-j l'id du dernier message pour la discussion
                Conversation::updateConversationWithMessage($receiverId, Auth::user()->id, $message);
            }

            if ($groupId) { // si c'est msg de groupe
                // m-a-j l'id du dernier message pour le groupe
                Group::updateGroupWithMessage($groupId, $message);
            }
            // notifier à travers reverb l'utilisateur du nouveau msg
        }

    }

    /**
     * Supprime un message
     * @param \App\Models\Message $message
     * @return mixed|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        // vérifier que l'utilisateur voulant suppr le msg est bien celui l'auteur du message
        if ($message->sender_id !== Auth::user()->id) {
            return response()->json(['message' => 'Action interdite'], 403);
        }

        $message->delete();

        return response()->noContent(); // renvoie une réponse vide avec un code 204
    }
}
