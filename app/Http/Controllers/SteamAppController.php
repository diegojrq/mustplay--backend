<?php

namespace App\Http\Controllers;

use App\Models\SteamApp;
use App\Models\SteamAppDetails;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SteamAppController extends Controller
{
    public function index()
    {
        $apps = SteamApp::all();
        return $apps;
    }

    public function show($id)
    {
        $response = Http::get('http://store.steampowered.com/api/appdetails?appids=' . $id . '&cc=BRA');

        $appDetails = SteamAppDetails::find($id);
        
        if ($appDetails) {
            $appDetails->update($response[$id]['data']);
        } else { 
            $appDetails = SteamAppDetails::create($response[$id]['data']);
        }

        return $appDetails;
    }

    public function store(Request $request)
    {
        return SteamApp::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $book = SteamApp::findOrFail($id);
        $book->update($request->all());

        return $book;
    }

    public function delete(Request $request, $id)
    {
        $book = SteamApp::findOrFail($id);
        $book->delete();

        return 204;
    }
}
