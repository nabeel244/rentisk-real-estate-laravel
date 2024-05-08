<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class MessageToWayController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function sendMessage(Request $request)
    {
     
         $message = new MessageToWay();
        $message->body = $request->body;
        
        // Determine recipient based on user type
        if ($request->user_type == 1) {
            $message->to_user_id = $request->admin_id;
        } else {
            $message->to_user_id = $request->user_id;
        }
        
        $message->from_user_id = auth()->id(); // Assuming the sender is the authenticated user
        $message->save();

        return response()->json(['success' => 'Message sent successfully']);
    }
}
