<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Newspaper;
use Exception;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewspaperApiController extends Controller
{
    /* Funciones que realizan la recuperación de la base de datos */
    public function getAll()
    {
        try {
            $data = DB::table('user_newspaper')->where('user_id', Auth::id())->get();
            $newspapers = [];
            foreach ($data as $value) {
                $newspaper = Newspaper::where('id', $value->newspaper_id)->get();
                array_push($newspapers, $newspaper);
            }
            return response()->json([
                'data' => $newspapers
            ]);
        } catch (Exception $error) {
            return response()->json([
                'data' => $error,
            ]);
        }
    }

    public function getUrlById($id)
    {
        $url = Newspaper::select('url')->where('id', $id)->get();
        return response()->json([
            'data' => $url,
        ]);
    }
    public function new($data)
    {
        if (
            $data->validate([
                'title' => 'required',
                'url' => 'required|url|unique:newspapers'
            ])
        ) {
            try {
                $id = Str::uuid();
                Newspaper::create([
                    'id' => $id,
                    'title' => $data->title,
                    'url' => $data->url,
                ]);

                DB::table('user_newspaper')->insert([
                    'user_id' => Auth::id(),
                    'newspaper_id' => $id,
                ]);
                return response()->json([
                    'status' => true,
                ]);
            } catch (Exception $error) {
                return response()->json([
                    'status' => false,
                    'data' => $error,
                ]);
            }

        }

    }
    public function update()
    {
    }
    public function delete()
    {
    }

    /* Funciones que devuelven diferentes contenidos del periodico */

    public function getContent($url)
    {
        $data = [];
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $crawler->filter('article')->each(function ($node) use (&$data) {
            try {
                $link = $node->filter('a')->attr('href');
                if ($node->filter('h1')->count() > 0) {
                    $title = $node->filter('h1')->text();
                } else if ($node->filter('h2')->count() > 0) {
                    $title = $node->filter('h2')->text();
                } else {
                    $title = $node->filter('h3')->text();
                }
                $data[] = [$title => $link];
            } catch (Exception $error) {
            }
        });
        // Recoger los titulos de los enlaces recuperados.-
        return response()->json([
            'data'=> $data
        ]);
    }
}
