<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Input\InputOption;

class Medal extends Controller
{
    /**
     * 勋章级别添加
     */
    public function medal_add(){
        return view('admin.medal.medal_add' , ['title'=>'添加勋章级别']);
    }

    /**
     * 执行添加
     */
    public function medal_add_do(){
        $data = Input::post();

        unset($data['_token']);

        $data['m_ctime'] = time();
        $result = DB::table('medal')->insert($data);
        if ($result){
            return ['msg'=>'增加成功' , 'code'=>1];
        } else {
            return ['msg'=>'增加失败' , 'code'=>2];
        }
//        dd($data);
    }

    /**
     * 勋章级别列表
     */
    public function medal_list(){
        $medal_list = DB::table('medal')->paginate(5);

        $count = DB::table('medal')->count();

        foreach ($medal_list as $medal){
            $medal->m_ctime = date('Y-m-d H:i:s' , $medal->m_ctime);
        }
        return view('admin.medal.medal_list' , ['count'=>$count , 'title'=>'勋章级别列表' , 'medal_list'=>$medal_list]);
    }

    /**
     * 勋章级别修改
     */
    public function medal_modify(){
        $m_id = Input::get('m_id');

        $medal_info = DB::table('medal')->where('m_id' , $m_id)->first();
        if (empty($medal_info)){
            echo "非法操作";
        }

        return view('admin.medal.medal_modify' , ['title'=>'修改勋章级别' , 'medal_info'=>$medal_info]);

    }

    /**
     * 执行修改
     */
    public function medal_modify_do(){
        $data = Input::post();

        $m_id = $data['m_id'];
        unset($data['m_id']);
        unset($data['_token']);

        $result = DB::table('medal')->where('m_id' , $m_id)->update($data);

        if ($result){
            return ['msg'=>'修改成功' , 'code'=>1];
        } else {
            return ['msg'=>'修改失败' , 'code'=>2];
        }
    }

    /**
     * 勋章级别删除
     */
    public function medal_delete(){
        $m_id = Input::post('m_id');

        $result = DB::table('medal')->where('m_id' , $m_id)->delete();
        if ($result){
            return ['msg'=>'删除成功' , 'code'=>1];
        } else {
            return ['msg'=>'删除失败' , 'code'=>2];
        }
    }
}
