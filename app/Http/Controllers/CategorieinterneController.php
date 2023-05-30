<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorieinterne;
use App\Models\Categorieexterne;
use App\Models\Siteinterne;
use App\Models\Siteexterne;
use App\Models\Categoriearticle;
use App\Models\Pays;
use App\Models\CategorieexterneCategorieinterne;
use App\Models\SiteexterneSiteinterne;

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
        $this->authorize('permission', 'afficher-categorie-interne');
       
        $site_id = Crypt::decrypt($site_id);

        $categoriearticles = Categoriearticle::where([['est_archive',false]])->get();
        $categories = Categorieinterne::where('siteinterne_id', $site_id)->get();
        $siteinterne = Siteinterne::where('id', $site_id)->first();
        

        return view('categorieinterne.index', compact('categories','categoriearticles','siteinterne','site_id'));
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $this->authorize('permission', 'ajouter-categorie-interne');

        $request->validate([
            "nom"=> "required|string",           
        ]);
        // Vérifier si la catégorie existe déjà

        $categorie = Categorieinterne::where([['siteinterne_id', $request->siteinterne_id], ['nom', $request->nom]])->first();

        if($categorie != null) return  redirect()->back()->with('nok', "La catégorie $request->nom existe déjà");

        

        $siteinterne = Siteinterne::where('id', $request->siteinterne_id)->first();

        if($request->categorie_cree == "non"){


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
                "categoriearticle_id"=> $request->categoriearticle_id,
                "wp_id"=> $resp['id'],
                "url"=> $resp['link'],
            ]);

        }else{

            $categorieinterne = Categorieinterne::create([
                "nom"=> $request->nom,
                "siteinterne_id"=> $request->siteinterne_id,
                "categoriearticle_id"=> $request->categoriearticle_id,
                "wp_id"=> $request->wp_id,
                "url"=> $request->url,
            ]);

            
        }


        if($categorieinterne != false) {
            
            return redirect()->route('categorie_interne.edit',Crypt::encrypt($categorieinterne->id))->with('ok',' Catégorie créée');
        }else{
            return redirect()->back()->with('nok',' Erreur: Catégorie non ajoutée');


        }
    }
    


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categorieinterne_id, $pays = null)
    {
        $this->authorize('permission', 'modifier-categorie-interne');
      
        $categorieinterne = Categorieinterne::where('id', Crypt::decrypt($categorieinterne_id))->first();
        $categoriearticles = Categoriearticle::where([['est_archive',false]])->get();

        if($pays == "all"){
            $siteexternes =  Siteexterne::where('est_archive', false)->get();
            $paysSelect = "all";
        }elseif($pays == null ){
            
            $paysSelect = Pays::where('id',$categorieinterne->siteinterne->pay_id)->first();
            $siteexternes =  Siteexterne::where([['est_archive', false], ['pay_id', $paysSelect->id]])->get();

        
        }else{
            $paysSelect = Pays::where('id',$pays)->first();
            $siteexternes =  Siteexterne::where([['est_archive', false], ['pay_id', $paysSelect->id]])->get();

        }


        $pays = Pays::all();
        $url = "/categorie-interne/edit/$categorieinterne_id";

        return view('categorieinterne.edit', compact('categorieinterne','categoriearticles','siteexternes', 'pays','paysSelect','url'));
      
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
        $this->authorize('permission', 'modifier-categorie-interne');

        $categorieinterne = Categorieinterne::where('id', Crypt::decrypt($categorieinterne_id))->first();
        $siteinterne = $categorieinterne->siteinterne;

        // Trier par client ID plus tard 
        CategorieexterneCategorieinterne::where('categorieinterne_id',Crypt::decrypt($categorieinterne_id) )->delete();
        SiteexterneSiteinterne::where('siteinterne_id',$siteinterne->id )->delete();
        
        $categorieinterne->nom = $request->nom;
        $categorieinterne->wp_id = $request->wp_id;
        $categorieinterne->url = $request->url;
        $categorieinterne->categoriearticle_id = $request->categoriearticle_id;

        $categorieinterne->update();

        $req = $request->all();

        unset($req['_token']);
        unset($req['nom']);
        unset($req['wp_id']);
        unset($req['url']);
        unset($req['categoriearticle_id']);


        
        $categorieexterne_ids = array_keys($req);

        // Lier tous les sites internes aux sites externes
        $categorieexternes = Categorieexterne::whereIn('id', $categorieexterne_ids )->get();

        foreach ($categorieexternes as $categorieexterne) {
            $siteinterne->siteexternes()->attach($categorieexterne->siteexterne_id);
        }
      
        // Lier les catégories internes aux catégories externes
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
        $this->authorize('permission', 'supprimer-categorie-interne');

    }
}
