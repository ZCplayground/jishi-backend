<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BetaController extends Controller
{
    public function dishRank(){

        
        $what = DB::select('select max(restaurants.name) as restName,max(dishes.name) as dishName,count(finalchoice) as count from restaurants,records, menus,dishes where records.finalchoice = menus.dish_id AND menus.rest_id = restaurants.id AND records.finalChoice = dishes.id group by finalchoice order by count(finalchoice) desc');

        return $what;
    }
    
}
