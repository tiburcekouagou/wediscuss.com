<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'owner_id',
        'last_message_id',
    ];

    /**
     * Définit une relation plusieurs-à-plusieurs entre Group et User.
     * 
     * Cette méthode établit une relation "plusieurs-à-plusieurs" (belongsToMany) entre le modèle Group et le modèle User.
     * Elle utilise une table pivot nommée 'group_user' pour associer les groupes à plusieurs utilisateurs.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *    Instance de la relation qui permet d'interroger les utilisateurs associés au groupe.
     */
    public function users()
    {
        // Établit la relation en utilisant la table pivot 'group_user'
        // return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
        return $this->belongsToMany(User::class, 'group_user');
    }

    /**
     * Définit une relation un-à-plusieurs entre Group et Message.
     * 
     * Cette méthode établit une relation "un-à-plusieurs" (hasMany) entre le modèle Group et le modèle Message.
     * Cela signifie qu'un groupe peut avoir plusieurs messages associés.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *    Instance de la relation qui permet d'interroger les messages associés au groupe.
     */
    public function messages()
    {
        // Établit la relation où un groupe peut avoir plusieurs messages
        return $this->hasMany(Message::class);
    }

    /**
     * Définit une relation de type "appartient à" avec le modèle User pour le propriétaire du groupe.
     * 
     * Cette méthode établit une relation "appartient à" (belongsTo) entre ce modèle et le modèle User,
     * identifiant l'utilisateur propriétaire du groupe.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *    Instance de la relation qui permet d'accéder au propriétaire du groupe.
     */
    public function owner()
    {
        // Établit la relation avec le modèle User pour identifier le propriétaire du groupe
        return $this->belongsTo(User::class);
    }

}
