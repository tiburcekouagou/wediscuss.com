<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $last_message_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereLastMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
