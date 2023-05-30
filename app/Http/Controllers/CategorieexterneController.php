<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorieexterne;
use App\Models\Siteexterne;
use App\Models\Categoriearticle;
use Illuminate\Support\Facades\Crypt;

class CategorieexterneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($site_id = null)
    {

        $this->authorize('permission', 'afficher-categorie-source');

        if($site_id == null){
            $categories = Categorieexterne::all();

        }else{
            $categories = Categorieexterne::where('siteexterne_id', $site_id)->get();

        }

        $sites = Siteexterne::where([['est_archive', false], ['est_actif', true]])->get();
        $categoriearticles = Categoriearticle::where([['est_archive',false]])->get();

        return view('categorieexterne.index', compact('categories','sites','site_id','categoriearticles'));
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('permission', 'ajouter-categorie-source');

        $request->validate([
            "nom"=> "required|string",
            "url"=> "required|unique:categorieexternes|string",
           
        ]);
           
        
        $categorie = Categorieexterne::create([
            "nom"=> $request->nom,
            "siteexterne_id"=> $request->siteexterne_id,
            "categoriearticle_id"=> $request->categoriearticle_id,
            "url"=> $request->url,
           
        ]);

        return  redirect()->back()->with('ok', 'Catégorie créée');
    }

   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $categorie_id)
    {

        $this->authorize('permission', 'modifier-categorie-source');

        $categorie = Categorieexterne::where('id', Crypt::decrypt($categorie_id))->first();

        if($categorie->url != $request->url){
            $request->validate([
                "url"=> "required|unique:categorieexternes|string",           
            ]);

        }
        
        $request->validate([
            "nom"=> "required|string",
            "url"=> "required|string",           
        ]);
             
        $categorie->nom = $request->nom;
        $categorie->url = $request->url;
        $categorie->categoriearticle_id = $request->categoriearticle_id;
        
        $categorie->update();
        return  redirect()->back()->with('ok', 'Catégorie modifiée');

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
        $this->authorize('permission', 'supprimer-categorie-source');

    }
}
