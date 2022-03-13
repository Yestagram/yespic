<?php

use BunnyPHP\View;

class RequestUtil
{
    public static function doGet($url)
    {
        return self::sendRequest($url);
    }

    public static function doPost($url, $data = '')
    {
        return self::sendRequest($url, $data, 'POST', ['Content-Type: application/x-www-form-urlencoded']);
    }

    public static function doUpload($url, $filename, $file_content = null)
    {
        $MULTIPART_BOUNDARY = '--------------------------' . microtime(true);
        $header = 'Content-Type: multipart/form-data; boundary=' . $MULTIPART_BOUNDARY;
        $file_contents = $file_content ?? file_get_contents($filename);
        $content = "--{$MULTIPART_BOUNDARY}\r\n" .
            "Content-Disposition: form-data; name=\"file\"; filename=\"" . basename($filename) . "\"\r\n" .
            "Content-Type: application/octet-stream\r\n\r\n" .
            $file_contents . "\r\n";
        $content .= "--$MULTIPART_BOUNDARY--\r\n";
        return self::sendRequest($url, $content, 'POST', [$header]);
    }

    private static function sendRequest($url, $data = '', $method = 'GET', $header = [])
    {
        $params = [
            'http' => [
                'method' => $method,
                'header' => array_merge(['User-Agent: BunnyPHP'], $header),
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];
        if ($method != 'GET') $params['http']['content'] = $data;
        $ctx = stream_context_create($params);
        $data = file_get_contents($url, false, $ctx);
        if ($data === false) {
            View::error(['ret' => '-8', 'status' => 'internal error', 'bunny_error' => error_get_last()]);
        }
        return $data;
    }
}