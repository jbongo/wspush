<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Categorieexterne;
use App\Models\Categoriearticle;
use App\Models\Siteinterne;
use App\Models\Categorieinterne;
use App\Models\Langue;
use App\Models\Image;
use App\Models\Pays;
use App\Models\ArticleCategorieinterne;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::where([['est_archive', false],['est_scrappe', false]])->orderBy('id','desc')->latest()->take(100)->get();
  
        // dd($articles);
        
        return view('article.index', compact('articles'));  
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexExterne()
    {
        $articles = Article::where([['est_archive', false],['est_scrappe', true]])->orderBy('id','desc')->latest()->take(100)->get();  
        
        return view('article.index_externe', compact('articles'));  
    }


   



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categoriearticle::where([['est_archive',false]])->get();
        $langues = Langue::where([['est_archive',false]])->get();

        return view('article.add',compact('categories', 'langues'));  
        
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
            "titre"=> "required|unique:articles|string",
            "contenu"=> "required|string",
            "categorie_id"=> "required|string",
            "langue_id"=> "required|string",

        ]);
        // dd($request->all());


       $article =  Article::create([           
            "titre"=> $request->titre ,
            "client_id"=> Auth::user()->client_id ,
            "user_id"=> Auth::user()->id,
            "description"=> $request->contenu ,
            "categoriearticle_id"=> $request->categorie_id ,
            "langue_id"=> $request->langue_id,
            "est_scrappe"=> false
        ]);


        // Récupérer les fichiers d'images
        $images = $request->file('images');

        // Parcourir chaque image et les enregistrer
        foreach($images as $image) {

       
            $filename = $image->getClientOriginalName(); // Récupérer le nom du fichier
            $extension = $image->getClientOriginalExtension(); // Récupérer l'extension du fichier
            $slug = $this->to_slug($article->titre);
            $picture = $slug."-".rand(1,1000).".".$extension; // Renommer le fichier avec une date et l'ancien nom de fichier
            $destinationPath = public_path('/images-articles'); // Définir le dossier de destination des images
            $image->move($destinationPath, $picture); // Déplacer le fichier dans le dossier de destination

            Image::create([
                "article_id" => $article->id,
                "url" => $destinationPath."/".$picture,
                "filename" => $picture,
            
            ]);
        }

       return redirect()->route('article.edit_no_scrap',  Crypt::encrypt($article->id));
    }

    /**
     * Modifier un article
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $article_id)
    {

        $article = Article::where('id', Crypt::decrypt($article_id))->first();

        if($request->titre != $article->titre){
            $request->validate([
                "titre"=> "required|unique:articles|string",
                "contenu"=> "required|string",
                "categorie_id"=> "required|string",
                "langue_id"=> "required|string",
    
            ]);
        }else{
            $request->validate([
                "contenu"=> "required|string",
                "categorie_id"=> "required|string",
                "langue_id"=> "required|string",
    
            ]);
        }
       


        $article->categoriearticle_id =  $request->categorie_id;
        $article->langue_id =  $request->langue_id;
        $article->titre =  $request->titre;
        $article->description =  $request->contenu;
        
        $article->update();




        // Récupérer les fichiers d'images
        $images = $request->file('images');

        if($images != null){

            // Parcourir chaque image et les enregistrer
            foreach($images as $image) {

        
                $filename = $image->getClientOriginalName(); // Récupérer le nom du fichier
                $extension = $image->getClientOriginalExtension(); // Récupérer l'extension du fichier
                $slug = $this->to_slug($article->titre);
                $picture = $slug."-".rand(1,1000).".".$extension; // Renommer le fichier avec une date et l'ancien nom de fichier
                $destinationPath = public_path('/images-articles'); // Définir le dossier de destination des images
                $image->move($destinationPath, $picture); // Déplacer le fichier dans le dossier de destination

                Image::create([
                    "article_id" => $article->id,
                    "url" => $destinationPath."/".$picture,
                    "filename" => $picture,
                
                ]);
            }

        }
  
        return redirect()->back()->with('ok','Article modifié');

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
    public function edit($article_id)
    {
        $article = Article::where('id', Crypt::decrypt($article_id))->first();
        $categories = Categorieexterne::where([['est_archive',false], ['siteexterne_id', $article->siteexterne_id]])->get();
        return view('article.edit', compact('article', 'categories'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function editNoScrap($article_id)
   {
        $article = Article::where('id', Crypt::decrypt($article_id))->first();
     
        $categories = Categoriearticle::where([['est_archive',false]])->get();
        $langues = Langue::where([['est_archive',false]])->get();

        $allSiteinternes = Siteinterne::where([["langue_id", $article->langue_id], ['est_archive', false], ['client_id', Auth::user()->client_id]])->get();

        $siteSelected = array();
        foreach ($article->categorieinternes as $cat ) {
            $siteSelected[] = strval($cat->siteinterne_id);
        }

        $allVal = array();
        $pays_ids = array();

        foreach ($allSiteinternes as $all ) {
            $allVal[] = strval($all->id);
            $pays_ids[] = strval($all->pay_id);
        }


   
        $pays = Pays::whereIn('id', $pays_ids)->get();

        
        $siteSelected = json_encode($siteSelected);
        $allVal = json_encode($allVal);
        // dd($siteSelected);
        return view('article.edit_no_scrap',compact('categories', 'langues', 'article', 'pays','allSiteinternes', 'siteSelected','allVal'));  
   }

   
    ///////// ########## GESTION DES images D'UN article 
    
     
    
        // sauvegarde des images de l'article 
        // public function savePhoto(Request $request, $article_id){
        
        //     $images = $request->file('file');
             
            
            
        //     if (!is_array($images)) {
        //         $images = [$images];
        //     }
            
           
            
           
        //         for ($i = 0; $i < count($images); $i++) {
        //             $photo = $images[$i];

                  
                    
        //             $filename = $image->getClientOriginalName(); // Récupérer le nom du fichier
        //             $extension = $image->getClientOriginalExtension(); // Récupérer l'extension du fichier
        //             $slug = $this->to_slug($article->titre);
        //             $picture = $slug."-".rand(1,1000).".".$extension; // Renommer le fichier avec une date et l'ancien nom de fichier
        //             $destinationPath = public_path('/images-articles'); // Définir le dossier de destination des images
        //             $image->move($destinationPath, $picture); // Déplacer le fichier dans le dossier de destination

        //             // $img = Image::make($photo);
                    
        //             Image::create([
        //                 "article_id" => $article_id,                      
        //                 "filename"=> $picture,
        //                 "filename"=> $picture,
                   
    
        //             ]);
        //                  //dd($images);
        //         }
        //     return Response::json([
        //         'message' => 'Image sauvegardée'
        //     ], 200);
        // }
    
        
        
    /**
     * 
     * Suppression d'une photo 
     * @return \Illuminate\Http\Response
    */
        public function destroyImage(Request $request)
        {
     
            $uploaded_image = Image::where('id', $request->image_id)->first();
     
            if (empty($uploaded_image)) {
                return Response::json(['message' => 'desolé cette photo n\'existe pas'], 400);
            }
            
            $destinationPath = public_path('/images-articles');

            $file_path =  $destinationPath . '/' . $uploaded_image->filename;
          
     
            if (file_exists($file_path)) {
                unlink($file_path);
            }
     
        
     
            if (!empty($uploaded_image)) {
                $uploaded_image->delete();
            }
     
            return Response::json(['message' => 'Fiichier supprimé'], 200);
        }
    
        // public function deletePhoto($id){
    
        //     $photo = articlephoto::where('id', $id)->first();
        //     $photo->delete();
        //     return back()->with('ok', __("Photo supprimée"));
        // }


    
    /** Fonction de téléchargement des images de l'article document
    * @param  App\Models\Image
    * @return \Illuminate\Http\Response
    **/ 
    public function getImage( $image_id){
    
        $image = Image::where('id',Crypt::decrypt($image_id))->firstorfail();
    
        $path = public_path('images-articles\\'.$image->filename) ;
        return response()->download($path);
    }
    
    
    

    /**
     * Publier un article interne
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publierArticleInterne(Request $request, $article_id)
    {
        $article = Article::where('id', Crypt::decrypt($article_id))->first();
        

        $categorieinternes = Categorieinterne::where('categoriearticle_id', $article->categoriearticle_id)->whereIn('siteinterne_id', $request->siteinternes)->get();
      
        if(sizeof($categorieinternes) == 0) return "nok";
        foreach ($categorieinternes as $categorieinterne) {
            
            try {
                    
                $siteinterne = $categorieinterne->siteinterne;
                $domaine = $siteinterne->url;

                $response = Http::post("$domaine/wp-json/jwt-auth/v1/token", [
                    'username' => $siteinterne->login,
                    'password' => $siteinterne->password,
                ]);
        
                
               
                $token = $response->json()['token'] ;

                // On réccupère une image de façon aléatoire  parmis les images des articles
                $images = Image::where('article_id', $article->id)->get();
                $nbImages = sizeof($images);

                $id =  rand(0, $nbImages-1);
                
                $curl = curl_init();
        // return $images[$id];
                $data = file_get_contents($images[$id]->filename);

            
                $filename = $this->to_slug($article->titre);

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
                    "content-disposition: attachment; filename=$filename.png",
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
          
                    // On vérifie si l'article est déjà publié sur le site

                    if($categorieinterne->haveArticle($article->id)){
                     
                        $articleCategorieinterne = ArticleCategorieinterne::where([['article_id', $article->id], ['categorieinterne_id', $categorieinterne->id]])->first();
   
                        $resp = Http::withToken($token)
                        ->post("$domaine/wp-json/wp/v2/posts/$articleCategorieinterne->postwp_id",
            
                                [
                                'title' => $article->titre,
                                'content' => $article->description,
                                'categories' => $categorieinterne->wp_id,
                                // 'date' => '2023-01-22T15:04:52',
                                // 'slug' => 'this-best-article',
                                'status' => 'publish',
                                'featured_media' => $fileResponse == null ? null : $fileResponse['id'] // ID de l'image téléchargée
                                ]
                        );

                        // return $resp;
                        
                    }else{
                        $resp = Http::withToken($token)
                        ->post("$domaine/wp-json/wp/v2/posts",
            
                                [
                                'title' => $article->titre,
                                'content' => $article->description,
                                'categories' => $categorieinterne->wp_id,
                                // 'date' => '2023-01-22T15:04:52',
                                // 'slug' => 'this-best-article',
                                'status' => 'publish',
                                'featured_media' => $fileResponse == null ? null : $fileResponse['id'] // ID de l'image téléchargée
                                ]
                        );
            
                    
                        $resp = json_decode($resp,true);

                        if($resp != null){

                            $article->categorieinternes()->attach($categorieinterne->id, 
                                ['siteinterne_id' => $siteinterne->id,
                                'postwp_id' => $resp['id'],
                                'est_publie_auto' => false] 
                            );
                        }


                    }

                    
                    
                }
            } catch (\Exception $th) {
                echo "Erreur : $th";
                return redirect()->back()->with('nok','Article Non Publié');
            
            }

        }

        if($request->publier_sur != "allsite"){

            $article->est_publie_tous_site = false;
        }else{

            $article->est_publie_tous_site = true;

        }

        $article->est_publie = true;

        $article->update();
        

        return "article publié"; 
        
        return redirect()->back()->with('ok','Article Publié');


        return view('article.edit', compact('article', 'categories'));
    }
    

    /**
     * Publier un article externe
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publierArticleExterne($article_id)
    {
        $article = Article::where('id', Crypt::decrypt($article_id))->first();
        
        $categorieexterne = Categorieexterne::where([['est_archive',false], ['id', $article->categorieexterne_id]])->first();

        // on réccupère toutes les catégories internes liées à la catégorie externe de l'article afin de retrouver tous sites où il faut diffuser

        $categorieinternes = $categorieexterne->categorieinternes;
        

        foreach ($categorieinternes as $categorieinterne) {
            
            $siteinterne = $categorieinterne->siteinterne;
            


            if($siteinterne->est_archive == false && $categorieinterne->haveArticle($article->id) == false ){

                try {
                    
            
                    $domaine = $siteinterne->url;

                    $response = Http::post("$domaine/wp-json/jwt-auth/v1/token", [
                        'username' => $siteinterne->login,
                        'password' => $siteinterne->password,
                    ]);
            
                    
                   
                    $token = $response->json()['token'] ;
                    
                    $curl = curl_init();
            
                    $data = file_get_contents($article->image);
                    $filename = $this->to_slug($article->titre);

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
                        "content-disposition: attachment; filename=$filename.png",
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
                                'title' => $article->titre,
                                'content' => $article->description,
                                'categories' => $categorieinterne->wp_id,
                                // 'date' => '2023-01-22T15:04:52',
                                // 'slug' => 'this-best-article',
                                'status' => 'publish',
                                'featured_media' => $fileResponse == null ? null : $fileResponse['id'] // ID de l'image téléchargée
                                ]
                        );
            
                    
                        $resp = json_decode($resp,true);

                        if($resp != null){

                            $article->categorieinternes()->attach($categorieinterne->id, 
                                ['siteinterne_id' => $siteinterne->id,
                                'postwp_id' => $resp['id'],
                                'est_publie_auto' => false] 
                            );
                        }
                        
                    }
                } catch (\Exception $th) {
                    echo "Erreur : $th";
                    return redirect()->back()->with('nok','Article Non Publié');
                
                }
            }

        }

       

     
        return redirect()->back()->with('ok','Article Publié');


        return view('article.edit', compact('article', 'categories'));
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

    
    /**
     * Convertir une chaine de caractère en slug.
     *
     * @param  String $slug
     * @return String 
     */
    public function to_slug($string)
    {
        
        $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '/' => '-', ' ' => '-','?' => '','-' => '','  ' => '-','.'=>'',"'"=>'','('=>'',')'=>'',','=>'','!'=>''
        );
    
        // -- Remove duplicated spaces
        $string = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);
    
        // -- Returns the slug
        return strtolower(strtr($string, $table));
        
    }
    
}
