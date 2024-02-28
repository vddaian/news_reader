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
        $newspapers = new NewspaperApiController();
        $newspapers = $newspapers->getAll();
        return view('newspaper.home')->with('newspapers', $newspapers->original['data'][0]);
    }

    public function show()
    {
        $articles = new NewspaperApiController();
        $articles = $articles->getContent();
        return view('newspaper.newspaper')->with('articles', $articles);
    }

    public function store(Request $request)
    {
        $api = new NewspaperApiController();
        $response = $api->new($request);
        if ($response->original->status) {
            return redirect()->route('newsp.home');
        } 
    }
}
