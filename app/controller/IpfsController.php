<?php


use BunnyPHP\BunnyPHP;
use BunnyPHP\Controller;

class IpfsController extends Controller
{
    protected static array $IMAGE = ['image/bmp', 'image/gif', 'image/jpeg', 'image/pjpeg', 'image/png', 'application/x-bmp', 'application/x-jpg', 'application/x-png'];
    protected static int $SIZE = 20000000;

    public function ac_upload_post()
    {
        if (!isset($_FILES['image'])) return [];
        $file = $_FILES['image'];
        if (!in_array($file['type'], self::$IMAGE) || ($file['size'] > self::$SIZE)) {
            return ['ret' => 2, 'status' => 'invalid file'];
        }
        $url = BunnyPHP::getStorage()->upload('avatar/' . sha1(time()) . '.jpg', $file['tmp_name']);
        return ['ret' => 0, 'status' => 'ok', 'url' => $url];
    }

    public function ac_write_post(string $content)
    {
        $url = BunnyPHP::getStorage()->write('content/' . sha1(time()) . '.txt', $content);
        return ['ret' => 0, 'status' => 'ok', 'url' => $url];
    }

    /**
     * @param string $storageName config(storage.name)
     * @param array $hash path()
     */
    public function other(string $storageName, array $hash = [])
    {
        $extra = $hash ? ('/' . implode('/', $hash)) : '';
        $path = BUNNY_ACTION . $extra;
        if ($storageName == 'ipfs') {
            $lm = $_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? gmdate('r', time());
            header('ETag: "' . md5($path) . '"');
            header('Last-Modified: ' . $lm);
            header('Cache-Control: public');
            if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) || isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
                header('HTTP/1.1 304 Not Modified');
                exit();
            }
            header('Content-type: image');
            echo (BunnyPHP::getStorage())->read($path);
        } else {
            $this->redirect("https://ipfs.io/ipfs/$path");
        }
    }
}