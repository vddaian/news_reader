<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\NewspaperApiController;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class NewspaperController extends Controller
{
    public function index()
    {
        return view('newspaper.home');
    }

    public function show()
    {
        $articles = new NewspaperApiController();
        $articles = $articles->getContent();
        return view('newspaper.home')->with('articles', $articles);
    }

    public function store()
    {
    }
}
