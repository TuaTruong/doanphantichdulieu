<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use simplehtmldom\HtmlWeb;
use Symfony\Component\HttpClient\HttpClient;

class XoiLacController extends Controller
{
    public function index()
    {
        return view("pages.index");
    }

    public function analyst(Request $request)
    {
        try {
            $match_url = $request->query('url');
            $html = new HtmlWeb();
            $doc = $html->load($match_url);

            // Extract team names and match ID
            $team_home = $doc->find('div.teambox__team-home-name', 0)->plaintext;
            $team_away = $doc->find('div.teambox__team-away-name', 0)->plaintext;
            $match_id = $doc->find('div.team-live', 0)->getAttribute("data-fid");




            // Fetch match statistics
            $client = HttpClient::create();
            $response = $client->request("GET", "https://v1.api-football.xyz/football/match/{$match_id}/statistics")->getContent();
            $statistics = json_decode($response)->data;

            //Fetch time
            $response = $client->request("GET","https://spapi.vbfast.xyz/football/match/{$match_id}/odd");
            // dd($response);
            $data_time = json_decode($response->getContent())->data;

            foreach($data_time as $json_data){
                if($json_data->company_id == 21){
                    $current_time = $json_data->eu->run[1];
                }
            }

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
            'total' => $total,
            'corner_kicks' => $stats->corner_kicks ?? 0,
            'dangerous_attack' => $stats->dangerous_attack ?? 0
        ];
    }
}
