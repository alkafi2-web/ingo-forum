<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function index()
    {
        $lines = [
            "User-agent: *",
            "Disallow: /admin",
            "Disallow: /admincp",
            "Disallow: /mcp",
            "Disallow: /login",
            "Disallow: /register",
            "Disallow: /password/reset",
            "Disallow: /password/email",
            "Sitemap: " . url('/sitemap.xml')
        ];

        $content = implode(PHP_EOL, $lines);

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
