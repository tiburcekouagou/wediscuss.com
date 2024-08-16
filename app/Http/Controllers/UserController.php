<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Fonction permettant de bloquer un utilisateur
     * @param string|int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function blockUser(string|int $id) {
        $user = User::find($id); // on recherche la personne à bloquer
        
        if ($user) {
            // $user->blocked_at = Carbon::now();
            $user->blocked_at = now();
            $user->save();
            
            return response()->json(['message' => 'Utilisateur bloqué avec succès']);
        }
        
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }

    /**
     * Fonction permettant de débloquer un utilisateur
     * @param string|int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function unblockUser(string|int $id) {
        $user = User::find($id); // on recherche la personne à bloquer

        if ($user) {
            $user->blocked_at = null;
            $user->save();
            
            return response()->json(['message' => 'Utilisateur débloqué avec succès']);
        }
        
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }
}
