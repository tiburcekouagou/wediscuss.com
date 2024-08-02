<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'message',
        'sender_id',
        'receiver_id',
        'group_id',
        'conversation_id',
        'last_message_id',
    ];

/**
 * Définit une relation de type "appartient à" avec le modèle User en tant qu'expéditeur.
 * 
 * Cette méthode établit une relation "appartient à" (belongsTo) entre ce modèle et le modèle User
 * en utilisant la colonne 'sender_id' pour identifier l'utilisateur qui a envoyé le message.
 * 
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 *    Instance de la relation qui permet d'accéder à l'utilisateur expéditeur.
 */
public function sender() {
    // Établit la relation en utilisant la clé étrangère 'sender_id' pour l'utilisateur expéditeur
    return $this->belongsTo(User::class, 'sender_id');
}

/**
 * Définit une relation de type "appartient à" avec le modèle User en tant que destinataire.
 * 
 * Cette méthode établit une relation "appartient à" (belongsTo) entre ce modèle et le modèle User
 * en utilisant la colonne 'receiver_id' pour identifier l'utilisateur qui reçoit le message.
 * 
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 *    Instance de la relation qui permet d'accéder à l'utilisateur destinataire.
 */
public function receiver() {
    // Établit la relation en utilisant la clé étrangère 'receiver_id' pour l'utilisateur destinataire
    return $this->belongsTo(User::class, 'receiver_id');
}

/**
 * Définit une relation de type "appartient à" avec le modèle Group.
 * 
 * Cette méthode établit une relation "appartient à" (belongsTo) entre ce modèle et le modèle Group,
 * permettant d'associer ce message à un groupe spécifique.
 * 
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 *    Instance de la relation qui permet d'accéder au groupe associé.
 */
public function group() {
    // Établit la relation sans préciser la clé étrangère (utilisation par défaut de 'group_id')
    return $this->belongsTo(Group::class);
}

/**
 * Définit une relation de type "un-à-plusieurs" avec le modèle MessageAttachment.
 * 
 * Cette méthode établit une relation "un-à-plusieurs" (hasMany) entre ce modèle et le modèle 
 * MessageAttachment, indiquant qu'un message peut avoir plusieurs pièces jointes.
 * 
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 *    Instance de la relation qui permet d'interroger les pièces jointes associées au message.
 */
public function attachments() {
    // Établit la relation où un message peut avoir plusieurs pièces jointes
    return $this->hasMany(MessageAttachment::class);
}



}
