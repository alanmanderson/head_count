<?php

namespace Alanmanderson\HeadCount\Http\Controllers;

use Illuminate\Http\Request;

class ReplyController extends Controller {
    public function reply(Request $request){
        $user_id = $request->input('id');
        $occurance_id = $request->input('occurance');
        $likelihood = $request->input('likelihood');

    }
}
