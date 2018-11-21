<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;


class QuestionsController extends Controller
{
    public function questionRequest(Request $request) //请求问题
    {
        // 前端发送 json 'user_id'=>用户id,'token'=>token,'number'=>问题数量
    

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

            $Dimension = 7 ;                //定义维度数目为7
            $Dimension_other =4 ;           //定义非主食问题的维度为4


            $front_two = range(1,$Dimension_other);  //利用range()函数产生一个1到$Dimension_other的数组
            shuffle($front_two);            //利用shuffle()函数将产生的数组随机打乱顺序

            $first_qnum = rand(1,Question::where('attr', $front_two[0])->count());  //获取维度问题数目后，随机该维度下的某个问题
            $first_question = Question::where('attr',$front_two[0])->select('id','content')->offset($first_qnum-1)->limit(1)->first(); 
            //返回问题

            $second_qnum = rand(1,Question::where('attr', $front_two[1])->count()); //获取维度问题数目后，随机该维度下的某个问题
            $second_question = Question::where('attr',$front_two[1])->select('id','content')->offset($second_qnum-1)->limit(1)->first();
            //返回问题

            $third = rand(1,$Dimension-$Dimension_other) + $Dimension_other;

            $third_qnum = rand(1,Question::where('attr', $third)->count()); //获取维度问题数目后，随机该维度下的某个问题
            $third_question = Question::where('attr',$third)->select('id','content')->offset($second_qnum-1)->limit(1)->first();
            //返回问题

            //根据前两个问题序号，调整顺序
            if($first_question->id>$second_question->id)
            {
                $temp = $second_question->id;
                $second_question->id = $first_question->id;
                $first_question->id = $temp ;

                $temp = $second_question->content;
                $second_question->content = $first_question->content;
                $first_question->content = $temp;
            }


            $question_id_list = "$first_question->id,$second_question->id,$third_question->id"; //生成问题id列表

            // 返回question_id_list,三个问题,http 201
            return response()->json([
                'question_id_list' => $question_id_list,
                'content1' => $first_question->content,
                'content2' => $second_question->content,
                'content3' => $third_question->content
            ], 201);
        }
    }
}
