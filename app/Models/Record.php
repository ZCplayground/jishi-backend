<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
	protected $fillable = [
        'id','user_id','question_id_list','answer_list','dish_id_list','finalchoice',
    ];
	
    protected $guarded = [];
}
