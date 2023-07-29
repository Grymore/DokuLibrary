<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


use App\Helpers\SignatureHelper;


class AccountCreationSnapController extends Controller
{
    public function RequestSignature(Request $request)
    {
        // $clientId = $request->input('client_ID');

        $signatureHelper = new SignatureHelper();
        $GenerateResponse = $signatureHelper->generateSignature(); //generate X-SIGNATURE & X-TIMESTAMP

        $AlldataGenerate = $GenerateResponse->getContent();
        $data = json_decode($AlldataGenerate, true);

        $url = 'https://api-sandbox.doku.com/authorization/v1/access-token/b2b';

        $Signature = $data['X-SIGNATURE'];
        $Timestamp = $data['X-TIMESTAMP'];
        $client_ID = $data['X-CLIENT-KEY'];

        // $bodyRequest = [

        //     "grantType" => "client_credentials"
        // ];

        $bodyRequest = $request->input();
        $header = [
            'X-CLIENT-KEY' => $client_ID,
            'X-TIMESTAMP' => $Timestamp,
            'X-SIGNATURE' => $Signature,
        ];

        // request ke DOKU
        $response = Http::withHeaders($header)->post($url, $bodyRequest);

        $daridoku = $response->getBody();
        $responseDoku = json_decode($daridoku, true);

        return response()->json([
            "response_doku" => $responseDoku,
            "request_body" => $bodyRequest,
            "request _header" => $header
        ]);
    }
}