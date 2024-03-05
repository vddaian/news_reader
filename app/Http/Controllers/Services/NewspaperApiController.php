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

    public function getRssUrlById($id)
    {
        $url = Newspaper::select('feed')->where('id', $id)->get();
        return response()->json([
            'data' => $url,
        ]);
    }
    public function new($data)
    {
        if (!str_ends_with($data->url, '/')) {
            $data->url = $data->url . '/';
        }
        if (!str_ends_with($data->feed, '/')) {
            $data->feed = $data->feed . '/';
        }
        if (
            $data->validate([
                'url' => 'required|url',
                'feed'=> 'required|url',
            ])
        ) {
            try {
                $newspaper = Newspaper::where('url', $data->url)->get();
                if (count($newspaper) != 0) {
                    $userNews = DB::table('user_newspaper')->where('user_id', Auth::id())->where('newspaper_id', $newspaper[0]->id)->get();
                    if (!count($userNews)) {
                        DB::table('user_newspaper')->insert([
                            'user_id' => Auth::id(),
                            'newspaper_id' => $newspaper[0]->id,
                        ]);
                        return response()->json([
                            'status' => true,
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                        ]);
                    }
                } else {
                    $title = $this->getTitle($data->url);
                    $id = Str::uuid();
                    Newspaper::create([
                        'id' => $id,
                        'title' => $title,
                        'feed' => $data->feed,
                        'url' => $data->url,
                    ]);

                    DB::table('user_newspaper')->insert([
                        'user_id' => Auth::id(),
                        'newspaper_id' => $id,
                    ]);
                    return response()->json([
                        'status' => true,
                    ]);
                }

            } catch (Exception $error) {
                echo $error;
                return response()->json([
                    'status' => false,
                    'data' => $error,
                ]);
            }
        }
    }
    /* public function update($request)
    {
        $url = $request->url;
        $id = $request->id;
        Newspaper::where('id', $id)->update(['url' => $url]);
        return response()->json([
            'status' => true,
        ]);
    } */

    public function delete($id)
    {
        try {
            DB::table('user_newspaper')->where('user_id', Auth::id())->where('newspaper_id', $id)->delete();
            $newspapers = DB::table('user_newspaper')->where('newspaper_id', $id)->get();
            if (count($newspapers) == 0) {
                Newspaper::where('id', $id)->delete();
            }
            return response()->json([
                'status' => true,
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status' => true,
                'error' => $error,
            ]);
        }

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
                return response()->json([
                    'status' => false,
                    'error' => $error,
                ]);
            }
        });
        return response()->json([
            'data' => $data
        ]);
    }
    public function getRssContent($feed)
    {
        $data = [];
        $client = new Client();
        $crawler = $client->request('GET', $feed);
        $crawler->filter('item')->each(function ($node) use (&$data) {
            $title = $node->filter('title')->text();
            $data[] = $title;
        });
        return response()->json([
            'data' => $data
        ]);
    }

    public function getTitle($url)
    {
        $data = [];
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $title = $crawler->filter('title')->text();
        return $title;
    }
}
