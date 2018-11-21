<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class StaticPagesController extends Controller
{
    //
    public function home()
    {
        return '主页';
    }
    public function help()
    {
        return '帮助页';
    }
    public function about()
    {
        return '关注页';
    }

    public function importQuestions() // 导入问题
    {
        $file = fopen("questions.csv","r"); // 放在 public 文件夹

        while(!feof($file))
        {
            $data = (fgetcsv($file));
            $question = Question::create([
                'content' => $data[0],
                'choice' => $data[1],
                'attr' => $data[2],
            ]);
        }
        // 注意.csv文件不要有空行。
        fclose($file);
        return 'success';
    }
}
