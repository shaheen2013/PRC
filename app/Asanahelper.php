<?php

namespace App;
use App\Accesstoken;


class Asanahelper
{
    public function accessToken($clientId){
        $token = Accesstoken::where('client_id', $clientId)->first();

        $data = [
            'grant_type'    => 'refresh_token',
            'client_id'     => $token->client_id,
            'client_secret' => '2806cc5908cf4fc63acaa27840062588',
            'redirect_uri'  => 'https://nova.local',
            'code'          => $token->code,
            'refresh_token' => $token->refresh_token
        ];
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://app.asana.com/-/oauth_token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        }else{
            return $response;
        }
    }
}