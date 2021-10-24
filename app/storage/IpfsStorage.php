<?php

use BunnyPHP\Storage;

/**
 * @author IvanLu
 * @time 2019/2/27 3:37
 */
class IpfsStorage implements Storage
{
    private $server;

    public function __construct($config = [])
    {
        $this->server = ($config['server'] ?? '') ?: 'https://ipfs.infura.io:5001/api/v0';
    }

    public function read($filename)
    {

        return RequestUtil::doGet($this->server . "/cat?arg=" . $filename);
    }

    public function write($filename, $content): string
    {
        $data = json_decode(RequestUtil::doUpload($this->server . '/add', $filename, $content), true);
        return '/ipfs/' . $data['Hash'];
    }

    public function upload(string $filename, string $path): string
    {
        $data = json_decode(RequestUtil::doUpload($this->server . '/add', $path), true);
        return '/ipfs/' . $data['Hash'];
    }

    public function remove($filename)
    {

    }
}