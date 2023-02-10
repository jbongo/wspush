<?php





ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);





$servername = "sql";

$username = "Cedric";

$password = "wRG25OjeIJev0LeY";

$dbname = "vw-bagnols-sur-ceze-2022";



// Connexion à la base de donnée





try{

	$db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);	

	// echo "YESSSSSSSS";

}catch (Exception $e){

    die('Erreur : ' . $e->getMessage());

}











// Suppression de toutes les voitures dans la base de données 



    // Etape 1 suppression de toute les ligne de la table WP_POSTMETA où la propriété bee2link = true

    

    

    $deletePostmetaStatement = $db->prepare('DELETE FROM wp_postmeta WHERE bee2link = true');

    $deletePostmetaStatement->execute();

    

    // Etape 2 suppression de toutes les lignes de la table WP_POST où la propriété bee2link = true

    

    $deletePostStatement = $db->prepare('DELETE FROM wp_posts  WHERE bee2link = true');

    $deletePostStatement->execute();



   // Etape 3 suppression de toutes les lignes de la table wp_term_relationships où la propriété bee2link = true

    

   $deleteTermStatement = $db->prepare('DELETE FROM wp_term_relationships  WHERE bee2link = true');

   $deleteTermStatement->execute();

    





// die('eee');

    

// Dézipage et lecture du fichier XML export

    

    //dézipage fichier

    

    $zip = new ZipArchive;

    if ($zip->open('ftp/paulus.xml.zip') === TRUE) {

        $zip->extractTo('ftp/');

        $zip->close();

        echo '<br>Unzip ok';

    } else {

        echo '<br>echec unzip';

    }

    

    

    // Lecture du fichier export

    if (!file_exists('ftp/export.xml')) {

        die(' Le fichier export.xml n\'existe pas.');

    }

    $xml = simplexml_load_file('ftp/export.xml');

    

    

    // echo "<pre>";

    

    // print_r($xml);

    

    

