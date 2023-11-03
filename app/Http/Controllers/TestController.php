<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
  public function sendmessage()
  {
    //         $curl = curl_init();

    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => 'https://graph.facebook.com/v17.0/122463694292300/messages',
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => '',
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 0,
    //             CURLOPT_FOLLOWLOCATION => true,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => 'POST',
    //             CURLOPT_POSTFIELDS => '{
    //     "messaging_product": "whatsapp",
    //     "to": "59177778837",
    //     "type": "template",
    //     "template": {
    //         "name": "hello_world",
    //         "language": {
    //             "code": "en_US"
    //         }
    //     }
    // }',
    //             CURLOPT_HTTPHEADER => array(
    //                 'Content-Type: application/json',
    //                 'Authorization: Bearer EAAOwSKd5dJQBO1jXOgvGtwO1jq0q6cTjAri17wRM5HR7CWgP9ZCwVZAOs2yZBf49jpOHKFU5NwkdkDiohW8PKlCJgHvjWn362sPRS2Gvf0uzBpZAycff6s78slKEZCVsUdxPhwAsHftFMaQeSwbn44dyGv0u4UNPAPFcJZA7ZAS2YuM8ojaTto1WLGRYzWXKvNZCDQ8IPsVXgR5jJqDRNymE3vayT37W0cQWol95n9cZD'
    //             ),
    //         ));

    //         $response = curl_exec($curl);

    //         curl_close($curl);
    //         echo $response;
    try {
      
      $token = 'EAAOwSKd5dJQBO1jXOgvGtwO1jq0q6cTjAri17wRM5HR7CWgP9ZCwVZAOs2yZBf49jpOHKFU5NwkdkDiohW8PKlCJgHvjWn362sPRS2Gvf0uzBpZAycff6s78slKEZCVsUdxPhwAsHftFMaQeSwbn44dyGv0u4UNPAPFcJZA7ZAS2YuM8ojaTto1WLGRYzWXKvNZCDQ8IPsVXgR5jJqDRNymE3vayT37W0cQWol95n9cZD';
      $phoneId = '122463694292300';
      $version = 'v17.0';
      $payload = [
        "messaging_product"=> "whatsapp",
        "to"=> "59177778837",
        "type"=> "template",
        "template"=> [
          "name"=> "hello_world",
          "language"=> [
            "code"=> "en_US"
          ]
        ]
      ];
      $message = Http::withToken($token)->post('https://graph.facebook.com/'. $version.'/'. $phoneId.'/messages', $payload)->throw()->json();
      return response()->json([
        'sucess' => true,
        'data' => $message,
      ], 200);
    } catch (Exception $e) {
      return response()->json([
        'sucess' => false,
        'error' => $e->getMessage(),
      ], 500);
    }
      
    }
    public function recibir(Request $request){
      try {
  
        $verifyToken = 'universidad';
        $query = $request->query();
        $mode = $query['hub_mode'];
        $challenge = $query['hub_challenge'];
        $token = $query['hub_verify_token'];
        if($mode && $token){
          if($mode === 'subscribe' && $token == $verifyToken){
            return response($challenge, 200)->header('Content-Type', 'text/plain');
            
            
          }
        }
        throw new Exception('Invalid request');
      } catch (Exception $e) {
        return response()->json([
          'sucess' => false,
          'error' => $e->getMessage(),
        ], 500);
      }
    }
  
    public function procesar(Request $request){
      try {
        $bodyContent =json_decode($request->getContent(), true);
        return response()->json([
          'sucess' => true,
         
        ], 200);
       
      } catch (Exception $e) {
        return response()->json([
          'sucess' => false,
          'error' => $e->getMessage(),
        ], 500);
      }
    }
  }

  