<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id1
 * @property int $user_id2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $last_message_id
 * @property-read \App\Models\Message|null $lastMessage
 * @property-read \App\Models\User $user1
 * @property-read \App\Models\User $user2
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereLastMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereUserId1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereUserId2($value)
 * @mixin \Eloquent
 */
class Conversation extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id1',
        'user_id2',
        'last_message_id',
    ];
    /**
     * Définit une relation de type "appartient à" avec le modèle Message en tant que dernier message.
     * 
     * Cette méthode établit une relation "appartient à" (belongsTo) entre ce modèle et le modèle Message,
     * permettant d'identifier le dernier message associé.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *    Instance de la relation qui permet d'accéder au dernier message associé.
     */
    public function lastMessage()
    {
        // Établit la relation avec le modèle Message pour récupérer le dernier message
        return $this->belongsTo(Message::class);
    }

    /**
     * Définit une relation de type "appartient à" avec le modèle User pour l'utilisateur 1.
     * 
     * Cette méthode établit une relation "appartient à" (belongsTo) entre ce modèle et le modèle User
     * en utilisant la colonne 'user_id1' pour identifier le premier utilisateur associé.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *    Instance de la relation qui permet d'accéder au premier utilisateur.
     */
    public function user1()
    {
        // Établit la relation en utilisant la clé étrangère 'user_id1' pour le premier utilisateur
        return $this->belongsTo(User::class, 'user_id1');
    }

    /**
     * Définit une relation de type "appartient à" avec le modèle User pour l'utilisateur 2.
     * 
     * Cette méthode établit une relation "appartient à" (belongsTo) entre ce modèle et le modèle User
     * en utilisant la colonne 'user_id2' pour identifier le deuxième utilisateur associé.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *    Instance de la relation qui permet d'accéder au deuxième utilisateur.
     */
    public function user2()
    {
        // Établit la relation en utilisant la clé étrangère 'user_id2' pour le deuxième utilisateur
        return $this->belongsTo(User::class, 'user_id2');
    }

}