// Créeation des voitures dans la table WP_POST puis creéation des caractéristiques de la voiture dans la table WP_POSTMETA

    



    foreach ($xml->children() as $voiture) {

  

     

     

        // echo "<pre>";    

        // echo(sizeof($xml->children()));

        

        // die('cc');

     

     

    // Etape 1 création de la voiture (titre, description) dans la table WP_POST 

        



    $sqlQuery1 = 'INSERT INTO wp_posts(post_author, post_date, post_date_gmt, post_content, post_title, post_status, comment_status, ping_status, post_name, post_type, bee2link) 

                    VALUES (:post_author, :post_date, :post_date_gmt, :post_content, :post_title, :post_status, :comment_status, :ping_status, :post_name, :post_type, :bee2link)';

    $insertPost = $db->prepare($sqlQuery1);

    

    // Exécution ! La recette est maintenant en base de données

    

    

    

    //DESCRIPTION / EQUIPEMENTS

    $post_content = "";

    

	// $post_content = '<table cellpadding="0" cellspacing="0" width="100%">';

	// $post_content .= '<tr><th colspan="2">' . strval($voiture->VEHICULE->TYPE) . ' ' . strval($voiture->VEHICULE->CARROSSERIE) . ' ' . strval($voiture->VEHICULE->FINITION) . ', ' . strval($voiture->VEHICULE->NB_PLACE) . ' places</th></tr>';

	// $post_content .= '<tr><th>Transmission:</th><td>' . strval($voiture->VEHICULE->MOTRICITE) . ', ' . strval($voiture->VEHICULE->TRANSMISSION) . ' à ' . strval($voiture->VEHICULE->NB_VITESSE) . ' vitesses</td></tr>';

	// $post_content .= '<tr><th>Couleur:</th><td>Extérieur ' . strval($voiture->VEHICULE->COULEUR) . ', intérieur ' . strval($voiture->VEHICULE->INTERIEUR) . '</td></tr>';

	// $post_content .= '<tr><th>Moteur:</th><td>';

	// $post_content .= strval($voiture->VEHICULE->NB_CYLINDRE) . ' cylindres en ' . strval($voiture->VEHICULE->CYLINDREE);

	// $post_content .= '<br /><b>Puissance:</b> ' . strval($voiture->VEHICULE->CV_DIN) . ' CV DIN (' . strval($voiture->VEHICULE->CV_F) . ' CV fiscaux), couple ' . strval($voiture->VEHICULE->COUPLE) . '</td></tr>';

	// $post_content .= '<tr><th>Échappement:</th><td>' . strval($voiture->VEHICULE->ECHAPPEMENT) . ', émission de CO2:' . strval($voiture->VEHICULE->CO2) . '</td></tr>';

	// $post_content .= '<tr><th>1ere mise en circulation:</th><td>' . strval($voiture->VEHICULE->DATE_IMMAT_1) . '</td></tr>';

	// $post_content .= '<tr><th>Dimensions:</th><td>' . strval($voiture->VEHICULE->EMPATTEMENT) . ', volume (m3): ' . strval($voiture->VEHICULE->CAPACITE_CM3) . '</td></tr>';

	// $post_content .= '<tr><th>Garantie:</th><td>' . strval($voiture->VEHICULE->GARANTIE) . ' ' . strval($voiture->VEHICULE->GARANTIE_DUREE) . '</td></tr>';

    

 

    $wpPost =  $insertPost->execute([

        'post_author' =>  1,

        'post_date' =>  date('Y-m-d H:i:s'),

        'post_date_gmt' =>   gmdate('Y-m-d H:i:s'),

        'post_content' =>  $post_content,

        'post_title' =>  $voiture->VEHICULE->MARQUE."-".$voiture->VEHICULE->MODELE_2,

        'post_status' =>  "publish",

        'comment_status' =>  "closed",

        'ping_status' =>  "closed",

        'post_name' => to_slug($voiture->VEHICULE->MARQUE."-".$voiture->VEHICULE->MODELE_2."-".$voiture->attributes()->id),

        'post_type' =>  "auto-listing",

        'bee2link' => 1,

    ]);

        

    // Etape 2 Création des caractéristiques de la voiture dans WP_POSTMETA avec l'id de WP_POST  

        

        

    $postId = $db->lastInsertId();

    

    

    

    //#### Insert prix

    $sqlQuery2 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery2);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_price",

        'meta_value' => $voiture->VEHICULE->PRIX,

        'bee2link' => 1,

    ]);

    

    

    

    // Insert kilométrage

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_odometer",

        'meta_value' => $voiture->VEHICULE->KILOMETRAGE,

        'bee2link' => 1,

    ]);

    
   // Insert date de premi�re mise en circulation
   $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';
   $insertPost = $db->prepare($sqlQuery3);
   
   $insertPost->execute([
       'post_id' => $postId,
       'meta_key' => "_al_listing_date_mec",
       'meta_value' => $voiture->VEHICULE->DATE_MEC,
       'bee2link' => 1,
   ]);
    

    // Insert Année du modèle

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_model_year",

        'meta_value' => $voiture->VEHICULE->ANNEE_MODELE,

        'bee2link' => 1,

    ]);

        

    

    // Insert marque

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_make_display",

        'meta_value' => $voiture->VEHICULE->MARQUE,

        'bee2link' => 1,

    ]);

    

    // Insert Modèle

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_model_name",

        'meta_value' => $voiture->VEHICULE->GROUPE_MODELE_1,

        'bee2link' => 1,

    ]);

    

    // Insert Nombre de places

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

      

    $insertPost->execute([

      'post_id' => $postId,

      'meta_key' => "_al_listing_model_seats",

      'meta_value' => $voiture->VEHICULE->NB_PLACE,

      'bee2link' => 1,

    ]);

    

    

    // Insert nombre de porte

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_model_doors",

        'meta_value' => $voiture->VEHICULE->NB_PORTE,

        'bee2link' => 1,

    ]);



    

    // Insert transmission

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    $transmission = "";
    if(strpos($voiture->VEHICULE->TRANSMISSION,"manuelle") !== false) { $transmission = $voiture->VEHICULE->TRANSMISSION; } else{ $transmission ="Automatique" ;}

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_model_transmission_type",
        'meta_value' => $transmission ,

        'bee2link' => 1,

    ]);

  

    

    // Insert Date immatriculation

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_date_immatriculation",

        'meta_value' => $voiture->VEHICULE->DATE_IMMAT_1,

        'bee2link' => 1,

    ]);

    

    // Insert  Consommation

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_model_vehicle",

        'meta_value' => "Mixte: ".$voiture->VEHICULE->CONSOMMATION_MIXTE."L/100km - Urbaine: ". $voiture->VEHICULE->CONSOMMATION_URBAIN."L/100km - Extra urbaine:  ". $voiture->VEHICULE->CONSOMMATION_EXTRA_URBAIN."L/100km",

        'bee2link' => 1,

    ]);

    	



  // Insert  carburant

  $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

  $insertPost = $db->prepare($sqlQuery3);

  

  $insertPost->execute([

      'post_id' => $postId,

      'meta_key' => "_al_listing_fuel_economy",

      'meta_value' => $voiture->VEHICULE->ENERGIE,

      'bee2link' => 1,

  ]);

          

    

  // Insert  couleur de la voiture

  $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

  $insertPost = $db->prepare($sqlQuery3);

  

  $insertPost->execute([

      'post_id' => $postId,

      'meta_key' => "_al_listing_color",

      'meta_value' => $voiture->VEHICULE->COULEUR,

      'bee2link' => 1,

  ]);

       

    

  // Insert  nombre de vitesse

  $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

  $insertPost = $db->prepare($sqlQuery3);

  

  $insertPost->execute([

      'post_id' => $postId,

      'meta_key' => "_al_listing_nb_vitesse",

      'meta_value' => $voiture->VEHICULE->NB_VITESSE,

      'bee2link' => 1,

  ]);

  

    // Insert  critair

    $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

    $insertPost = $db->prepare($sqlQuery3);

    

    $insertPost->execute([

        'post_id' => $postId,

        'meta_key' => "_al_listing_critair",

        'meta_value' => $voiture->VEHICULE->CRITAIR,

        'bee2link' => 1,

    ]);

       

    

    

    // Spécifications  ==> //DESCRIPTION / EQUIPEMENTS

    

    

    	$description = '<table cellpadding="0" cellspacing="0" width="100%">';

    	// $description .= '<tr><th colspan="2">' . strval($voiture->VEHICULE->TYPE) . ' ' . strval($voiture->VEHICULE->CARROSSERIE) . ' ' . strval($voiture->VEHICULE->FINITION) . ', ' . strval($voiture->VEHICULE->NB_PLACE) . ' places</th></tr>';

    	// $description .= '<tr><th>Transmission:</th><td>' . strval($voiture->VEHICULE->MOTRICITE) . ', ' . strval($voiture->VEHICULE->TRANSMISSION) . ' à ' . strval($voiture->VEHICULE->NB_VITESSE) . ' vitesses</td></tr>';

    	// $description .= '<tr><th>Couleur:</th><td>Extérieur ' . strval($voiture->VEHICULE->COULEUR) . ', intérieur ' . strval($voiture->VEHICULE->INTERIEUR) . '</td></tr>';

    	$description .= '<tr><th>Moteur:</th><td>';

    	$description .= strval($voiture->VEHICULE->NB_CYLINDRE) . ' cylindres en ' . strval($voiture->VEHICULE->CYLINDREE);

    	$description .= '<br /><b>Puissance:</b> ' . strval($voiture->VEHICULE->CV_DIN) . ' CV DIN (' . strval($voiture->VEHICULE->CV_F) . ' CV fiscaux), couple ' . strval($voiture->VEHICULE->COUPLE) . '</td></tr>';

    	$description .= '<tr><th>Échappement:</th><td>' . strval($voiture->VEHICULE->ECHAPPEMENT) . ', émission de CO2:' . strval($voiture->VEHICULE->CO2) . '</td></tr>';

    	// $description .= '<tr><th>1ere mise en circulation:</th><td>' . strval($voiture->VEHICULE->DATE_IMMAT_1) . '</td></tr>';

    	$description .= '<tr><th>Dimensions:</th><td>' . strval($voiture->VEHICULE->EMPATTEMENT) . ', volume (m3): ' . strval($voiture->VEHICULE->CAPACITE_CM3) . '</td></tr>';

    	$description .= '<tr><th>Garantie:</th><td>' . strval($voiture->VEHICULE->GARANTIE) . ' ' . strval($voiture->VEHICULE->GARANTIE_DUREE) . '</td></tr>';

    

    if ($voiture->VEHICULE->EQUIPEMENTS->EQUIPEMENT->children()->count() > 0) {

		$description .= '<tr><th><br /><br />Équipements:</th><td><br /><br />';

		$equip = array();
		foreach($voiture->VEHICULE->EQUIPEMENTS->EQUIPEMENT as $value) {
			$equip[] = "- ".strval($value->LIBELLE)."</br>";
		}

		$equipments = implode(" ",$equip);

		$description .= strval($equipments);
		
		$description .= '</td></tr>';
	}

    

    

    

   // Insert  description

   $sqlQuery3 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

   $insertPost = $db->prepare($sqlQuery3);

   

   $insertPost->execute([

       'post_id' => $postId,

       'meta_key' => "_al_listing_description",

       'meta_value' => $description,

       'bee2link' => 1,

   ]);

    

    

    // echo "$description";

    

    

    // die("");

    

    

   //##########  Insert IMAGES ###########

   

   

   foreach ($voiture->VEHICULE->PHOTOS->PHOTO as $photo) {

   

        

    //    Etape 1 Ajout de l'image wp_post

       $sqlQuery4 = 'INSERT INTO wp_posts(post_author, post_date, post_date_gmt, post_content, post_title, post_status, comment_status, ping_status, post_name, post_type, guid, post_mime_type, post_parent, bee2link) 

       VALUES (:post_author, :post_date, :post_date_gmt, :post_content, :post_title, :post_status, :comment_status, :ping_status, :post_name, :post_type, :guid, :post_mime_type, :post_parent, :bee2link)';

        $insertPost = $db->prepare($sqlQuery4);

        

        $tt = $insertPost->execute([

            'post_author' =>  1,

            'post_date' =>  date('Y-m-d H:i:s'),

            'post_date_gmt' =>   gmdate('Y-m-d H:i:s'),

            'post_content' =>  $post_content,

            'post_title' =>  $voiture->VEHICULE->MARQUE."-".$voiture->VEHICULE->MODELE_2,

            'post_status' =>  "publish",

            'comment_status' =>  "closed",

            'ping_status' =>  "closed",

            'post_name' => to_slug($voiture->VEHICULE->MARQUE."-".$voiture->VEHICULE->MODELE_2."-".$voiture->attributes()->id),

            'post_type' =>  "attachment",

            'guid' =>  $photo,

            'post_mime_type' =>  "image/jpeg",

            'post_parent' =>   $postId,

            'bee2link' => 1,

            

           

        ]);

        



        

        

        

        $photoWpPostId = $db->lastInsertId();

        

        

        $sqlQuery4 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

        $insertPost = $db->prepare($sqlQuery4);

        

        $insertPost->execute([

            'post_id' => $photoWpPostId,

            'meta_key' => "_wp_attached_file",

            'meta_value' => $photo,

            'bee2link' => 1,

        ]);

        

        //    Etape 1 Ajout de l'image wp_postmeta

        

        $photoId = $db->lastInsertId();

        

        

        $sqlQuery5 = 'INSERT INTO wp_postmeta(post_id, meta_key, meta_value, bee2link ) VALUES (:post_id, :meta_key, :meta_value, :bee2link )';

        $insertPost = $db->prepare($sqlQuery5);

        

        $insertPost->execute([

           'post_id' => $postId,

           'meta_key' => "_al_listing_image_gallery",

           'meta_value' => $photoWpPostId,

           'bee2link' => 1,

        ]);

   }

   

   

   //########## FIN Insert IMAGES ###########

   



