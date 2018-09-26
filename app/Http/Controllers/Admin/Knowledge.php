<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class Knowledge extends Controller
{
    /**
     * 法律常识添加
     */
    public function knowledge_add(){

        $type = DB::table('type') -> get();

        return view('admin.knowledge.knowledge_add' , ['type' => $type , 'title' => '法律常识添加']);
    }

    /**
     * 执行添加
     */
    public function knowledge_add_do(Request $request){

        $arr['t_id'] = $request -> post('t_id');
        $arr['k_title'] = $request -> post('k_title');
        $arr['k_content'] = $request -> post('k_content');
        $arr['k_from'] = $request -> post('k_from');
        $arr['k_ctime'] = time();

        $res = DB::table('knowledge') -> insert($arr);

        if($res){
            return ['code' => 1 , 'msg' => '增加成功'];
        }else{
            return ['code' => 2 , 'msg' => '增加失败'];
        }
    }

    /**
     * 法律常识列表
     */
    public function knowledge_list(){

        $knowledge = DB::table('knowledge') -> paginate('5');

        $count = count($knowledge);

        return view('admin.knowledge.knowledge_list' , ['title' => '法律常识' , 'knowledge' => $knowledge , 'count' => $count]);
    }

    /**
     * 法律常识修改
     */
    public function knowledge_modify(Request $request){

        $k_id = $request -> get('k_id');

        $knowledge = DB::table('knowledge') -> where(['k_id' => $k_id]) -> first();

        $type = DB::table('type') -> get();

        return view('admin.knowledge.knowledge_modify' , ['title' => '法律常识编辑' , 'knowledge' => $knowledge , 'type' => $type]);

    }

    /**
     * 执行修改
     */
    public function knowledge_modify_do(Request $request){

        $k_id = $request -> post('k_id');
        $arr['t_id'] = $request -> post('t_id');
        $arr['k_title'] = $request -> post('k_title');
        $arr['k_content'] = $request -> post('k_content');
        $arr['k_from'] = $request -> post('k_from');

        $res = DB::table('knowledge') -> where(['k_id' => $k_id]) -> update($arr);

        if($res){
            return (['code' => 1 , 'msg' => '编辑成功'] );
        }else{
            return (['code' => 2 , 'msg' => '编辑失败']);
        }
    }

    /**
     * 法律常识删除
     */
    public function  knowledge_delete(){

    }
}
