<?php

namespace App\Http\Controllers;
use App\Models\Club;
use App\Models\CornerOdd;
use App\Models\League;
use App\Models\Matches;
use App\Models\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use simplehtmldom\HtmlDocument;
use Symfony\Component\HttpClient\HttpClient;
use carbon\carbon;
class XoiLacController extends Controller
{
    public function index()
    {
        return view("pages.index");
    }

    private function get_current_match_time($match_id){
        $client = HttpClient::create();
        $response = $client->request("GET", "https://v1.api-football.xyz/football/match/{$match_id}/statistics")->getContent();
        $statistics = json_decode($response)->data;
        $current_time = null;

        //Fetch time
        $response = $client->request("GET","https://spapi.vbfast.xyz/football/match/{$match_id}/odd");
        $data_time = json_decode($response->getContent())->data;

        foreach($data_time as $json_data){
            if($json_data->company_id == 21){
                $current_time = $json_data->eu->run[1];
            }
        }

        return $current_time;
    }

    public function analyst(Request $request)
    {
        try {
            $match_url = $request->query('url');
            $httpClient = HttpClient::create();
            $ok = $httpClient->request('GET', $match_url);

            $html = new HtmlDocument();
            $doc = $html->load($ok->getContent());
            // Extract team names and match ID
            $team_home = $doc->find('div.teambox__team-home-name', 0)->plaintext;
            $team_away = $doc->find('div.teambox__team-away-name', 0)->plaintext;
            $match_id = $doc->find('div.team-live', 0)->getAttribute("data-fid");

            // Fetch match statistics
            $client = HttpClient::create();
            $response = $client->request("GET", "https://v1.api-football.xyz/football/match/{$match_id}/statistics")->getContent();
            $statistics = json_decode($response)->data;

            //Fetch time
            $current_time = $this->get_current_match_time($match_id);

            // Calculate stats for each half and each team
            $half1_stats = $statistics[0]->stats;
            $half2_stats = $statistics[1]->stats;

            $home_stats_half1 = $this->calculateStats($half1_stats[0]);
            $away_stats_half1 = $this->calculateStats($half1_stats[1]);
            $home_stats_half2 = $this->calculateStats($half2_stats[0]);
            $away_stats_half2 = $this->calculateStats($half2_stats[1]);

            // Get the number of stats indices
            $total_stats_indices = count((array)$half1_stats[0]) - 1;

            return response()->json([
                "success" => true,
                "current_time" => $current_time,
                "team_home" => $team_home,
                "team_away" => $team_away,
                "total_stats_indices" => $total_stats_indices,
                "statistics" => [
                    // Half 1 stats
                    "total_home_stats_half1" => $home_stats_half1['total'],
                    "home_corners_half1" => $home_stats_half1['corner_kicks'],
                    "home_dangerous_attack_half1" => $home_stats_half1['dangerous_attack'],
                    "total_away_stats_half1" => $away_stats_half1['total'],
                    "away_corners_half1" => $away_stats_half1['corner_kicks'],
                    "away_dangerous_attack_half1" => $away_stats_half1['dangerous_attack'],

                    // Half 2 stats
                    "total_home_stats_half2" => $home_stats_half2['total'],
                    "home_corners_half2" => $home_stats_half2['corner_kicks'],
                    "home_dangerous_attack_half2" => $home_stats_half2['dangerous_attack'],
                    "total_away_stats_half2" => $away_stats_half2['total'],
                    "away_corners_half2" => $away_stats_half2['corner_kicks'],
                    "away_dangerous_attack_half2" => $away_stats_half2['dangerous_attack'],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "msg" => $e->getMessage()]);
        }
    }

    public function test_analyst(){
        try {
            $match_url = "https://xoilaczz.cc//truc-tiep/chelsea-vs-nottingham-forest-luc-2000-ngay-06-10-2024/";
            $html = new HtmlDocument();
            $httpClient = HttpClient::create();
            $ok = $httpClient->request('GET', $match_url);
            $doc = $html->load($ok->getContent());
            // Extract team names and match ID
            $team_home = $doc->find('div.teambox__team-home-name', 0)->plaintext;
            $team_away = $doc->find('div.teambox__team-away-name', 0)->plaintext;
            $match_id = $doc->find('div.team-live', 0)->getAttribute("data-fid");

            // Fetch match statistics
            $client = HttpClient::create();
            $response = $client->request("GET", "https://v1.api-football.xyz/football/match/{$match_id}/statistics")->getContent();
            $statistics = json_decode($response)->data;

            //Fetch time
            $current_time = $this->get_current_match_time($match_id);

            // Calculate stats for each half and each team
            $half1_stats = $statistics[0]->stats;
            $half2_stats = $statistics[1]->stats;

            $home_stats_half1 = $this->calculateStats($half1_stats[0]);
            $away_stats_half1 = $this->calculateStats($half1_stats[1]);
            $home_stats_half2 = $this->calculateStats($half2_stats[0]);
            $away_stats_half2 = $this->calculateStats($half2_stats[1]);

            // Get the number of stats indices
            $total_stats_indices = count((array)$half1_stats[0]) - 1;

            return response()->json([
                "success" => true,
                "current_time" => $current_time,
                "team_home" => $team_home,
                "team_away" => $team_away,
                "total_stats_indices" => $total_stats_indices,
                "statistics" => [
                    // Half 1 stats
                    "total_home_stats_half1" => $home_stats_half1['total'],
                    "home_corners_half1" => $home_stats_half1['corner_kicks'],
                    "home_dangerous_attack_half1" => $home_stats_half1['dangerous_attack'],
                    "total_away_stats_half1" => $away_stats_half1['total'],
                    "away_corners_half1" => $away_stats_half1['corner_kicks'],
                    "away_dangerous_attack_half1" => $away_stats_half1['dangerous_attack'],

                    // Half 2 stats
                    "total_home_stats_half2" => $home_stats_half2['total'],
                    "home_corners_half2" => $home_stats_half2['corner_kicks'],
                    "home_dangerous_attack_half2" => $home_stats_half2['dangerous_attack'],
                    "total_away_stats_half2" => $away_stats_half2['total'],
                    "away_corners_half2" => $away_stats_half2['corner_kicks'],
                    "away_dangerous_attack_half2" => $away_stats_half2['dangerous_attack'],
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(["success" => false, "msg" => $e->getMessage()]);
        }
    }

    private function calculateStats($stats)
    {
        $total = 0;
        foreach ($stats as $key => $value) {
            if (is_int($value)) {
                $total += $value;
            }
        }

        return [
            "total" => $total,
            "shots_off_target" =>$stats->shots_off_target ?? 0,
            "goals" => $stats->goals ?? 0,
            "penalty" => $stats->penalty ?? 0,
            "assists" => $stats->assists ?? 0,
            "red_cards" => $stats->red_cards ?? 0,
            "yellow_cards" => $stats->yellow_cards ?? 0,
            "shots" => $stats->shots ?? 0,
            "shots_on_target" => $stats->shots_on_target ?? 0,
            "dribble" => $stats->dribble ?? 0,
            "dribble_succ" => $stats->dribble_succ ?? 0,
            "clearances" => $stats->clearances ?? 0,
            "blocked_shots" => $stats->blocked_shots ?? 0,
            "interceptions" => $stats->interceptions ?? 0,
            "tackles" => $stats->tackles ?? 0,
            "passes" => $stats->passes ?? 0,
            "passes_accuracy" => $stats->passes_accuracy ?? 0,
            "key_passes" => $stats->key_passes ?? 0,
            "crosses" => $stats->crosses ?? 0,
            "crosses_accuracy" => $stats->crosses_accuracy ?? 0,
            "long_balls" => $stats->long_ball ?? 0,
            "long_balls_accuracy" => $stats->long_balls_accuracy ?? 0,
            "duels" => $stats->duels ?? 0,
            "duels_won" => $stats->duels_won ?? 0,
            "fouls" => $stats->fouls ?? 0,
            "was_fouled" => $stats->was_fouled ?? 0,
            "goal_against" => $stats->goal_against ?? 0,
            "offsides"=>$stats->offsides ?? 0,
            "yellow2red_cards" => $stats->yellow2red_cards ?? 0,
            'corner_kicks' => $stats->corner_kicks ?? 0,
            'dangerous_attack' => $stats->dangerous_attack ?? 0,
            "ball_possession" => $stats->ball_possession ?? 0,
            "attacks" => $stats->attacks ?? 0,
            "freekicks" => $stats->freekicks ?? 0,
            "freekick_goals" => $stats->freekick_goals ?? 0,
            "hit_woodwork" => $stats->hit_woodwork ?? 0,
            "fastbreaks" => $stats->fastbreaks ?? 0,
            "fastbreak_shots" => $stats->fastbreak_shots ?? 0,
            "fastbreak_goals" => $stats->fastbreak_goals??0,
            "poss_losts" => $stats->poss_losts ?? 0,
        ];
    }


    public function fetchAll(){
        $main_bet_company_id = 21;
        $client = HttpClient::create();
        $response = $client->request("GET", "https://xoilaczz.cc/sport/football/load-more/home/page/0/per/100")->getContent();
        $statistics = json_decode($response)->data->html;
        $html = new HtmlDocument();
        $docs = $html->load($statistics);
        foreach ($html->find("div.grid-matches__item") as $card_container){
            try{
                $card_container = $html->find("div.grid-matches__item",0);
                $league =  $card_container->find("div.grid-match__league")[0]->plaintext;
                $team_home = $card_container->find("span.grid-match__team--name.grid-match__team--home-name")[0]->plaintext;
                $team_away = $card_container->find("span.grid-match__team--name.grid-match__team--away-name")[0]->plaintext;
                $start_time = $card_container->find("div.grid-match__date")[0]->plaintext;
                $start_time_convert = Carbon::createFromFormat('H:i d.m', $start_time)->format('d/m/Y H:i');
                $match_id = "4wyrn4hxo7xoq86";

                $response = $client->request("GET","https://spapi.vbfast.xyz/football/match/{$match_id}/odd");
                if ($response->getStatusCode() != 200){continue;}
                $data_bet = json_decode($response->getContent())->data;
                if(count($data_bet) >0 ){
                    foreach ($data_bet as $data) {
                        if ($data->company_id == $main_bet_company_id) {
                            try {
                                $response = $client->request("GET", "https://v1.api-football.xyz/football/match/{$match_id}/statistics")->getContent();
                                $statistics = json_decode($response)->data[1]->stats;
                                $home_stats = $this->calculateStats($statistics[0]);
                                $away_stats = $this->calculateStats($statistics[1]);
                                dd($home_stats, $away_stats);

                            } catch (\Exception $e) {
                                dd($e->getMessage());
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                continue;
            }
        }
    }

    public function test_save_data()
    {
        $current_minute = 4;
        $firstHalfBet = 3.5;
        $fullTimeBet = 8.5;
        $team_home_input = "Gwangju FC";
        $team_away_input = "Johor Darul Takzim";


        for($i = 0; $i<=2;$i++){
            $response = Http::get("https://xoilacz.co/sport/football/load-more/home/page/".(string)$i."/per/100");
            $pageSource = json_decode($response->body())->data->html;
            $html = new HtmlDocument();
            $docs = $html->load($pageSource);
            foreach ($docs->find("div.grid-matches__item") as $card_container) {
                try {
                    $league_name = $card_container->find("div.grid-match__league",0)->plaintext;
                    $team_home_name = $card_container->find("span.grid-match__team--name.grid-match__team--home-name")[0]->plaintext;
                    $team_away_name = $card_container->find("span.grid-match__team--name.grid-match__team--away-name")[0]->plaintext;
                    $start_time = $card_container->find("div.grid-match__date")[0]->plaintext;
                    $start_time_convert = Carbon::createFromFormat('H:i d.m', $start_time)->format('Y-m-d H:i:s');
                    $match_id = $card_container->getAttribute("data-fid");
                    $check_teams_name = (strtolower($team_home_name) == strtolower($team_home_input) || strtolower($team_home_name) == strtolower($team_away_input)) || (strtolower($team_away_name) == strtolower($team_away_input) || strtolower($team_away_name) == strtolower($team_home_input));

                    if($check_teams_name){
                        try {
                            # Tạo đội bóng và giải đấu, liên kết các dữ liệu với nhau
                            $league = League::firstOrCreate([
                                'name'=>$league_name,
                            ]);
                            $team_home = Club::firstOrCreate([
                                "name" => $team_home_input,
                            ]);
                            $team_away = Club::firstOrCreate([
                                "name" => $team_away_input
                            ]);
                            if (!$team_home->leagues()->where('league_id', $league->id)->exists()) {
                                $team_home->leagues()->attach($league->id);
                            }
                            if (!$team_away->leagues()->where('league_id', $league->id)->exists()) {
                                $team_away->leagues()->attach($league->id);
                            }
                            if (!$league->clubs()->where('club_id', $team_home->id)->exists()) {
                                $league->clubs()->attach($team_home->id);
                            }
                            if (!$league->clubs()->where('club_id', $team_away->id)->exists()) {
                                $league->clubs()->attach($team_away->id);
                            }

                            $match = Matches::firstOrCreate([
                                "league_id" => $league->id,
                                "start_time" => $start_time_convert,
                                "team_home_id" => $team_home->id,
                                "team_away_id" => $team_away->id,
                            ]);

                            $statistics_response = Http::get("https://v1.api-football.xyz/football/match/{$match_id}/statistics");
                            $statistics_data = json_decode($statistics_response->body())->data[1]->stats;

                            $statistics_home = Statistic::where("match_id", $match->id)->where("club_id",$team_home->id)->where("minute",$current_minute)->first();
                            if(!$statistics_home){
                                Statistic::create([
                                        "match_id" => $match->id,
                                        "club_id" => $team_home->id,
                                        "minute" => $current_minute,
                                        "league_id" => $league->id,
                                    ]+$this->calculateStats($statistics_data[0]));
                            }

                            $statistics_away = Statistic::where("match_id", $match->id)->where("club_id",$team_away->id)->where("minute",$current_minute)->first();
                            if(!$statistics_away){
                                Statistic::create([
                                        "match_id" => $match->id,
                                        "club_id" => $team_away->id,
                                        "minute" => $current_minute,
                                        "league_id" => $league->id,
                                    ]+$this->calculateStats($statistics_data[1]));
                            }

                            $corner_odd = CornerOdd::where("minute",$current_minute)->where("match_id",$match->id)->first();
                            if(!$corner_odd){
                                CornerOdd::create([
                                    "match_id" => $match->id,
                                    "minute" => $current_minute,
                                    "league_id" => $league->id,
                                    "half_1_bet_point"=>$firstHalfBet,
                                    "full_time_bet_point"=>$fullTimeBet,
                                ]);
                            }

                            return response()->json(["success" => true]);
                        } catch (\Exception $e) {
                            return response()->json(["success" => false,"msg" => $e->getMessage()]);
                        }
                    }
                } catch (\Exception $e){
//                    return response()->json(["success" => false,"msg" => $e->getMessage()]);
                }
            }
        }
        return response()->json(["success" => false]);
    }

    public function save_data(Request $request){
        $current_minute = $request->input("minute");
        $firstHalfBet = $request->input("firstHalfBet");
        $fullTimeBet = $request->input("fullTimeBet");
        if(!$request->input("firstHalfBet")){
            $firstHalfBet = CornerOdd::latest()?->first()?->half_1_bet_point;
        }
        if(!$request->input("fullTimeBet")){
            $fullTimeBet = CornerOdd::latest()?->first()?->full_time_bet_point;
        }

        for($i = 0; $i<=2;$i++){
            $response = Http::get("https://xoilacz.co/sport/football/load-more/home/page/".(string)$i."/per/100");
            $pageSource = json_decode($response->body())->data->html;
            $html = new HtmlDocument();
            $docs = $html->load($pageSource);
            foreach ($docs->find("div.grid-matches__item") as $card_container) {
                try {
                    $league_name = $card_container->find("div.grid-match__league",0)->plaintext;
                    $team_home_name = $card_container->find("span.grid-match__team--name.grid-match__team--home-name")[0]->plaintext;
                    $team_away_name = $card_container->find("span.grid-match__team--name.grid-match__team--away-name")[0]->plaintext;
                    $start_time = $card_container->find("div.grid-match__date")[0]->plaintext;
                    $start_time_convert = Carbon::createFromFormat('H:i d.m', $start_time)->format('Y-m-d H:i:s');
                    $match_id = $card_container->getAttribute("data-fid");
                    $check_teams_name = (strtolower($team_home_name) == strtolower($request->input("team_home")) || strtolower($team_home_name) == strtolower($request->input('team_away'))) || (strtolower($team_away_name) == strtolower($request->input('team_away')) || strtolower($team_away_name) == strtolower($request->input("team_home")));

                    if($check_teams_name){
                        try {
                            # Tạo đội bóng và giải đấu, liên kết các dữ liệu với nhau
                            $league = League::firstOrCreate([
                                'name'=>$league_name,
                            ]);
                            $team_home = Club::firstOrCreate([
                                "name" => $request->input("team_home")
                            ]);
                            $team_away = Club::firstOrCreate([
                                "name" => $request->input("team_away")
                            ]);
                            if (!$team_home->leagues()->where('league_id', $league->id)->exists()) {
                                $team_home->leagues()->attach($league->id);
                            }
                            if (!$team_away->leagues()->where('league_id', $league->id)->exists()) {
                                $team_away->leagues()->attach($league->id);
                            }
                            if (!$league->clubs()->where('club_id', $team_home->id)->exists()) {
                                $league->clubs()->attach($team_home->id);
                            }
                            if (!$league->clubs()->where('club_id', $team_away->id)->exists()) {
                                $league->clubs()->attach($team_away->id);
                            }

                            $match = Matches::firstOrCreate([
                                "league_id" => $league->id,
                                "start_time" => $start_time_convert,
                                "team_home_id" => $team_home->id,
                                "team_away_id" => $team_away->id,
                            ]);

                            $statistics_response = Http::get("https://v1.api-football.xyz/football/match/{$match_id}/statistics");
                            try{
                                $statistics_data = json_decode($statistics_response->body())->data[2]->stats;
                            } catch (\Exception $e) {
                                $statistics_data = json_decode($statistics_response->body())->data[1]->stats;
                            }


                            $statistics_home = Statistic::where("match_id", $match->id)->where("club_id",$team_home->id)->where("minute",$current_minute)->first();
                            if(!$statistics_home){
                                Statistic::create([
                                    "match_id" => $match->id,
                                    "club_id" => $team_home->id,
                                    "minute" => $current_minute,
                                    "league_id" => $league->id,
                                ]+$this->calculateStats($statistics_data[0]));
                            }

                            $statistics_away = Statistic::where("match_id", $match->id)->where("club_id",$team_away->id)->where("minute",$current_minute)->first();
                            if(!$statistics_away){
                                Statistic::create([
                                    "match_id" => $match->id,
                                    "club_id" => $team_away->id,
                                    "minute" => $current_minute,
                                    "league_id" => $league->id,
                                ]+$this->calculateStats($statistics_data[1]));
                            }

                            $corner_odd = CornerOdd::where("minute",$current_minute)->where("match_id",$match->id)->first();
                            if(!$corner_odd){
                                CornerOdd::create([
                                    "match_id" => $match->id,
                                    "minute" => $current_minute,
                                    "league_id" => $league->id,
                                    "half_1_bet_point"=>$firstHalfBet,
                                    "full_time_bet_point"=>$fullTimeBet,
                                ]);
                            }

                            return response()->json(["success" => true]);
                        } catch (\Exception $e) {
                        }
                    }
                } catch (\Exception $e){
                }
            }
        }
        return response()->json(["success" => false]);
    }

    public function matchChart(){
        return view('pages.match-chart');
    }

    public function matchStatistic(Request $request, string $matchId){
        $match = Matches::find($matchId);
        return view('pages.match-chart',compact('match'));
    }

    public function getMatchStatistic(Request $request)
    {
        $match = Matches::find($request->input("matchId"));
        $minuteSplit = $request->input("minuteSplit");

        $matchStatistic = $match->statistics;
        $team_home = Club::find($matchStatistic[0]->club_id);
        $team_away = Club::find($matchStatistic[1]->club_id);
        $leagueName = $match->league->name;
        $minutesArray = $match->statistics()->whereRaw("minute % {$minuteSplit} = 0")->distinct()->pluck('minute')->toArray();
        $cornerOddArrayHalf1 = $match->cornerOdd()->whereRaw("minute % {$minuteSplit} = 0")->pluck('half_1_bet_point')->toArray();
        $cornerOddArrayFullTime = $match->cornerOdd()->whereRaw("minute % {$minuteSplit} = 0")->pluck('full_time_bet_point')->toArray();
        $totalStatisticHome = $match->statistics()->whereRaw("minute % {$minuteSplit} = 0")->where("club_id",$team_home->id)->pluck('total')->toArray();
        $totalStatisticAway = $match->statistics()->whereRaw("minute % {$minuteSplit} = 0")->where("club_id",$team_away->id)->pluck('total')->toArray();
        for ($i = 0; $i < count($totalStatisticHome); $i++) {
            $totalStatisticBoth[] = $totalStatisticHome[$i] + $totalStatisticAway[$i];
        }

        $differences = [0];
        for ($i = 0; $i < count($totalStatisticBoth) - 1; $i++) {
            $differences[] = $totalStatisticBoth[$i + 1] - $totalStatisticBoth[$i];
        }

        return response()->json([
            'differences' => $differences,
            "team_home" => $team_home->name,
            "team_away" => $team_away->name,
            "league_name" => $leagueName,
            "minutesArray" => $minutesArray,
            "cornerOddHalf1" => $cornerOddArrayHalf1,
            "cornerOddArrayFullTime" => $cornerOddArrayFullTime,
            "totalStatisticHome" => $totalStatisticHome,
            "totalStatisticAway" => $totalStatisticAway,
            "totalStatisticBoth" => $totalStatisticBoth,
        ]);
    }

    public function allMatches(){
        $allMatches = Matches::orderBy('start_time','desc')->get();
        return view('pages.all-matches', compact('allMatches'));
    }

    public function testMatchStatistic(Request $request)
    {
        $match = Matches::find(1);
        $minutes = $match->statistics()->pluck("minute")->toArray();
        dd($minutes);
    }

    public function testLink()
    {
        $response = Http::get("https://xoilacz.co/sport/football/load-more/home/page/0/per/100");
        $pageSource = json_decode($response->body())->data->html;
        dd($pageSource);
    }
}
