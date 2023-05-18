<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class ClientController extends Controller
{
        /**
     * Retourne la liste des clients
    */

    public function index(){

        $clients = User::orderBy('nom', 'asc')->get();
        $roles = Role::all();
        $clients = Client::all();

    
        return view('client.index', compact('clients', 'roles','clients'));
    }


     /**
     * Retourne la liste des clients
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

        return redirect()->route('client.index')->with('message', 'Nouvel client ajouté');
    }

     /**
     * Retourne la liste des clients
     */

    public function update(Request $request, $clientId){


        $client = User::where('id', Crypt::decrypt($clientId))->first();
        


        if($client->email != $request->email){
            $request->validate([
                'email' => 'string|required|unique:users,email',
                'nom' => 'string|required',
                'client_id' => 'string|required',
                'role_id' => 'string|required',
            ]);
        }

        $client->nom = $request->nom;
        $client->prenom = $request->prenom;
        $client->email = $request->email;
        $client->client_id = $request->client_id;
        $client->role_id = $request->role_id;

        if($request->password  != null){
            $client->password = Hash::make($request->password);
        }
        $client->update();
      
        return redirect()->route('client.index')->with('message', 'Client modifié');
    }

     /**
     * Retourne la liste des clients
     */

    public function archive($clientId){

        $client = User::where('id', $clientId)->first();
        $client->archive = true;
        $client->update();
        return $client->id;
        // return redirect()->route('client.index')->with('message', 'Rôle archivé');

    }

    /**
    * Retourne la liste des clients
    */

    public function unarchive($clientId){

        $client = User::where('id', $clientId)->first();
        $client->archive = false;
        $client->update();
        return $client->id;
        // return redirect()->route('client.index')->with('message', 'Rôle désarchivé');

    }
}
