<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends BaseController
{
    public function get_msg_userlist (Request $request)
    {
        $user = Auth::user();

        $query = DB::raw("SELECT DISTINCT users.id, users.name, users.ava_path, MAX(chats.created_at) AS created_time FROM chats JOIN users ON users.id = chats.sender_id OR users.id = chats.receiver_id WHERE users.id <> " . $user->id . " AND ( chats.sender_id = " . $user->id . " OR chats.receiver_id = " . $user->id . ") GROUP BY users.id ORDER BY created_time DESC");
        $list = DB::select($query);

        return $this->sendResponse($list, 'get_msg_userlist');
    }

    public function get_msg (Request $request)
    {
        $user = Auth::user();
        $query_array = $request->query();
        $target_user = $query_array['targetuser'];

        $query = DB::raw("SELECT * FROM Chats WHERE (sender_id = " . $user->id . " AND receiver_id = " . $target_user . ") OR (sender_id = " . $target_user . " AND receiver_id = " . $user->id . ") ORDER BY created_at");
        $list = DB::select($query);

        return $this->sendResponse($list, 'get msg');
    }

    public function insert_msg (Request $request)
    {
        $user = Auth::user();
        $query_array = $request->all();
        $msg = $query_array['msg'];
        $target_user = $query_array['target_user'];

        $done_msg = $user->chats_sender()->create([
            'receiver_id' => $target_user,
            'msg' => $msg
        ]);

        broadcast(new \App\Events\PrivateChatEvent($target_user));

        return $this->sendResponse($done_msg, 'send msg');
    }
}
