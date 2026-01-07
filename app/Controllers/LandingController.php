<?php

namespace App\Controllers;

class LandingController
{
    public function index()
    {
        include dirname(__DIR__, 2) . '/views/landing.php';
    }
}
