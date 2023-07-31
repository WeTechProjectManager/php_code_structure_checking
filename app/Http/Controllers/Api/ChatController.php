<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlockList;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Rfc4122\NilUuid;
use App\Models\User;
use Dompdf\FrameDecorator\Block;

class ChatController extends Controller
{
    public function create_Conversation(Request $request)
    {
        $validate = $request->validate([
            'receiver_id'                    => 'required',
            'message'                        => 'required',
        ]);

        $user_id = Auth::user()->id;
        $receiver_id = $request->receiver_id;
        $validate = Conversation::where('sender_id', '=', $user_id)->where('paid', 'no')->count();
        $paidvalidate = Conversation::where('sender_id', '=', $user_id)->where('paid', 'yes')->first();

        $checkUser1 = User::where('id', $user_id)->first();
        $checkUser2 = User::where('id', $receiver_id)->first();

        $blockUser1 = "";
        $blockUser1 = BlockList::where('user_id', $receiver_id)->where('block_user_id', $user_id)->where('status', 'blocked')->first();

        if (isset($blockUser1) && $blockUser1->block_user_id == $user_id) {
            return response()->json(['message' => 'You Are Blocked'], 200);
        } else {

            if ($checkUser1->gender !=  $checkUser2->gender) {
                if ($validate > 0) {
                    return response()->json(['message' => 'You have to pay first'], 200);
                } elseif ($paidvalidate != null ||  $paidvalidate != "") {
                    $chat = new Conversation();
                    $chat->sender_id = $user_id;
                    $chat->receiver_id =  $receiver_id;
                    $chat->message =  $request->message;
                    $chat->paid = 'yes';
                    $chat->save();
                } else {
                    $chat = new Conversation();
                    $chat->sender_id = $user_id;
                    $chat->receiver_id =  $receiver_id;
                    $chat->message =  $request->message;
                    $chat->paid = 'no';
                    $chat->save();
                }
            } else {
                return response()->json(['message' => 'Sorry, You Cant Talk With Same Gender'], 404);
            }
        }

        if ($chat) {
            return response()->json(['message' => 'Message Sent Successfully'], 200);
        } else {
            return response()->json(['message' => 'Something Went Worng'], 404);
        }
    }

