<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use GuzzleHttp\Psr7\Query;

use Illuminate\Support\Facades\Http;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function sendMessages()
    {
        try {
        
            $token = 'EAAOwSKd5dJQBO5yhjJqHldttZCZAXvNtmjlZC49rIxJNZATYRmwZARLpI8OXKWGvV6lqQNMMfulUcbZBNAHQCXBP5nlpHDZBdDZCAeIJPtg0G9kNt6j13RWzbkJrslDqDuGXiug2G2DPZAZAu350nSKRqEF2O0uKbttCGCblOf3aXyKTHYaKSBZBy7oCY9oFp4ZASQCXQZBZAeTqMczIJRedtkdKSlAvrdvbYjVLZAKV1YZD';
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

    public function verifyWebhook(Request $request)
    {
        try {
            $verifyToken = env('WHATSAPP_VERIFY_TOKEN');
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
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }





public function recibir(Request $request){
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
    } catch (Exception $e) {
      return response()->json([
        'sucess' => false,
        'error' => $e->getMessage(),
      ], 500);
    }
  }}