<?php

namespace App\Controllers;

use Core\View;
use App\Models\Album;
use App\Models\Band;

class AlbumsController extends Controller
{
    /**
     * Display all the albums
     * @return null
     */
    public function index()
    {
        $albums = Album::all();
        $bands = Band::all();
        View::view('albums/index.html', compact('albums', 'bands'));
    }

    /**
     * Display information about a specific album
     * @param  integer $id
     * @return null
     */
    public function show($id)
    {

    }

    /**
     * Save a new album
     * @return array
     */
    public function store()
    {
        $album = Album::save($_POST);
        if ($album) {
            http_response_code(201);
        } else {
            http_response_code(500);
        }
        echo $album;
    }

    /**
     * Delete an album
     * @param  integer $id
     * @return integer
     */
    public function destroy($id)
    {
        $album = Album::delete($id);
        http_response_code(200);
        echo $album;
    }
}
