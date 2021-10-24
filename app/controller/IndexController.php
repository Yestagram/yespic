<?php

use BunnyPHP\Controller;

class IndexController extends Controller
{
    function ac_index()
    {
        $this->render('index.php');
    }
}