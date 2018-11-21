<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;


class QuestionsController extends Controller
{
    public function questionRequest(Request $request) //请求问题
    {
        // 前端发送 json 'user_id'=>用户id,'token'=>token,'number'=>问题数量
        // 前端返回的应该时id吧？？？？

        $data = $request->getContent();
        $data = json_decode($data, true);

        $ret = checktoken($data['user_id'], $data['token']);
        if($ret === 'iderror')
        {
            // user id 错误。返回http 400
            return response()->json([
                'info' => 'user id does not exist.'
            ], 400);
        }
        else if($ret === 'tokenerror')
        {
            // token 有误。
            return response()->json([
                'info' => 'token error.'
            ], 401);
        }
        else if($ret === 'timeout')
        {
            // token 超时。
            return response()->json([
                'info' => 'token time out.'
            ], 402);
        }
        else if($ret === 'success')
        {
            // token验证成功
            $c = Question::where('id', 1)->select('attr','choice')->first();


            // 成功修改密码。返回http 200
            return response()->json([
                'info' => $c
            ], 200);
        }
    }
}
