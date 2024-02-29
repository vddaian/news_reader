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
        $newspapers = isset($newspapers->original['data'])?$newspapers->original['data']:null;
        return view('newspaper.home')->with('newspapers', $newspapers);
    }

    public function show($id)
    {
        $api = new NewspaperApiController();
        $url = $api->getUrlById($id);
        $articles = $api->getContent($url->original['data'][0]->url);
        return view('newspaper.newspaper')->with('articles', $articles->original['data']);
    }

    public function store(Request $request)
    {
        $api = new NewspaperApiController();
        $response = $api->new($request);
        if ($response->original['status']) {
            return redirect()->route('newsp.home');
        } 
    }
}
