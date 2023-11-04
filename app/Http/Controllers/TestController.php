<?php

namespace App\Http\Controllers;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{
  public function sendmessage()
  {    
    try {

      $token = env('WHATSAPP_API_TOKEN');
      $phoneId = env('WHATSAPPI_API_PHONE_ID');
      $version = 'v17.0';
      $payload = [
        "messaging_product" => "whatsapp",
        "to" => "59177778837",
        "type" => "template",
        "template" => [
          "name" => "hello_world",
          "language" => [
            "code" => "en_US"
          ]
        ]
      ];
      $message = Http::withToken($token)->post('https://graph.facebook.com/' . $version . '/' . $phoneId . '/messages', $payload)->throw()->json();
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

  public function verifyWebhook(Request $request){
    try {
      $verifyToken = 'universidad';
      $query = $request->query();

      $mode = $query['hub_mode'];
      $token = $query['hub_verify_token'];
      $challenge = $query['hub_challenge'];
      if ($mode && $token) {
        if ($mode === 'subscribe' && $token == $verifyToken) {
          return response($challenge, 200)->header('Content-Type', 'text/plain');
        }
      }

      throw new Exception('Invalid request');


      
      
      
    }catch (Exception $e) {
      return response()->json([
        'sucess' => false,
        'error' => $e->getMessage(),
      ], 500);      
    }
  }

  public function processWebhook(Request $request){
    try {
      $bodyContent = json_decode($request->getContent(), true);
      //para que no devuelva error por audios
      $body = '';
      $value = $bodyContent['entry'][0]['changes'][0]['value'];

      if(!empty($value['messages'])){
        if($value['messages'][0]['type']= 'text'){
          $body = $value['messages'][0]['text']['body'];
        }
        
      }
      return response()->json([
        'sucess' => true,
        'data' => $body,
      ], 200);

      
      
    }catch (Exception $e) {
      return response()->json([
        'sucess' => false,
        'error' => $e->getMessage(),
      ], 500);      
    }
  }
}