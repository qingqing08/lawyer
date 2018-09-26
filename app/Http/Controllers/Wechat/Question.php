<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Question extends Controller{
    //

    public function question_list(){
        $question_list = DB::table('question')->get();

        foreach ($question_list as $question){
            $user_info = DB::table('user')->where('u_id' , $question->u_id)->first();
            $question->u_id = $user_info->wx_name;
            $question->wx_headimg = $user_info->wx_headeimg;
            $type = DB::table('type')->where('t_id' , $question->q_type)->first();
            $question->q_type = $type->t_name;
            $question->q_ctime = date("Y-m-d H:i:s" , $question->q_ctime);
        }
        return view('wechat.question.list' , ['question_list'=>$question_list]);
    }
}
