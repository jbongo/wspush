<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Models\Siteexterne;
use App\Models\Article;

class ScrapController extends Controller
{
    
    
    public function scrap(){
        set_time_limit(0);

        $client = new Client();
         

        $sites = Siteexterne::where('est_archive', false)->get();



        foreach ($sites as $site) {
           
            $categories = $site->categorieexternes;


            foreach ($categories as $categorie) {
               
                $url = $categorie->url;
                $links_selector = $site->selecteur_lien;        
                $title_selector = $site->selecteur_titre; 
                $content_selector = $site->selecteur_contenu; 
                $image_selector = $site->selecteur_image; 
                $image_affiche_css = $site->image_affiche_css;
                

                try {                  
                
                    $crawler = $client->request('GET', $url); 

                    // On réccupère tous les liens de la page catégorie du site
                    $liens = $crawler->filter($links_selector)
                    ->each(function($node){                 
                        $link = $node->link();                
                    
                        return $link;            
                    });

                } catch (\Exception $th) {
                   
                }
             
        
                // On réccupère les articles sur chaque lien
                $data = [];
                
                foreach ($liens as $lien) {
                    

                    try {                       
                   
                        $crawler = $client->click($lien);
            
                        $titre = $crawler->filter($title_selector)->text();        
                        $contenu = $crawler->filter($content_selector)->html();  
                        
                        if($image_affiche_css == true){
                            // Sélectionne la première élément avec un fond d'image
                            $element = $crawler->filter($image_selector);               

                            // Extrait l'URL de l'image à partir de la valeur de l'attribut style
                            preg_match('/url\((.*?)\)/', $element->attr('style'), $matches);
                        

                            $imageUrl = trim($matches[1], '"\'');

                        }else{
                            $imageUrl = $crawler->filter($image_selector)->attr('src'); 
                        }

                        // Si l'url de l'image n'est pas en lien absolue, ajouter l'url du site
                       
                        if(!filter_var($imageUrl, FILTER_VALIDATE_URL))
                        {     

                            // retirer "/" s'il existe en début de l'url
                            $imageUrl = ltrim($imageUrl, '/');

                            // retirer "/" s'il existe en fin de l'url
                            $siteUrl = rtrim($site->url, '/');
                            $imageUrl = $siteUrl.'/'.$imageUrl;

                        }
                        
                                                
                        $checkArticle = Article::where('url', $lien->getUri())->first();
                        
                        if($checkArticle == null){
                        
                            $article = Article::create([
                                'categorieexterne_id' => $categorie->id,
                                'siteexterne_id' => $site->id,                      
                                'titre' => $titre,
                                'description' => $contenu,
                                'image' => $imageUrl,
                                'url' => $lien->getUri(),
        
                            ]);
                        }
                    
                    } catch (\Exception $th) {
                       
                    }
        
                }



            }

        }




             

        // Sélectionne la première élément avec un fond d'image
        // $element = $crawler->filter('[style*="background-image"].post-img');
   

        // Extrait l'URL de l'image à partir de la valeur de l'attribut style
        // preg_match('/url\((.*?)\)/', $element->attr('style'), $matches);
        // $imageUrl = trim($matches[1], '"\'');

// dd($imageUrl);


       

        
        dd("terminé");
        echo(json_encode($data));


        $data = $crawler->filter('.col-sm-6.col-xxl-4.post-col')        
        ->each(function($node){
            
            // $crawler = $client->click($link);

            // $titre = $node->text()."\n";
            $titre = $node->filter('header > h2')->text();
           
            echo $titre ."<br>";
        
            return array( "Titre" => $titre, "lien" => $lien);
            // return array( "Titre" => $tire, "pourcentage_encour" => str_replace("%", "", $pourcentage_encour), "valeur_ouverture" => $valeur_ouverture, "valeur_fermeture_veille" => $valeur_fermeture_veille, "valeur_haute" => $valeur_haute, "valeur_basse" => $valeur_basse);
            
        });

        // $data = $data[0];

        dd($data);
    }
}
