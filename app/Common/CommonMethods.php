<?php

namespace App\Common;

use Storage;

class CommonMethods
{
    public static function GetPresignedURL(string $s3_key)
    {
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $command = $client->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $s3_key
        ]);
        $request = $client->createPresignedRequest($command, "+10 minutes");
        return (string) $request->getUri();
    }
}
