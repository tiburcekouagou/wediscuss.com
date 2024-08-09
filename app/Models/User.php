<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $avatar
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property int $is_admin
 * @property string|null $blocked_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBlockedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'avatar',
        'email',
        'password',
        'is_admin',
        'blocked_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Définit une relation plusieurs-à-plusieurs entre User et Group.
     * 
     * Cette méthode établit une relation "plusieurs-à-plusieurs" entre le modèle User et le modèle Group.
     * Elle utilise une table pivot nommée 'group_user' pour associer les utilisateurs à plusieurs groupes.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *    Instance de la relation qui permet d'interroger les modèles Group associés.
     */
    public function groups()
    {
        // Établit la relation en utilisant la table pivot 'group_user'
        return $this->belongsToMany(Group::class, 'group_user');
    }

    /**
     * Définit une relation un-à-plusieurs entre User et Message.
     * 
     * Cette méthode établit une relation "un-à-plusieurs" entre le modèle User et le modèle Message.
     * Cela signifie qu'un utilisateur peut avoir plusieurs messages associés à lui.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *    Instance de la relation qui permet d'interroger les modèles Message associés.
     */
    public function messages()
    {
        // Établit la relation où un utilisateur peut avoir plusieurs messages
        return $this->hasMany(Message::class);
    }

    /**
     * Récupère tous les utilisateurs excepté celui connecté et les conversations associées
     * @param \App\Models\User $user
     * @return \Illuminate\Support\Collection
     */
    public static function getUsersExcept(User $user)
    {
        $userId = $user->id;

        $query = User::select(["users.*", "messages.message as last_message", "messages.created_at as last_message_date"])
            ->where("users.id", "!=", $userId)
            ->when(!$user->is_admin, function ($query) {
                $query->whereNull("users.blocked_at");
            })
            ->leftJoin("conversations", function ($join) use ($userId) {
                $join->on("conversations.user_id1", "=", "users.id")
                    ->where("conversations.user_id2", "=", $userId)
                    ->orWhere(function ($query) use ($userId) {
                        $query->on("conversations.user_id2", "=", "users.id")
                            ->where("conversations.user_id1", "=", $userId);
                    });
            })
            ->leftJoin("messages", "messages.id", "=", "conversations.last_message_id")
            ->orderByRaw("IFNULL(users.blocked_at, 1)")
            ->orderBy("messages.created_at", "desc")
            ->orderBy("users.name");

        return $query->get();
    }

    /**
     * Méthode qui transform le modèle en tableau
     * @return array
     */
    public function toConversationArray() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_group' => false,
            'is_user' => true,
            'is_admin' => $this->is_admin,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'blocked_at' => $this->blocked_at,
            'last_message' => $this->last_message,
            'last_message_date' => $this->last_message_date,
        ];
    }

}
