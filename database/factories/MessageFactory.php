<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // On sélectionne tous les ids  d'utilisateur
        $userIds = \App\Models\User::pluck('id')->toArray();

        // On décide de manière aléatoire si le message est un message direct (conversation) ou un message de group
        $isGroupMessage = fake()->boolean(50);

        // on sélectionne un sender aléatoirement
        $senderId = fake()->randomElement($userIds);

        // On initailise le receiverId et le groupId
        $receiverId = null;
        $groupId = null;

        // si c'est un message de groupe
        if ($isGroupMessage) {
            // On s'assure que le groupe exist dans la BDD
            $groupIds = \App\Models\Group::pluck('id')->toArray();

            if (empty($groupIds)) {
                throw new \Exception("Aucun groupe trouvé dans la base de donnée");
            }
            // on prend au hazard un groupe
            $groupId = fake()->randomElement($groupIds);

            // Sélectionner un groupe aléotoirement
            $group = \App\Models\Group::find($groupId);
            // On récupère un utilisateur du groupe aléotoirement
            $senderId = fake()->randomElement($group->users->pluck('id')->toArray());
        } else {
            // c'est un message direct qu'on envoie
            // sélectionner un receiver qui est différent du sender
            $receiverId = fake()->randomElement(array_diff($userIds, [$senderId])); // array_diff([1, 2, 3, 4, 5], [3]) => [1, 2, 4, 5]
        }

        // Trouver et créer un conversation directe entre the sender et le receiver
        $conversationId = null;

        if (!$isGroupMessage) {
            $conversationId = \App\Models\Conversation::firstOrCreate(
                [
                    'user_id1' => min($senderId, $receiverId),
                    'user_id2' => max($senderId, $receiverId),
                ],
                [
                    'last_message_id' => null,
                ]
            );
        }

        return [
            'message' => fake()->realText(),
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'group_id' => $groupId,
            'conversation_id' => $conversationId,
        ];
    }
}
