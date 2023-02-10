<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TestController extends Controller
{
    public function index(){

        $url = "assets\images\bg-auth.jpg";
        $path_parts = pathinfo($url);

        $newPath = $path_parts['dirname'] . '/tmp-files/';
        if(!is_dir ($newPath)){
            mkdir($newPath, 0777);
        }
        
        $newUrl = $newPath . $path_parts['basename'];
        copy($url, $newUrl);
        $imgInfo = getimagesize($newUrl);
        dd($imgInfo);
  
        $file = new UploadedFile(
            $newUrl,
            $path_parts['basename'],
            $imgInfo['mime'],
            filesize($url),
            true,
            TRUE
        );



        // $uploadedFile = new UploadedFile("assets\images\bg-auth.jpg");
        // $uploadedFile = new \Symfony\Component\HttpFoundation\File\File("assets\images\bg-auth.jpg");

        dd($file);










        dd('xx');

        $client = new Client([
            'base_uri' => 'http://127.0.0.1',
            'headers' => [
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjEsIm5hbWUiOiJhZG1pbiIsImlhdCI6MTY3NDQwNjM0MSwiZXhwIjoxODMyMDg2MzQxfQ.kB7bjq2at1B_Wm507jq6gieX0MXxQxAAzgCD_3kuT4I',
                'Content-Disposition' => 'attachment; filename=image.jpg',
                // 'Content-type'=> 'image/*'
            ],
            'verify' => false
           
        ]);
        // dd($client);
        $file_path = 'assets\images\bg-auth.jpg';
$file_name = 'image.jpg';
$mime_type = mime_content_type($file_path);


        $response = $client->post('/wordpress/wp-json/wp/v2/media', [
            'headers' => [
                // 'Content-Type' => 'application/json'
                'Content-Disposition' => 'attachment; filename=' . $file_name,
                'Content-Type' => '.'.$mime_type,
            ],
            'body' => json_encode([
                'file' => base64_encode(file_get_contents('assets\images\bg-auth.jpg')),
                'post_title' => 'Image Title',
                'post_content' => '',
                'post_status' => 'publish',
                'post_mime_type' => 'image/*'
            ])
        ]);
        
        $media_id = json_decode($response->getBody()->getContents())->id;
        
        $response = $client->post('/wordpress/wp-json/wp/v2/posts/14', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode([
                'featured_media' => $media_id
            ])
        ]);
        


    }

}
