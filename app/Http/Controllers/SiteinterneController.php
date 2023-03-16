<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siteinterne;
use App\Models\Pays;
use Illuminate\Support\Facades\Crypt;

class SiteinterneController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Siteinterne::where('est_archive', false)->get();
        $pays = Pays::all();

        return view('siteinterne.index', compact('sites','pays'));
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
            "nom"=> "required|unique:siteinternes|string",
            "url"=> "required|unique:siteinternes|string",
            "login"=> "required|string",
            "password"=> "required|string",
        ]);
        
     
        
        $site = Siteinterne::create([
            "nom"=> $request->nom,
            "url"=> $request->url,
            "pays_id"=> $request->pays,
            "login"=> $request->login,
            "password"=> $request->password,
            "est_diffuse_auto"=> $request->est_diffuse_auto == "on" ? true : false,
            
        ]);
        
        // return  redirect()->route()->with('ok', 'Site interne créé');



        return  redirect()->back()->with('ok', 'Site interne créé');
    }


    /**
     * Associer des sites externe au site interne
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function joinSiteexterne($site_id)
    {
        $site = Siteinterne::where('id', Crypt::decrypt($site_id))->first();
        $pays = Pays::all();
       

        return view('siteinterne.join_siteexterne', compact('pays','site'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

            
       
        $site = Siteinterne::where('id', Crypt::decrypt($site_id))->first();
        

        $request->validate([  
            "login"=> "required|string",
            "password"=> "required|string",
        ]);

        if($site->nom != $request->nom){
            $request->validate([
                "nom"=> "required|unique:siteinternes|string",
                "url"=> "required|unique:siteinternes|string",           
            ]);
        }

        if($site->url != $request->url){
            $request->validate([
                "url"=> "required|unique:siteinternes|string",           
            ]);
        }

      

        $site->nom = $request->nom;
        $site->url = $request->url;
        $site->pays_id = $request->pays;
        $site->login = $request->login;
        $site->password = $request->password;
        $site->est_diffuse_auto = $request->est_diffuse_auto == "on" ? true : false;
       
        
        $site->update();

        return  redirect()->back()->with('ok', 'Site interne modifié');
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
