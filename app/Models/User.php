<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
public function groups() {
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
public function messages() {
    // Établit la relation où un utilisateur peut avoir plusieurs messages
    return $this->hasMany(Message::class);
}

}
