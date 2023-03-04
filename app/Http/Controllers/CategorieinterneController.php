<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorieinterne;
use App\Models\Siteinterne;
use App\Models\Siteexterne;
use App\Models\CategorieexterneCategorieinterne;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;


class CategorieinterneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($site_id)
    {
        $site_id = Crypt::decrypt($site_id);
        $categories = Categorieinterne::where('siteinterne_id', $site_id)->get();
        $siteinterne = Siteinterne::where('id', $site_id)->first();

        

        return view('categorieinterne.index', compact('categories','siteinterne','site_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    

        $request->validate([
            "nom"=> "required|string",           
        ]);
        // Vérifier si la catégorie existe déjà

        $categorie = Categorieinterne::where([['siteinterne_id', $request->siteinterne_id], ['nom', $request->nom]])->first();

        if($categorie != null) return  redirect()->back()->with('nok', "La catégorie $request->nom existe déjà");

        

        $siteinterne = Siteinterne::where('id', $request->siteinterne_id)->first();


        // retirer "/" s'il existe en fin de l'url      
        $domaine = rtrim($siteinterne->url, '/');

        $response = Http::post("$domaine/wp-json/jwt-auth/v1/token", [
            'username' => $siteinterne->login,
            'password' => $siteinterne->password,
        ]);

        $token = $response->json()['token'] ;
        
        $curl = curl_init();

       

        $resp = Http::withToken($token)
        ->post("$domaine/wp-json/wp/v2/categories",

                [
                    "name" => $request->nom
                ]
        );

           
        $fileResponse = json_decode($resp,true);
    



        $categorieinterne = Categorieinterne::create([
            "nom"=> $request->nom,
            "siteinterne_id"=> $request->siteinterne_id,
            "wp_id"=> $resp['id'],
            "url"=> $resp['link'],
        ]);

        if($categorieinterne != false) {
            
            $siteexternes =  Siteexterne::where('est_archive', false)->get();

            // return view('categorieinterne.edit', compact('categorieinterne', 'siteexternes'));
            return redirect()->route('categorie_interne.edit',Crypt::encrypt($categorieinterne->id))->with('ok',' Catégorie créée');



        }else{
            return redirect()->back()->with('nok',' Erreur: Catégorie non ajoutée');


        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categorieinterne_id)
    {
       
        $categorieinterne = Categorieinterne::where('id', Crypt::decrypt($categorieinterne_id))->first();
        $siteexternes =  Siteexterne::where('est_archive', false)->get();


        return view('categorieinterne.edit', compact('categorieinterne','siteexternes'));
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $categorieinterne_id)
    {
        $categorieinterne = Categorieinterne::where('id', Crypt::decrypt($categorieinterne_id))->first();

        // Trier par client ID plus tard 
        CategorieexterneCategorieinterne::where('categorieinterne_id',Crypt::decrypt($categorieinterne_id) )->delete();
        
        $nom = $request->nom;
        $req = $request->all();

        unset($req['_token']);
        unset($req['nom']);

        $categorieexterne_ids = array_keys($req);
        $categorieinterne->categorieexternes()->attach($categorieexterne_ids);
        
        return redirect()->back()->with('ok',' Terminé');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
