<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pays;
use App\Models\Siteinterne;
use Auth;
class HomeController extends Controller
{
    
    public function index(){

        
        $user = Auth::user();
        $siteinternes = $user->role->nom == "Super-Admin" ? Siteinterne::where('est_archive',false)->get() : Siteinterne::where([['client_id', $user->client_id], ['est_archive', false]])->get();
        $pays_id = array();
        dd($siteinternes);
        foreach ($siteinternes as $siteinterne) {
          $pays_id[] = $siteinterne->pay_id;
        }
        $pays = Pays::whereIn('id', $pays_id)->orderBy('nom')->get();

        // $paySite = array();
        // foreach ($pays as $pay) {
        //     $sites = array();
        //     foreach ($pay->siteinternesClient as $site) {
        //         // $sites["nom_site"] = $site->nom;
        //         // $sites["url_site"] = $site->url;
        //         // $sites["id_site"] = $site->id;
        //         $sites[] = array('nom_site'=> $site->nom,'url_site'=> $site->url,'id_site'=> $site->id);
        //     }
        //     $paySite[] = array($pay->nom, $sites);
        // }
   
        
        // $paySite = json_encode($paySite);
     

        return view('welcome', compact('pays'));
    }
}