    public function show_Conversation(Request $request)
    {
        $user_id = Auth::user()->id;
        $chat_user_id = $request->chat_user_id;


        $chat_list = Conversation::where(function ($query) use ($user_id, $chat_user_id) {
            $query->where('sender_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        })
            ->where(function ($query) use ($user_id, $chat_user_id) {
                $query->where('receiver_id', $chat_user_id)
                    ->orWhere('sender_id', $chat_user_id);
            })
            ->where('deleted_by_receiver', '!=', $user_id)
            ->where('deleted_by_sender', '!=', $user_id)
            ->where('deleted_for_everyone', 0)
            ->orderBy('id', 'desc')
            ->get();


        $chat_user_details = User::where('id', $chat_user_id)->first();
        $chat_user_details['image'] = config('app.url') . '/' . 'public/assets/user/' . $chat_user_details['image'];
        $chat_user_details['cover_pic'] = config('app.url') . '/' . 'public/assets/user/cover/' . $chat_user_details['cover_pic'];

        $response = [
            'chat_list' => $chat_list,
            'chat_user_details' => $chat_user_details,
        ];
        return response()->json($response);
    }

    public function show_all_Conversation(Request $request)
    {
        $user_id = Auth::user()->id;

        // $show_all_chat = Conversation::where(function ($query) use ($user_id) {
        //     $query->where('sender_id', $user_id)
        //         ->orWhere('receiver_id', $user_id);
        // })
        //     ->where('deleted_by_receiver', '!=', $user_id)
        //     ->where('deleted_by_sender', '!=', $user_id)
        //     ->where('deleted_for_everyone', 0)
        //     ->orderBy('id', 'desc')
        //     ->get();

        $latest_conversations = Conversation::where(function ($query) use ($user_id) {
            $query->where('sender_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        })
            ->where('deleted_by_receiver', '!=', $user_id)
            ->where('deleted_by_sender', '!=', $user_id)
            ->where('deleted_for_everyone', 0)
            ->selectRaw('MAX(id) as id, LEAST(sender_id, receiver_id) as sender_receiver, GREATEST(sender_id, receiver_id) as receiver_sender')
            ->groupBy('sender_receiver', 'receiver_sender')
            ->latest('id');

        $show_all_chat = Conversation::joinSub($latest_conversations, 'latest_conv', function ($join) {
            $join->on('conversations.id', '=', 'latest_conv.id');
        })
            ->join('users', 'users.id', '=', 'conversations.sender_id')
            ->join('users as user2', 'user2.id', '=', 'conversations.receiver_id')
            ->select('conversations.*', 'users.name as sender_name', 'users.image as sender_image', 'user2.image as receiver_image', 'user2.name as receiver_name')
            ->orderBy('conversations.id', 'desc')
            ->get();

        foreach ($show_all_chat  as $key => $chats) {
            if ($chats->sender_image != null || $chats->sender_image != '') {
                $show_all_chat[$key]['sender_image'] = config('app.url') . '/' . 'public/assets/user/' . $chats->sender_image;
            } else {
                $show_all_chat[$key]['sender_image'] = '';
            }
        }


        foreach ($show_all_chat  as $key => $chats) {
            if ($chats->receiver_image != null || $chats->receiver_image != '') {
                $show_all_chat[$key]['receiver_image'] = config('app.url') . '/' . 'public/assets/user/' . $chats->receiver_image;
            } else {
                $show_all_chat[$key]['receiver_image'] = '';
            }
        }


        // ======================================  online user =================================================


        $latest_conversation = Conversation::where(function ($query) use ($user_id) {
            $query->where('sender_id', $user_id)
                ->orWhere('receiver_id', $user_id);
        })
            ->where('deleted_by_receiver', '!=', $user_id)
            ->where('deleted_by_sender', '!=', $user_id)
            ->where('deleted_for_everyone', 0)
            ->selectRaw('MAX(id) as id, LEAST(sender_id, receiver_id) as sender_receiver, GREATEST(sender_id, receiver_id) as receiver_sender')
            ->groupBy('sender_receiver', 'receiver_sender')
            ->latest('id');

        $show_all_chats = Conversation::joinSub($latest_conversation, 'latest_conv', function ($join) {
            $join->on('conversations.id', '=', 'latest_conv.id');
        })
            ->join('users', 'users.id', '=', 'conversations.sender_id')
            ->join('users as user2', 'user2.id', '=', 'conversations.receiver_id')
            ->select('conversations.*', 'users.name as sender_name', 'users.image as sender_image', 'user2.image as receiver_image', 'user2.name as receiver_name', 'users.login_status as sender_login_status', 'user2.login_status as receiver_login_status',)
            ->orderBy('conversations.id', 'desc')
            ->get();

        foreach ($show_all_chats  as $key => $chat) {
            if ($chat->sender_image != null || $chat->sender_image != '') {
                $show_all_chats[$key]['sender_image'] = config('app.url') . '/' . 'public/assets/user/' . $chat->sender_image;
            } else {
                $show_all_chats[$key]['sender_image'] = '';
            }
        }

        foreach ($show_all_chats  as $key => $chat) {
            if ($chat->receiver_image != null || $chat->receiver_image != '') {
                $show_all_chats[$key]['receiver_image'] = config('app.url') . '/' . 'public/assets/user/' . $chat->receiver_image;
            } else {
                $show_all_chats[$key]['receiver_image'] = '';
            }
        }


        $response = [
            'show_all_chat' => $show_all_chat,

            'online_user' => $show_all_chats,

        ];
        return response()->json($response);
    }

    public function delete_chat(Request $request)
    {

        $request->validate([
            'chat_ids' => 'required|array', // Ensure chat_ids is an array
        ]);

        $messageIds = $request->input('chat_ids', []);

        $messageIds = is_array($messageIds) ? array_map('intval', $messageIds) : [];

        $messages = Conversation::whereIn('id', $messageIds)
            ->get();

        $user_id = Auth::user()->id;
        $request_type = $request->input('request_type');

        foreach ($messages as $message) {
            if ($request_type == "delete_for_me") {
                if ($message->sender_id == $user_id) {
                    Conversation::whereIn('id', [$message->id])
                        ->update(['deleted_by_sender' => $user_id]);
                }
                if ($message->receiver_id == $user_id) {
                    Conversation::whereIn('id', [$message->id])
                        ->update(['deleted_by_receiver' => $user_id]);
                }
            } elseif ($request_type == "delete_for_everyone") {
                Conversation::whereIn('id', [$message->id])
                    ->update(['deleted_for_everyone' => 1]);
            }
        }

        return response()->json(['message' => 'Messages Deleted Successfully'], 200);
    }
}
