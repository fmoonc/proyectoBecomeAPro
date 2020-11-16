<?php

namespace App\Http\Controllers;

use App\Models\Cuenta;
use App\Http\Controllers\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class CuentaController extends Controller
{
    /**
     * No permito acceder a usuarios no registrados
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $cuenta = Cuenta::where('user_id', auth()->id())->get();

            return $cuenta;
        } else {
            return redirect()->route('user');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('cuenta.vincularCuenta');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->ajax()) {

            /*$request->validate([
            'summoner_name' => 'required',
            'region' => 'required'
        ]);*/
            $cuenta = new Cuenta();
            $apiKey = KeyController::getApiKey();

            //transformar espacios en blanco por %20
            $summonerName = $request->summoner_name;
            $cadena = str_replace(" ", "%20", $summonerName);


            //transformar a minusculas
            $lugar = strtolower($request->region);

            //respuesta de SUMMONER-V4 -> get summoner by summoner name 2º opcion
            $respuesta = Http::get('https://' . $lugar . '.api.riotgames.com/lol/summoner/v4/summoners/by-name/' . $cadena . '?api_key=' . $apiKey);

            $respuestajson = $respuesta->json();

            //respuesta de LEAGUE-V4 -> get league entries in all queues for a given summoner ID 2º opcion
            $respuesta2 = Http::get('https://' . $lugar . '.api.riotgames.com/lol/league/v4/entries/by-summoner/' . $respuestajson['id'] . '?api_key=' . $apiKey);
            /*if ($respuesta2->status() != 200) {
            return back()->with('invocador', 'Este usuario no ha jugado partidas competitivas');
        }*/

            $respuestajson2 = $respuesta2->json();

            if (count($respuestajson2) == 1) {
                if ($respuestajson2[0]['queueType'] == 'RANKED_SOLO_5x5') {
                    $cuenta->user_id = auth()->id();
                    $cuenta->summoner_name = $cadena;
                    $cuenta->region = $lugar;
                    $cuenta->summoner_id = $respuestajson['id'];
                    $cuenta->account_id = $respuestajson['accountId'];
                    $cuenta->puuid = $respuestajson['puuid'];
                    $cuenta->level = $respuestajson['summonerLevel'];
                    //Duo
                    $cuenta->id_duo = $respuestajson2[0]['leagueId'];
                    $cuenta->tier_duo = $respuestajson2[0]['tier'];
                    $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                    $cuenta->rank_duo = $respuestajson2[0]['rank'];
                    $cuenta->league_points_duo = $respuestajson2[0]['leaguePoints'];
                    $cuenta->wins_duo = $respuestajson2[0]['wins'];
                    $cuenta->losses_duo = $respuestajson2[0]['losses'];
                    //Flex
                    $cuenta->id_flex = 'unranked';
                    $cuenta->tier_flex = 'unranked';
                    $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                    $cuenta->rank_flex = 'unranked';
                    $cuenta->league_points_flex = 0;
                    $cuenta->wins_flex = 0;
                    $cuenta->losses_flex = 0;
                } else if ($respuestajson2[0]['queueType'] == 'RANKED_FLEX_SR') {
                    $cuenta->user_id = auth()->id();
                    $cuenta->summoner_name = $cadena;
                    $cuenta->region = $lugar;
                    $cuenta->summoner_id = $respuestajson['id'];
                    $cuenta->account_id = $respuestajson['accountId'];
                    $cuenta->puuid = $respuestajson['puuid'];
                    $cuenta->level = $respuestajson['summonerLevel'];
                    //Duo
                    $cuenta->id_duo = 'unranked';
                    $cuenta->tier_duo = 'unranked';
                    $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                    $cuenta->rank_duo = 'unranked';
                    $cuenta->league_points_duo = 0;
                    $cuenta->wins_duo = 0;
                    $cuenta->losses_duo = 0;
                    //Flex
                    $cuenta->id_flex = $respuestajson2[0]['leagueId'];
                    $cuenta->tier_flex = $respuestajson2[0]['tier'];
                    $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                    $cuenta->rank_flex = $respuestajson2[0]['rank'];
                    $cuenta->league_points_flex = $respuestajson2[0]['leaguePoints'];
                    $cuenta->wins_flex = $respuestajson2[0]['wins'];
                    $cuenta->losses_flex = $respuestajson2[0]['losses'];
                    dd($cuenta);
                }
            } else if (count($respuestajson2) == 0) {
                $cuenta->user_id = auth()->id();
                $cuenta->summoner_name = $cadena;
                $cuenta->region = $lugar;
                $cuenta->summoner_id = $respuestajson['id'];
                $cuenta->account_id = $respuestajson['accountId'];
                $cuenta->puuid = $respuestajson['puuid'];
                $cuenta->level = $respuestajson['summonerLevel'];
                //Flex
                $cuenta->id_flex = "unranked";
                $cuenta->tier_flex = "unranked";
                $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                $cuenta->rank_flex = "unranked";
                $cuenta->league_points_flex = 0;
                $cuenta->wins_flex = 0;
                $cuenta->losses_flex = 0;

                //Duo
                $cuenta->id_duo = "unranked";
                $cuenta->tier_duo = "unranked";
                $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                $cuenta->rank_duo = "unranked";
                $cuenta->league_points_duo = 0;
                $cuenta->wins_duo = 0;
                $cuenta->losses_duo = 0;
            } else if (count($respuestajson2) == 2) {
                if ($respuestajson2[0]['queueType'] == 'RANKED_FLEX_SR') {

                    $cuenta->user_id = auth()->id();
                    $cuenta->summoner_name = $cadena;
                    $cuenta->region = $lugar;
                    $cuenta->summoner_id = $respuestajson['id'];
                    $cuenta->account_id = $respuestajson['accountId'];
                    $cuenta->puuid = $respuestajson['puuid'];
                    $cuenta->level = $respuestajson['summonerLevel'];

                    //Flex
                    $cuenta->id_flex = $respuestajson2[0]['leagueId'];
                    $cuenta->tier_flex = $respuestajson2[0]['tier'];
                    $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                    $cuenta->rank_flex = $respuestajson2[0]['rank'];
                    $cuenta->league_points_flex = $respuestajson2[0]['leaguePoints'];
                    $cuenta->wins_flex = $respuestajson2[0]['wins'];
                    $cuenta->losses_flex = $respuestajson2[0]['losses'];

                    //Duo
                    $cuenta->id_duo = $respuestajson2[1]['leagueId'];
                    $cuenta->tier_duo = $respuestajson2[1]['tier'];
                    $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                    $cuenta->rank_duo = $respuestajson2[1]['rank'];
                    $cuenta->league_points_duo = $respuestajson2[1]['leaguePoints'];
                    $cuenta->wins_duo = $respuestajson2[1]['wins'];
                    $cuenta->losses_duo = $respuestajson2[1]['losses'];
                } else if ($respuestajson2[0]['queueType'] == 'RANKED_SOLO_5x5') {
                    $cuenta->user_id = auth()->id();
                    $cuenta->summoner_name = $cadena;
                    $cuenta->region = $lugar;
                    $cuenta->summoner_id = $respuestajson['id'];
                    $cuenta->account_id = $respuestajson['accountId'];
                    $cuenta->puuid = $respuestajson['puuid'];
                    $cuenta->level = $respuestajson['summonerLevel'];

                    //Flex
                    $cuenta->id_flex = $respuestajson2[1]['leagueId'];
                    $cuenta->tier_flex = $respuestajson2[1]['tier'];
                    $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                    $cuenta->rank_flex = $respuestajson2[1]['rank'];
                    $cuenta->league_points_flex = $respuestajson2[1]['leaguePoints'];
                    $cuenta->wins_flex = $respuestajson2[1]['wins'];
                    $cuenta->losses_flex = $respuestajson2[1]['losses'];

                    //Duo
                    $cuenta->id_duo = $respuestajson2[0]['leagueId'];
                    $cuenta->tier_duo = $respuestajson2[0]['tier'];
                    $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                    $cuenta->rank_duo = $respuestajson2[0]['rank'];
                    $cuenta->league_points_duo = $respuestajson2[0]['leaguePoints'];
                    $cuenta->wins_duo = $respuestajson2[0]['wins'];
                    $cuenta->losses_duo = $respuestajson2[0]['losses'];
                }
            }
            $cuenta->save();
            return $cuenta;
        } else {
            return redirect()->route('user');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function show(Cuenta $cuenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuenta $cuenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $cuenta = Cuenta::find($id);
        $apiKey = KeyController::getApiKey();
        $cadena = $cuenta['summoner_name'];


        //transformar a minusculas
        $lugar = $cuenta['region'];

        //respuesta de SUMMONER-V4 -> get summoner by summoner name 2º opcion
        $respuesta = Http::get('https://' . $lugar . '.api.riotgames.com/lol/summoner/v4/summoners/by-name/' . $cadena . '?api_key=' . $apiKey);
        $respuestajson = $respuesta->json();

        //respuesta de LEAGUE-V4 -> get league entries in all queues for a given summoner ID 2º opcion
        $respuesta2 = Http::get('https://' . $lugar . '.api.riotgames.com/lol/league/v4/entries/by-summoner/' . $respuestajson['id'] . '?api_key=' . $apiKey);
        $respuestajson2 = $respuesta2->json();

        if (count($respuestajson2) == 1) {
            if ($respuestajson2[0]['queueType'] == 'RANKED_SOLO_5x5') {
                $cuenta->user_id = auth()->id();
                $cuenta->summoner_name = $cadena;
                $cuenta->region = $lugar;
                $cuenta->summoner_id = $respuestajson['id'];
                $cuenta->account_id = $respuestajson['accountId'];
                $cuenta->puuid = $respuestajson['puuid'];
                $cuenta->level = $respuestajson['summonerLevel'];
                //Duo
                $cuenta->id_duo = $respuestajson2[0]['leagueId'];
                $cuenta->tier_duo = $respuestajson2[0]['tier'];
                $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                $cuenta->rank_duo = $respuestajson2[0]['rank'];
                $cuenta->league_points_duo = $respuestajson2[0]['leaguePoints'];
                $cuenta->wins_duo = $respuestajson2[0]['wins'];
                $cuenta->losses_duo = $respuestajson2[0]['losses'];
                //Flex
                $cuenta->id_flex = 'unranked';
                $cuenta->tier_flex = 'unranked';
                $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                $cuenta->rank_flex = 'unranked';
                $cuenta->league_points_flex = 0;
                $cuenta->wins_flex = 0;
                $cuenta->losses_flex = 0;
            } else if ($respuestajson2[0]['queueType'] == 'RANKED_FLEX_SR') {
                $cuenta->user_id = auth()->id();
                $cuenta->summoner_name = $cadena;
                $cuenta->region = $lugar;
                $cuenta->summoner_id = $respuestajson['id'];
                $cuenta->account_id = $respuestajson['accountId'];
                $cuenta->puuid = $respuestajson['puuid'];
                $cuenta->level = $respuestajson['summonerLevel'];
                //Duo
                $cuenta->id_duo = 'unranked';
                $cuenta->tier_duo = 'unranked';
                $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                $cuenta->rank_duo = 'unranked';
                $cuenta->league_points_duo = 0;
                $cuenta->wins_duo = 0;
                $cuenta->losses_duo = 0;
                //Flex
                $cuenta->id_flex = $respuestajson2[0]['leagueId'];
                $cuenta->tier_flex = $respuestajson2[0]['tier'];
                $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                $cuenta->rank_flex = $respuestajson2[0]['rank'];
                $cuenta->league_points_flex = $respuestajson2[0]['leaguePoints'];
                $cuenta->wins_flex = $respuestajson2[0]['wins'];
                $cuenta->losses_flex = $respuestajson2[0]['losses'];
                dd($cuenta);
            }
        } else if (count($respuestajson2) == 0) {
            $cuenta->user_id = auth()->id();
            $cuenta->summoner_name = $cadena;
            $cuenta->region = $lugar;
            $cuenta->summoner_id = $respuestajson['id'];
            $cuenta->account_id = $respuestajson['accountId'];
            $cuenta->puuid = $respuestajson['puuid'];
            $cuenta->level = $respuestajson['summonerLevel'];
            //Flex
            $cuenta->id_flex = "unranked";
            $cuenta->tier_flex = "unranked";
            $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
            $cuenta->rank_flex = "unranked";
            $cuenta->league_points_flex = 0;
            $cuenta->wins_flex = 0;
            $cuenta->losses_flex = 0;

            //Duo
            $cuenta->id_duo = "unranked";
            $cuenta->tier_duo = "unranked";
            $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
            $cuenta->rank_duo = "unranked";
            $cuenta->league_points_duo = 0;
            $cuenta->wins_duo = 0;
            $cuenta->losses_duo = 0;
        } else if (count($respuestajson2) == 2) {
            if ($respuestajson2[0]['queueType'] == 'RANKED_FLEX_SR') {

                $cuenta->user_id = auth()->id();
                $cuenta->summoner_name = $cadena;
                $cuenta->region = $lugar;
                $cuenta->summoner_id = $respuestajson['id'];
                $cuenta->account_id = $respuestajson['accountId'];
                $cuenta->puuid = $respuestajson['puuid'];
                $cuenta->level = $respuestajson['summonerLevel'];

                //Flex
                $cuenta->id_flex = $respuestajson2[0]['leagueId'];
                $cuenta->tier_flex = $respuestajson2[0]['tier'];
                $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                $cuenta->rank_flex = $respuestajson2[0]['rank'];
                $cuenta->league_points_flex = $respuestajson2[0]['leaguePoints'];
                $cuenta->wins_flex = $respuestajson2[0]['wins'];
                $cuenta->losses_flex = $respuestajson2[0]['losses'];

                //Duo
                $cuenta->id_duo = $respuestajson2[1]['leagueId'];
                $cuenta->tier_duo = $respuestajson2[1]['tier'];
                $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                $cuenta->rank_duo = $respuestajson2[1]['rank'];
                $cuenta->league_points_duo = $respuestajson2[1]['leaguePoints'];
                $cuenta->wins_duo = $respuestajson2[1]['wins'];
                $cuenta->losses_duo = $respuestajson2[1]['losses'];
            } else if ($respuestajson2[0]['queueType'] == 'RANKED_SOLO_5x5') {
                $cuenta->user_id = auth()->id();
                $cuenta->summoner_name = $cadena;
                $cuenta->region = $lugar;
                $cuenta->summoner_id = $respuestajson['id'];
                $cuenta->account_id = $respuestajson['accountId'];
                $cuenta->puuid = $respuestajson['puuid'];
                $cuenta->level = $respuestajson['summonerLevel'];

                //Flex
                $cuenta->id_flex = $respuestajson2[1]['leagueId'];
                $cuenta->tier_flex = $respuestajson2[1]['tier'];
                $cuenta->img_flex = EmblemController::imgUrl($cuenta->tier_flex);
                $cuenta->rank_flex = $respuestajson2[1]['rank'];
                $cuenta->league_points_flex = $respuestajson2[1]['leaguePoints'];
                $cuenta->wins_flex = $respuestajson2[1]['wins'];
                $cuenta->losses_flex = $respuestajson2[1]['losses'];

                //Duo
                $cuenta->id_duo = $respuestajson2[0]['leagueId'];
                $cuenta->tier_duo = $respuestajson2[0]['tier'];
                $cuenta->img_duo = EmblemController::imgUrl($cuenta->tier_duo);
                $cuenta->rank_duo = $respuestajson2[0]['rank'];
                $cuenta->league_points_duo = $respuestajson2[0]['leaguePoints'];
                $cuenta->wins_duo = $respuestajson2[0]['wins'];
                $cuenta->losses_duo = $respuestajson2[0]['losses'];
            }
        }
        $cuenta->save();
        return $cuenta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuenta  $cuenta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cuenta = Cuenta::find($id);
        $cuenta->delete();
    }
}