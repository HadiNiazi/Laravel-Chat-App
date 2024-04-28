<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = $request->message;

        // broadcast(new MessageSent);

        try {

            $msg = Message::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message
            ]);

            if ($msg) {

                MessageSent::dispatch($msg->message);

                return response()->json([
                    'msg' => 'Message Sent Successfully'
                ], 201);

            }

        }
        catch(\Exception $ex) {
            return response()->json([
                'error' => 'Something went wrong, The error is: '.$ex->getMessage()
            ]);
        }


    }

}
