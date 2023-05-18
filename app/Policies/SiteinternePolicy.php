<?php

namespace App\Policies;

use App\Models\Siteinterne;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SiteinternePolicy
{
    use HandlesAuthorization;

    
    /**
     * Determine si le user peut ajouter un site interne.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function verifier(User $user, $permission)
    {
        
       return $user->role->havePermissionByName($permission);
      
    }

     /**
     * Determine si le user peut modifier un site interne.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function modifier(User $user)
    {
        return true;
    }

     /**
     * Determine si le user peut afficher un site interne.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function afficher(User $user)
    {
        return true;
    }
 
    /**
     * Determine si le user peut supprimer un site interne.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function supprimer(User $user)
    {
        return true;
    }
   
}
