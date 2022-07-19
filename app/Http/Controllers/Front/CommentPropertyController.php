<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Model\Comment;
use Illuminate\Http\Request;

class CommentPropertyController extends Controller
{
    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = auth()->user()->id;

        $res =Comment::create($input);
        $res->save();
        return response()->json(['status'=>true,]);
    }
}
