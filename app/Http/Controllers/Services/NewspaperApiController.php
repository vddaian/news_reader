<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Models\Newspaper;
use Exception;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewspaperApiController extends Controller
{
    /* Funciones que realizan la recuperación de la base de datos */
    public function getAll()
    {
        try {
            $id = Auth::id();
            $data = DB::table('user_newspaper')->where('user_id', $id)->get();
            return response()->json(
                $data
            );
        } catch (Exception $error) {
            return response()->json([
                'data' => $error
            ]);
        }
    }

    public function getById()
    {
    }
    public function new()
    {
    }
    public function update()
    {
    }
    public function delete()
    {
    }

    /* Funciones que devuelven diferentes contenidos del periodico */

    public function getContent()
    {
        $data = [];
        $client = new Client();
        $crawler = $client->request('GET', 'https://www.elconfidencial.com/');
        $crawler->filter('article a')->each(function ($node) use (&$data) {
                $link = $node->attr('href');
                $data[] = $link;
        });
        // Recoger los titulos de los enlaces recuperados.-
        return response()->json([
            $data
        ]);
    }
}
