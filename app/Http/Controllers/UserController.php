<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    /**
     * Retourne la liste des utilisateurs
    */

     public function index(){

        $utilisateurs = User::orderBy('nom', 'asc')->get();
        $roles = Role::all();
        $clients = Client::all();

        return view('utilisateur.index', compact('utilisateurs', 'roles','clients'));
    }


     /**
     * Retourne la liste des utilisateurs
     */

    public function store(Request $request){

        
        $request->validate([
            'email' => 'email|required|unique:users,email',
            'nom' => 'string|required',
            'client_id' => 'string|required',
            'role_id' => 'string|required',
        ]);


        User::create([
            "nom" => $request->nom,
            "prenom" => $request->prenom,
            "email" => $request->email,
            "password" =>  Hash::make($request->password),
            "client_id" => $request->client_id,
            "role_id" => $request->role_id,
        ]);

        return redirect()->route('utilisateur.index')->with('message', 'Nouvel utilisateur ajouté');
    }

     /**
     * Retourne la liste des utilisateurs
     */

    public function update(Request $request, $utilisateurId){


        $utilisateur = User::where('id', Crypt::decrypt($utilisateurId))->first();
        


        if($utilisateur->email != $request->email){
            $request->validate([
                'email' => 'string|required|unique:users,email',
                'nom' => 'string|required',
                'client_id' => 'string|required',
                'role_id' => 'string|required',
            ]);
        }

        $utilisateur->nom = $request->nom;
        $utilisateur->prenom = $request->prenom;
        $utilisateur->email = $request->email;
        $utilisateur->client_id = $request->client_id;
        $utilisateur->role_id = $request->role_id;

        if($request->password  != null){
            $utilisateur->password = Hash::make($request->password);
        }
        $utilisateur->update();
      
        return redirect()->route('utilisateur.index')->with('message', 'Utilisateur modifié');
    }

     /**
     * Retourne la liste des utilisateurs
     */

    public function archive($utilisateurId){

        $utilisateur = User::where('id', $utilisateurId)->first();
        $utilisateur->archive = true;
        $utilisateur->update();
        return $utilisateur->id;
        // return redirect()->route('utilisateur.index')->with('message', 'Rôle archivé');

    }

    /**
    * Retourne la liste des utilisateurs
    */

    public function unarchive($utilisateurId){

        $utilisateur = User::where('id', $utilisateurId)->first();
        $utilisateur->archive = false;
        $utilisateur->update();
        return $utilisateur->id;
        // return redirect()->route('utilisateur.index')->with('message', 'Rôle désarchivé');

    }

   
  
}
