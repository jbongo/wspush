<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Categorieexterne;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::where('est_archive', false)->orderBy('id','asc')->get();
  
        // dd($articles);
        
        return view('article.index', compact('articles'));  
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
        //
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
     * Publier un article
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publier($article_id)
    {
        $article = Article::where('id', Crypt::decrypt($article_id))->first();
        
        $categorieexterne = Categorieexterne::where([['est_archive',false], ['id', $article->categorieexterne_id]])->first();

        // on réccupère toutes les catégories internes liées à la catégorie externe de l'article afin de retrouver tous sites où il faut diffuser

        $categorieinternes = $categorieexterne->categorieinternes;
        

        foreach ($categorieinternes as $categorieinterne) {
            
            $siteinterne = $categorieinterne->siteinterne;
            


            if($siteinterne->est_archive == false && $categorieinterne->haveArticle($article->id) == false ){

                $domaine = $siteinterne->url;

                $response = Http::post("$domaine/wp-json/jwt-auth/v1/token", [
                    'username' => $siteinterne->login,
                    'password' => $siteinterne->password,
                ]);
        
                
                $token = $response->json()['token'] ;
                
                $curl = curl_init();
        
                $data = file_get_contents($article->image);
        
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
                    "content-disposition: attachment; filename=test.png",
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
            }

        }

       

     
        return redirect()->back()->with('ok','Article Publié');


        return view('article.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $article_id)
    {

        $article = Article::where('id', Crypt::decrypt($article_id))->first();

        $article->categorieexterne_id =  $request->categorie_id;
        $article->titre =  $request->titre;
        $article->description =  $request->contenu;
        
        // $article->image =  $request->imageUrl;
        

        $article->update();

        return redirect()->back()->with('ok','Article modifié');

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
