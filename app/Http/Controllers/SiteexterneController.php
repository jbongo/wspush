<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siteexterne;
use App\Models\Pays;
use App\Models\Categoriearticle;
use Illuminate\Support\Facades\Crypt;

class SiteexterneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('permission', 'afficher-site-source');

        $sites = Siteexterne::where('est_archive', false)->get();
        $pays = Pays::all();
        $categories = Categoriearticle::where([['est_archive',false]])->get();


        return view('siteexterne.index', compact('sites','pays','categories'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('permission', 'ajouter-site-source');

        $request->validate([
            "nom"=> "required|unique:siteexternes|string",
            "url"=> "required|unique:siteexternes|string",
            "selecteur_lien"=> "required|string",
            "selecteur_titre"=> "required|string",
            "selecteur_contenu"=> "required|string",
            "selecteur_image"=> "required|string",
        ]);
        
     
        
        $site = Siteexterne::create([
            "nom"=> $request->nom,
            "url"=> $request->url,
            "selecteur_lien"=> $request->selecteur_lien,
            "selecteur_titre"=> $request->selecteur_titre,
            "selecteur_contenu"=> $request->selecteur_contenu,
            "pay_id"=> $request->pays,
            "selecteur_image"=> $request->selecteur_image,
            "image_affiche_css"=> $request->image_affiche_css == "Non" ? false : true,
            "est_wordpress"=> $request->est_wordpress == "Non" ? false : true,
        ]);

        return  redirect()->back()->with('ok', 'Site externe créé');
    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $site_id)
    {
        $this->authorize('permission', 'modifier-site-source');
       
        $site = Siteexterne::where('id', Crypt::decrypt($site_id))->first();
        

        $request->validate([  
            "selecteur_lien"=> "required|string",
            "selecteur_titre"=> "required|string",
            "selecteur_contenu"=> "required|string",
            "selecteur_image"=> "required|string",
        ]);

        if($site->nom != $request->nom){
            $request->validate([
                "nom"=> "required|unique:siteexternes|string",
                "url"=> "required|unique:siteexternes|string",           
            ]);
        }

        if($site->url != $request->url){
            $request->validate([
                "url"=> "required|unique:siteexternes|string",           
            ]);
        }

      

        $site->nom = $request->nom;
        $site->url = $request->url;
        $site->selecteur_lien = $request->selecteur_lien;
        $site->selecteur_titre = $request->selecteur_titre;
        $site->selecteur_contenu = $request->selecteur_contenu;
        $site->pay_id = $request->pays;
        $site->selecteur_image = $request->selecteur_image;
        $site->image_affiche_css = $request->image_affiche_css == "Non" ? false : true;
        $site->est_wordpress = $request->est_wordpress == "Non" ? false : true;
        
        $site->update();

        return  redirect()->back()->with('ok', 'Site externe modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('permission', 'supprimer-site-source');

    }
}
