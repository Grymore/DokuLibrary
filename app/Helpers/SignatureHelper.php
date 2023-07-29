<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\RSA\PrivateKey;


class SignatureHelper
{
    function generateSignature()
    {

        date_default_timezone_set('Asia/Jakarta');

        // Format tanggal dan waktu sesuai format yang diinginkan
        $timestamp = date('Y-m-d\TH:i:sP');
        $client_ID = '3189';
        $stringToSign = $client_ID . "|" . $timestamp;

        $hash = hash('sha256', $stringToSign);



        $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
            "MIIEowIBAAKCAQEAtrWrh7pC6nnSg2c24lWrUxcyYz+Oi4nZdvNd6IrZGDS4rYrj\n" .
            "ogopiXIdoVHfCtx6jphkyNAi5BamaiFIbDaT51PDgAWbRVigHq5+pGEoiUQ9m8DE\n" .
            "QVkhulneF884yUnFoAYrTAVSmBx0wjjXQ2Qtdv0+gvtkdvr/0kZrL7oLHqbHPmww\n" .
            "JuHvDY+DSrazLOVPBJ02RxkeX/glLsBG3jadGdrRfYGIG5FK07jGDUA/Wq60bnzK\n" .
            "m4bu7jy4lSd8OXsetsqB4NaWPcwQSVBhbfWvDRvTar1hk9Ydm1HPqzwMLwSHFCTj\n" .
            "y/JZ3l00HnmSzeBmJ2FKAecI0lvoIh5rYTlY3QIDAQABAoIBAHEbeAu3IBO9xLd6\n" .
            "HvzwofX3R0cvolP5y3ka4cjCo/CbOrScZZz7g4lF7tfeMiCsKua5qrKyPtdKuky7\n" .
            "O/VZuCgdr8pCLkQ4wC8eQOIMD6ciaq1QIW5++iU92wKMUxAxLjmJeCZAqUfnXdSa\n" .
            "kZBzpL2jup4leKU7b0FCPLq4Bog7E9kGAADk3mySYDw+JaaH+3AEV89tvWEoZ3yk\n" .
            "cU5Txc+MaBf+PJjjkynx9wW+qvec0Z39KIRe/6Xs3bAc/vRo1f8KGXepTZdT1dC6\n" .
            "tsZvF4TYsOTbzbzIzEZS3nFgFadhNEux5B18vPdIVjYDqslcwSeMyHio/NJEA1xF\n" .
            "SoLL5QECgYEA7jbuGtjPgXYrF62jIStpG1mA9n1uZOvBKPG9Do9+TY4mzJlfLJAl\n" .
            "Y6Y590qYVEYiQd6jVLDiOTaUELCem+iLhxQi5Eve6GCWAq+Fk/BqBfoUrOOEdvF3\n" .
            "LunalXfhQOXo5OwHG/dNISrAyogopA6cnhfCOWkH4SYwTnMmet4k950CgYEAxFnb\n" .
            "YBQIukxhkcqBaGtK1Up0z2C8VJCxXlnf51POJgSgECVBwiSpy/jrlA+bgI3opY27\n" .
            "EZ3xaCgClluJGlvNjDcWviYg+D9ym8w0hbbNesXBWG4RClTk6SInXtJmOjyDpFjN\n" .
            "czsoSdU6ddn40NTirlvYfCp9QOEMbOM0S5oAQkECgYEAs505ZYbK13vJPD5RfSYl\n" .
            "R1jyU2j6PyA/8eZsPblWa5XejXCrgYdimcNxe5OETi7fj7kWgDorKSaM+BSkUzxB\n" .
            "UGWPdYH7nk2NbpL37jddSgppYn7el2y0B+yOQxsz/eIc+9c3+Q872eFJoqyNsD3Q\n" .
            "O6gAa5dVOJ+51r0ea5BqYUUCgYBK+EAx1BRtBYLvhpGYi/bbr30gPUBLTZ/bdZdv\n" .
            "HOmGTJfM8lzEQvlt/xH7y2XFVOmyZIY7uMGW0kgCntqfbNPzqIkPe0F1Z8xbvkGD\n" .
            "mIOmT+F94TCycC2i8j50DwOnUrm0w49WYw0D+91BaEN/gPk4N6tV5WdDoWn8HVg3\n" .
            "UYqtwQKBgAlGiqrW4fRUPHtFsjSZ9PXaWWB7YM/x2Ha6wX5l7Lld/HakuapgPrMT\n" .
            "zYdCztyurRMIJEXwXBDb3E7AesdrTQKLrNDYT4jtHe3kt/cm+HnFc2ma1HjQ3MKr\n" .
            "VTzT+CztuOEFrFLRiEIiLR8DXgduSk2nUXAmyN7d+FYa6RUO/sSX\n" .
            "-----END RSA PRIVATE KEY-----";



        $rsa = RSA::load($privateKey);
        $signature = $rsa->sign($hash);
        $signatureBase64 = base64_encode($signature);


        return response()->json([
            'X-SIGNATURE' => $signatureBase64,
            'X-TIMESTAMP' => $timestamp,
            'X-CLIENT-KEY' => $client_ID
        ]);


    }

}