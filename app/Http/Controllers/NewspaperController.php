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
        $api = new NewspaperApiController();
        $newspapers = $api->getAll();
        $newspapers = isset($newspapers->original['data'])?$newspapers->original['data']:null;
        $articles = [];
        foreach ($newspapers as $newspaper) {
            array_push($articles, $api->getContent($newspaper[0]->url));
        }
        $data = [
            'newspapers' => $newspapers,
            'articles' => $articles,
        ];
        return view('newspaper.home')->with('data', $data);
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
            return redirect()->route('newsp.index');
        } 
    }
}
