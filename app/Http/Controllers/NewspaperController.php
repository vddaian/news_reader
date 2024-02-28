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
        $newspaper = new NewspaperApiController();
        $newspaper = $newspaper->getAll();
        return view('newspaper.home')->with('newspaper', $newspaper);
    }

    public function show()
    {
        $articles = new NewspaperApiController();
        $articles = $articles->getContent();
        return view('newspaper.newspaper')->with('articles', $articles);
    }

    public function store()
    {
    }
}
