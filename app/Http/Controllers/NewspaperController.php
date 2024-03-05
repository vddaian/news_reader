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
        $newspapers = isset($newspapers->original['data']) ? $newspapers->original['data'] : null;
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
        // Arrays donde se organizan los articulos .-
        $validArt = [];
        $invalidArt = [];
        
        // Llamada al controlador api que recogera las url del periodico y posteriormente todos los articulos .-
        $api = new NewspaperApiController();
        $url = $api->getUrlById($id);
        $feed = $api->getRssUrlById($id);
        $articles = $api->getContent($url->original['data'][0]['url']);
        $rssArticles = $api->getRssContent($feed->original['data'][0]['feed']);

        //Comprobación de la validez del articulo .-
        foreach ($articles->original['data'] as $key => $article) {
            foreach ($article as $newsTitle => $link) {
                $valid = false;
                foreach ($rssArticles->original['data'] as $key => $rssTitle) {
                    if($newsTitle == $rssTitle){
                        $valid = true;
                    }
                }
                if ($valid) {
                    array_push($validArt, $article);
                }else{
                    array_push($invalidArt, $article);
                }
            }
        }

        // Calculo de la precision .-
        $range = round($range = (count($validArt) * 100) / count($articles->original['data']), 1);
        $data = [
            'valid_articles' => $validArt,
            'invalid_articles' => $invalidArt,
            'range' => $range,
        ];
         return view('newspaper.newspaper')->with('data', $data);
    }

    public function store(Request $request)
    {
        $api = new NewspaperApiController();
        $response = $api->new($request);
        return redirect()->route('newsp.index');
    }

    public function delete($id)
    {
        $api = new NewspaperApiController();
        $response = $api->delete($id);
        return redirect()->route('newsp.index');
    }
}
