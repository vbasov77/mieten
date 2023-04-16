<?php

namespace App\Http\Controllers;

use App\Models\Locality;
use App\Models\Obj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function front(Request $request)
    {
        if (empty(session('locality'))) {
            return view('search');
        } else {
            $data =
                DB::select("select o.id, o.title, o.count_rooms, o.capacity, o.price,
   (select i.path from images i where obj_id = o.id order by i.id limit 1) path
from objects o left join addresses a on o.id = a.obj_id where a.locality = " . session('locality'));
            return view('front', ['data' => $data]);
        }
    }
}
