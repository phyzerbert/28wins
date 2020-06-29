<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\GameUser;
use App\Models\GameRecord;
use App\Agent;
use App\User;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class RecordAbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'record:abs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ABS Lottery Game Record';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $cur_date = date('d-m-Y');
        $prev_date = date('d-m-Y', strtotime("yesterday"));

        $hour = date('H');
        $minute = date('i');

        if($hour == '00' && $minute <= 20){
            $this->record($prev_date);
        }

        $this->record($cur_date);  
    }

    public function record($bet_date) {
        $game = Game::where('name', 'abs')->first();
        $domain = $game->domain;
        $parent_id = $game->api_key;
        $hash_code = $game->token;
        $post_data = array(
            'lang' => 'en',
            'sessionID' => '7YC0Sxth7AYe4RFSjzaPf2ygLCecJhPbyXhz6vvF',
            'parentID' => $parent_id,
            'hashCode' => $hash_code,
            'command' => 'HITRECORD',
            'params' => [
                'drawdate' => $bet_date,
            ],
        );

        $client = new Client();
        $response = $client->post($domain, [
                        'body' => json_encode($post_data),
                    ]);
        $result = json_decode($response->getBody(), true);
        // dd($result);
        if($result['Success'] == true) {
            $collection = collect($result['Record']);
            $player_array = $collection->pluck('user')->unique()->toArray();
            foreach ($player_array as $player) {
                $game_account = GameUser::where('game_id', $game->id)->where('username', $player)->first();
                if($game_account) {                     
                    $user = $game_account->user;
                    $old_date = explode('-', $bet_date); 
                    $sale_date = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
                    $record = GameRecord::where('bet_date', $sale_date)->where('game_account_id', $game_account->id)->first();
                    $win_lose = $collection->where('user', $player)->sum('totalWin');
                    if($record) {
                        $record->update([
                            'win_lose_amount' => $win_lose,
                        ]);
                    } else {
                        try{
                            DB::transaction(function() use($user, $game, $game_account, $player, $win_lose, $sale_date) {
                                GameRecord::create([
                                    'user_id' => $user->id,
                                    'player' => $user->username,
                                    'game_id' => $game->id,
                                    'agent_id' => $user->agent->id ?? null,
                                    'game_account_id' => $game_account->id,
                                    'username' => $player,
                                    'bet_date' => $sale_date,
                                    'win_lose_amount' => $win_lose,
                                    'currency' => 'MYR',
                                ]);
                            });
                        }catch(\Exception $e){
                            DB::rollback();
                        }
                    }
                }
            }
        }
    }
}
