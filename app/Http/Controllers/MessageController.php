<?php

namespace App\Http\Controllers;


use App\Models\Address;
use App\Models\Image;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function add(Request $request)
    {
        $message = [
            'from_user_id' => $request->from_user_id,
            'to_user_id' => $request->to_user_id,
            'obj_id' => $request->obj_id,
            'body' => $request->body,
        ];
        $id = DB::table('messages')->insertGetId($message);
        $date = Message::where('id', $id)->value('created_at');
        return response()->json([
            'bool' => true,
            'id' => $id,
            'body' => $request->body,
            'date' => $date
        ]);
    }

    public function notified(Request $request)
    {
        $notified = [];
        for ($i = 0; $i < count($request->array_id); $i++) {
            $not = Message::where('id', $request->array_id[$i])->first();
            if ($not->status == 1) {
                $notified [] = $not;
            }

        }
        exit(json_encode($notified));
    }

    public function myMessages()
    {
        $myMessages = DB::select('select m.*, (select id from users where id = (case when m.from_user_id = 
' . Auth::id() . ' then m.to_user_id else m.from_user_id end)) user_id, (select i.path from images i where obj_id = m.obj_id order by i.id limit 1) path
from messages m
where m.id in (select max(m2.id)
                       from messages m2
                       where ' . Auth::id() . ' in (from_user_id, to_user_id)
                       group by (case when from_user_id = ' . Auth::id() . ' then to_user_id else from_user_id end)
                      );');
        return view('messages.my_messages', ['messages' => $myMessages]);
    }


    public function view(Request $request)
    {
        $messages = DB::select('select m.* from messages m where 
(from_user_id= ' . $request->to_user_id . ' and to_user_id = ' . Auth::id() . ') 
or 
(from_user_id = ' . Auth::id() . ' and to_user_id = ' . $request->to_user_id . ') and obj_id = ' . $request->id . ';');
        $userId = Auth::id();
        if (!empty(count($messages))) {
            if ($messages[0]->from_user_id != Auth::id()) {
                $toUser = $messages[0]->from_user_id;
            } else {
                $toUser = $messages[0]->to_user_id;
            }
        } else {
            $toUser = $request->to_user_id;
        }
        for ($i = 0; $i < count($messages); $i++) {
            if ($messages[$i]->to_user_id == Auth::id() && $messages[$i]->status == 0) {
                Message::where('id', $messages[$i]->id)->update(['status' => 1]);
                $messages[$i]->status = 1;
            }
        }
        $data = DB::select('select id, user_id, (select path from images i where obj_id = ' . $request->id . ') path, 
        (select address from addresses where obj_id = ' . $request->id . ') address, (select u.name from users u 
        where u.id = o.user_id)name  from objects o where id =' . $request->id);
        return view('messages.view', ['data' => $data[0], 'messages' => $messages, 'userId' => $userId, 'toUser' => $toUser]);
    }

    public function deleteMsg(Request $request)
    {
        Message::where('id', $request->id)->delete();
        $res = ['answer' => 'ok'];
        exit(json_encode($res));
    }

    public function checkNewMsg(Request $request)
    {
        $messages = Message::where('to_user_id', $request->from_user_id)
            ->where('from_user_id', $request->to_user_id)
            ->where('obj_id', $request->obj_id)->where('status', 0)->get();
        if (!empty(count($messages))) {
            $array = [];
            for ($i = 0; $i < count($messages); $i++) {
                Message::where('id', $messages[$i]->id)->update(['status' => 1]);
                $array[] = $messages[$i];
            }
            $result = ['bool' => true, 'messages' => $array];
            exit(json_encode($result));
        }
        return response()->json([
            'bool' => false,
        ]);

    }

}
