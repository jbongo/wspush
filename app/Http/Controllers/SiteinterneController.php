<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siteinterne;
use App\Models\Pays;
use App\Models\Article;
use App\Models\Categorieinterne;
use App\Models\Categorieexterne;
use App\Models\CategorieexterneCategorieinterne;
use App\Models\ArticleCategorieinterne;
use App\Models\Categoriearticle;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class SiteinterneController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('permission', 'afficher-site');

        // $sites = Siteinterne::where('est_archive', false)->get();

        $user = Auth::user();
        $sites = $user->role->nom == "Super-Admin" ? Siteinterne::where('est_archive',false)->get() : Siteinterne::where([['client_id', $user->client_id], ['est_archive', false]])->get();

        $pays = Pays::all();
        $categories = Categoriearticle::where([['est_archive',false]])->get();


        return view('siteinterne.index', compact('sites','pays','categories'));
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('permission', 'ajouter-site');

        $request->validate([
            "nom"=> "required|unique:siteinternes|string",
            "url"=> "required|unique:siteinternes|string",
            "login"=> "required|string",
            "password"=> "required|string",
        ]);
        
     
        
        $site = Siteinterne::create([
            "nom"=> $request->nom,
            "url"=> $request->url,
            "pay_id"=> $request->pays,
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
     * Alimenter le site en articles
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function alimenter(Request $request, $site_id)
    {
        set_time_limit(0);

        $this->authorize('permission', 'alimenter-site');


        $siteinterne = Siteinterne::where('id', Crypt::decrypt($site_id))->first();
        
        // On reccupère tous les sites sources wp du site interne
        $siteexternes = $siteinterne->siteexternesWp;

        if(sizeof($siteexternes)  == 0){
            return redirect()->back()->with('nok','Article Non Publié Aucun site source WP lié au site');
        }


        // On deternime toutes les urls des catégories externes à partir des catégories internes
        $categorieInternes= Categorieinterne::where('siteinterne_id', $siteinterne->id)->get();

             
        $wp_cat_interne_ids = array();
        
        foreach ($categorieInternes as $categorieInterne) {
           array_push($wp_cat_interne_ids, $categorieInterne->id);
        } 

       
        $catexterneInternes = CategorieexterneCategorieinterne::whereIn('categorieinterne_id', $wp_cat_interne_ids)->get();
        
 

        $wp_cat_externe_ids = array();
        $wp_cat['id_externe'] = array();
        $wp_cat['url_externe'] = array();
        $wp_cat['id_interne'] = array();
        $wp_cat['wp_id_interne'] = array();
        
        foreach ($catexterneInternes as $catexterneInterne) {

       
          // retirer "/" s'il existe en fin de l'url      
          $url = rtrim($catexterneInterne->categorieexterne->url, '/');

           array_push($wp_cat['id_externe'], $catexterneInterne->categorieexterne_id);
           array_push($wp_cat['url_externe'], $url);
           array_push($wp_cat['id_interne'], $catexterneInterne->categorieinterne_id);
           array_push($wp_cat['wp_id_interne'], $catexterneInterne->categorieinterne->wp_id);
        } 

        $wp_cat_externe_ids = array_unique($wp_cat_externe_ids);
      
        

        foreach ($siteexternes as $siteexterne) {
            
            $domaineExterne = $siteexterne->url;


            // on reccupère tous les ids des catégories sources wp 
// dd($domaineExterne);
            
            $resp = Http::get("$domaineExterne/wp-json/wp/v2/categories"
                            );

            $categoriesSources = json_decode($resp,true);
          
dd($categoriesSources);
            // si y'a un code d'erreur            
            if($categoriesSources == null || array_key_exists('code', $categoriesSources)){
                continue;
            }
           
            $idsSources['id_externe'] = array();
            $idsSources['url_externe'] = array();
            foreach ($categoriesSources as $categoriesSource) {
                $url = rtrim($categoriesSource['link'], '/');

                if(in_array( $url, $wp_cat['url_externe'])){

                    array_push( $idsSources['id_externe'], $categoriesSource['id']);
                    array_push( $idsSources['url_externe'], $url);

                }
            }
            
            // dd($categoriesSources);
            // dd($idsSources);
            
            $resp1 = Http::get("$domaineExterne/wp-json/wp/v2/posts",
                    [
                        'status' => 'publish',
                        'per_page' => $request->nb_article,
                        'before' => $request->date_deb."T00:00:00",
                        'after' => $request->date_fin."T00:00:00",
                    ]
            );

        // dd(date(DATE_ISO8601, strtotime('2021-12-30 23:21:46')));
            $articles = json_decode($resp1,true);

            // dd($articles);

            $nb_article = 0;

            foreach ($articles as $article) { 

                // on vérifie que les catégories de l'articles est dans notre tableau de catégorie source
                $idCategorieSource = $article['categories'];
        //  dd($idCategorieSource);
                
                $check = array_intersect($idCategorieSource,$idsSources['id_externe']);

                // On vérifie si on peut publier cet article
                if(sizeof($check) > 0 && $siteinterne->haveArticle($article['title']['rendered']) == false){

                    // On détermine la catégorie interne du siteinterne en passant par la catégorie externe
               

                    $key = array_search($idCategorieSource[0],  $idsSources['id_externe']); 
                    
                    $url_externe = $idsSources['url_externe'][$key];

                   
                    $key2 = array_search($url_externe, $wp_cat['url_externe']); 
                    $wp_id_interne = $wp_cat['wp_id_interne'][$key2];

                  
                        try{
                            
                            // TROUVER MAINTENANT LIMAGE DE LARTICLE  

                            $resp2 = Http::get("$domaineExterne/wp-json/wp/v2/media/".$article['featured_media']);
                            $image = json_decode($resp2,true);


                            if( isset($image['id']) ){
                            

                                   echo $article['title']['rendered'].$article['date']."--- $url_externe------ <br>";                        
                                
                                $domaine = $siteinterne->url;
            
                                $response = Http::post("$domaine/wp-json/jwt-auth/v1/token", [
                                    'username' => $siteinterne->login,
                                    'password' => $siteinterne->password,
                                ]);
                        
                                
                                $token = $response->json()['token'] ;
                                
                                $curl = curl_init();
                        
                                $data = file_get_contents($image['guid']['rendered']);

                        
                                
                        
                                curl_setopt_array($curl, array(
                                CURLOPT_URL => "$domaine/wp-json/wp/v2/media",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_HTTPHEADER => array(
                                    "authorization: Bearer $token",
                                    "cache-control: no-cache",
                                    "content-disposition: attachment; filename=".$article['slug'].".png",
                                    "content-type: image/png",
                                ),
                                CURLOPT_POSTFIELDS => $data,
                                CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 6.1; fr; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13",
                                ));
                        
                                $response = curl_exec($curl);
                                $err = curl_error($curl);
                        
                                curl_close($curl);
                        
                                if ($err) {
                                    echo "cURL Error #:" . $err;
                                } else {
                        
                                    $fileResponse = json_decode($response,true);
                                    if($fileResponse == null) dd($response);
                            // echo $fileResponse['id'] ."</br>";
            
                                    $resp = Http::withToken($token)
                                    ->post("$domaine/wp-json/wp/v2/posts",
                        
                                            [
                                            'title' => $article['title']['rendered'],
                                            'content' => $article['content']['rendered'],
                                            // 'categories' => $categorieinterne->wp_id,
                                            'categories' => $wp_id_interne,
                                            'date' => $article['date'],
                                            // 'slug' => 'this-best-article',
                                            'status' => 'publish',
                                            'featured_media' => $fileResponse == null ? null : $fileResponse['id'] // ID de l'image téléchargée
                                            ]
                                    );
                        
                                
                                    $resp = json_decode($resp,true);
            

                                    #########"" CREER TABLE ARTICLE_SITEINTERNE avec  siteinterne_id postwp_id, url_source
                                    if($resp != null){
                                        $nb_article ++;
                                        ArticleCategorieinterne::create([
                                            'siteinterne_id' => $siteinterne->id,
                                            'titre_article' => $article['title']['rendered'],
                                            'postwp_id' => $resp['id'],
                                            'est_publie_auto' => true,
                                            'est_alimente' => true,                                            

                                        ]);
                                        
                                    }
                                    
                                }
                            }
                            else {
                                echo "<br> #### ". $article['title']['rendered'].$article['date']."<br>"; 
                            }
                        } catch (\Exception $th) {
                            echo "Erreur : $th";
                            continue;
                            dd($image);
                            // return redirect()->back()->with('nok','Article Non Publié');
                        
                        }
                    // }
        
                // }
        
               }

            }
            echo "<br> **** <strong><h1> $nb_article articles ajoutés </h1> </strong>***** <br>"; 

        }

        



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
        $this->authorize('permission', 'modifier-site');

            
       
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
        $site->pay_id = $request->pays;
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
        $this->authorize('permission', 'supprimer-site');

    }
}
