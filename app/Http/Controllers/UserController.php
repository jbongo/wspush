<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Auth;

class UserController extends Controller
{
    /**
     * Retourne la liste des utilisateurs
    */

     public function index(){

        $this->authorize('permission', 'afficher-utilisateur');
        if(Auth::user()->is_admin){
            $utilisateurs = User::orderBy('nom', 'asc')->get();
        }else{
            $utilisateurs = User::where('client_id', Auth::user()->client_id)->orderBy('nom', 'asc')->get();

        }
        $roles = Role::all();
        $clients = Client::all();

        return view('utilisateur.index', compact('utilisateurs', 'roles','clients'));
    }


     /**
     * Retourne la liste des utilisateurs
     */

    public function store(Request $request){

        $this->authorize('permission', 'ajouter-utilisateur');
        
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

        $this->authorize('permission', 'modifier-utilisateur');

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

        $this->authorize('permission', 'archiver-utilisateur');

        $utilisateur = User::where('id', $utilisateurId)->first();
        $utilisateur->archive = true;
        $utilisateur->update();
        return $utilisateur->id;

    }

    /**
    * Retourne la liste des utilisateurs
    */

    public function unarchive($utilisateurId){

        $this->authorize('permission', 'archive-utilisateur');

        $utilisateur = User::where('id', $utilisateurId)->first();
        $utilisateur->archive = false;
        $utilisateur->update();
        return $utilisateur->id;

    }

   
  
}
