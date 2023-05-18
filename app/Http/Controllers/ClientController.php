<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Client;
use App\Models\Pays;
use App\Models\Langue;
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
        $pays = Pays::all();
        $langues = Langue::all();
        $clients = Client::all();

    
        return view('client.index', compact('clients', 'roles','clients','pays','langues'));
    }


     /**
     * Retourne la liste des clients
     */

    public function store(Request $request){

  
        
        $request->validate([
            'email' => 'email|required|unique:clients',
            'raison_sociale' => 'string|required',
            'pays_id' => 'required',
            'langue_id' => 'required',
        ]);


        Client::create([
            "raison_sociale" => $request->raison_sociale,
            "contact1" => $request->contact1,
            "contact2" => $request->contact2,
            "email" => $request->email,          
            "pay_id" => $request->pays_id,
            "langue_id" => $request->langue_id,
        ]);

        return redirect()->route('client.index')->with('message', 'Nouveau client ajouté');
    }

     /**
     * Retourne la liste des clients
     */

    public function update(Request $request, $clientId){


        $client = Client::where('id', Crypt::decrypt($clientId))->first();
        


        if($client->email != $request->email){
            $request->validate([
                'email' => 'email|required|unique:clients',

            ]);
        }

        $request->validate([              
            'pays_id' => 'required',
            'langue_id' => 'required',
        ]);

         

        $client->raison_sociale = $request->raison_sociale;
        $client->contact1 = $request->contact1;
        $client->contact2 = $request->contact2;
        $client->email = $request->email;
        $client->pay_id = $request->pays_id;
        $client->langue_id = $request->langue_id;

       
        $client->update();
      
        return redirect()->route('client.index')->with('message', 'Client modifié');
    }

     /**
     * Retourne la liste des clients
     */

    public function archive($clientId){

        $client = Client::where('id', $clientId)->first();
        $client->est_archive = true;
        $client->update();
        return $client->id;
        // return redirect()->route('client.index')->with('message', 'Rôle archivé');

    }

    /**
    * Retourne la liste des clients
    */

    public function unarchive($clientId){

        $client = Client::where('id', $clientId)->first();
        $client->est_archive = false;
        $client->update();
        return $client->id;
        // return redirect()->route('client.index')->with('message', 'Rôle désarchivé');

    }
}
