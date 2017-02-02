<?php

namespace App\Controllers;

use Core\View;
use App\Models\Band;
use App\Models\Album;

class BandsController extends Controller
{
    /**
     * Display all the bands
     * @return null
     */
    public function index()
    {
        $bands = Band::all();
        View::view('bands/index.html', compact('bands'));
    }

    /**
     * Display a band by id
     * @param  integer $id
     * @return null
     */
    public function show($id)
    {
        $band = Band::get($id);
        $albums = Album::getByBandId($id);
        View::view('bands/show.html', compact('band', 'albums'));
    }

    /**
     * Create a new record
     * @return integer
     */
    public function store()
    {
        $band = Band::save($_POST);
        if ($band) {
            http_response_code(201);
        } else {
            http_response_code(500);
        }
        echo $band;
    }

    /**
     * Delete record
     * @param  integer $id
     * @return integer
     */
    public function destroy($id)
    {
        $band = Band::delete($id);
        http_response_code(200);
        echo $band;
    }
}
