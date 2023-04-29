<?php

namespace App\Http\Controllers;

use App\Models\Locality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{

    public function getCityId(Request $request){
        $id = Locality::where('locality', $request->list)->value('id');
        $request->session()->put('locality', $id);
        $request->session()->put('localityName', $request->list);
        $request->session()->save();

        return redirect()->action('FrontController@front');
    }

    public function autocomplete(Request $request)
    {
        $res = DB::table('locations')->
            where("locality","LIKE","%{$request->name}%")
            ->pluck('locality');
        exit(json_encode($res));
    }

    public function test(){
        return view('test');
    }
}
