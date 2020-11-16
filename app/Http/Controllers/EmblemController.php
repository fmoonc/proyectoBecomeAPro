<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmblemController extends Controller
{
    public static function imgUrl($liga)
    {

        switch ($liga) {
            case 'IRON':
                $miliga = 'img/rankeds-emblems/Emblem_Iron.png';
                break;
            case 'BRONZE':
                $miliga = 'img/rankeds-emblems/Emblem_Bronze.png';
                break;
            case 'SILVER':
                $miliga = 'img/rankeds-emblems/Emblem_Silver.png';
                break;
            case 'GOLD':
                $miliga = 'img/rankeds-emblems/Emblem_Gold.png';
                break;
            case 'PLATINUM':
                $miliga = 'img/rankeds-emblems/Emblem_Patinum.png';
                break;
            case 'DIAMOND':
                $miliga = 'img/rankeds-emblems/Emblem_Diamond.png';
                break;
            case 'MASTER':
                $miliga = 'img/rankeds-emblems/Emblem_Master.png';
                break;
            case 'GRANDMASTER':
                $miliga = 'img/rankeds-emblems/Emblem_Grandmaster.png';
                break;
            case 'CHALLENGER':
                $miliga = 'img/rankeds-emblems/Emblem_Challenger.png';
                break;
            case 'unranked':
                $miliga = 'img/rankeds-emblems/default.png';
                break;
        }
        return $miliga;
    }
}