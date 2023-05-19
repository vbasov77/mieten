<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function front(Request $request)
    {
        if (empty(session('localityName'))) {
            return view('locality.locality');
        } else {
            $data =
                DB::select("select o.id, d.title, d.price, d.count_rooms, d.capacity,
   (select a.address from addresses a where obj_id = o.id) address,
   (select i.path from images i where obj_id = o.id order by i.id limit 1) path
from objects o left join addresses a on o.id = a.obj_id left join details d on o.id = d.obj_id 
where a.locality = " . session('locality') . " and o.published = 1");

            if ($request->session()->has('cardName')
                &&
                $request->session()->has('cardBodyName')
                &&
                $request->session()->has('cardFooterName')
            ) {
                $dataSession = [
                    'cardName' => session('cardName'),
                    'cardBodyName' => session('cardBodyName'),
                    'cardFooterName' => session('cardFooterName'),
                ];
            } else {
                $dataSession = [
                    'cardName' => 'card',
                    'cardBodyName' => 'card-body',
                    'cardFooterName' => 'card-footer',
                ];
            }
            return view('front', ['data' => $data, 'dataSession' => $dataSession]);
        }
    }

    public function addSession(Request $request)
    {
        $request->session()->put('cardName', $request->cardName);
        $request->session()->save();
        $request->session()->put('cardBodyName', $request->cardBodyName);
        $request->session()->save();
        $request->session()->put('cardFooterName', $request->cardFooterName);
        $request->session()->save();
        $res = ['session' => $request->cardFooterName];
        exit(json_encode($res));

    }
}