// ###### Ajout des catégorie (Vehicule direction ou occasion)

            

        $sqlQuery6 = 'INSERT INTO wp_term_relationships(object_id, term_taxonomy_id, term_order, bee2link ) VALUES (:object_id, :term_taxonomy_id, :term_order, :bee2link )';

        $insertPost = $db->prepare($sqlQuery6);

        

        // vehicule neuf = 0, occasion = 1, démonstration ou  direction = 2

        

        $insertPost->execute([

           'object_id' => $postId,

           'term_taxonomy_id' => $voiture->attributes()->destination == 1 ? 19 : 18 ,

           'term_order' => 0,

           'bee2link' => 1,

        ]);      

    

    }

    

    







    // $recipesStatement = $db->prepare('SELECT * FROM wp_posts WHERE post_type = "auto-listing"');

    // $recipesStatement->execute();

    // $recipes = $recipesStatement->fetchAll();

    // echo "<pre>";

    // print_r($recipes);









     //Convertir une chaine de caractère en slug.



    function to_slug($string)

    {

        

        $table = array(

            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',

            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',

            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',

            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',

            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',

            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',

            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',

            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', '/' => '-','!'=>'', ' ' => '-','?' => '','  ' => '-','.'=>'',"'"=>'','('=>'',')'=>'',','=>''

        );

    

        // -- suppression des espaces

        $string = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $string);

        return strtolower(strtr($string, $table));

        

    }




die('');



