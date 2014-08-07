<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class jsonemail extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'command:jsonmail';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Gets JSON and sends emails';

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
	public function fire()
	{
		NextDay::truncate();
		$date = date('m-d-Y', time());
		$array = ["Earhart", "Ford", "Hillenbrand", "Wiley", "Windsor"];
		foreach($array as $hall) {
			$url = "http://api.hfs.purdue.edu/menus/v2/locations/". $hall . "/".$date."";
			if (!Cache::has($hall . "_" . $date)) { // Cached file DOES NOT exist
				$getfile = file_get_contents($url);
				$cacheforever = Cache::forever($hall . "_" . $date, $getfile);
				$json = Cache::get($hall . "_" . $date);
				$json = json_decode($json, true);
				foreach($json['Meals'] as $value) {
					if($value['Status'] == "Closed" || $value['Status'] == "Unavailable") {
						continue;
					}
					foreach($value['Stations'] as $station) {
						foreach($station['Items'] as $items) {
							$this->info($items['ID'] . $items['Name'] . " at " . $hall . " " . $station['Name'] . " for " . $value['Name']);
							$food = new NextDay;
							$food->food_id = $items['ID'];
							$food->food_name = $items['Name'];
							$food->hall = $hall;
							$food->station = $station['Name'];
							$food->meal = $value['Name'];
							$food->save();
						}
					}
				}
			}
			else { // Cached file DOES exist
				$json = Cache::get($hall . "_" . $date);
				$json = json_decode($json, true);
				foreach($json['Meals'] as $value) {
					if($value['Status'] == "Closed" || $value['Status'] == "Unavailable") {
						continue;
					}
					foreach($value['Stations'] as $station) {
						foreach($station['Items'] as $items) {
							$this->info($items['ID'] . $items['Name'] . " at " . $hall . " " . $station['Name'] . " for " . $value['Name']);
							$food = new NextDay;
							$food->food_id = $items['ID'];
							$food->food_name = $items['Name'];
							$food->hall = $hall;
							$food->station = $station['Name'];
							$food->meal = $value['Name'];
							$food->save();
						}
					}
				}
			}
		}
		$this->info('Successfully Cached');
		$allowedTo = User::where('settingToggle_allowemail', '=', 1)
					->where('email', '!=', '')->select('id', 'email', 'firstname', 'lastname')->get()->toArray();
		foreach($allowedTo as $allowed) {
			$favlist = Favorites::where('user_id', '=', $allowed['id'])->select('food_id')->get()->toArray();
			$data = NextDay::whereIn('food_id', Favorites::where('user_id', '=', $allowed['id'])->select('food_id')->get()->toArray())->get()->toArray();
				//$data = NextDay::where('food_id', '=', $next['food_id'])->select('food_name', 'hall', 'station', 'meal')->get()->toArray();
				//foreach($data as $item) {
					//$this->info($item['food_name'] . $item['meal'] . $allowed['id']);
				//}
			
			Mail::send('user.emails.fav', compact('data'), function($message) use ($allowed)
			{
				$message->to($allowed['email'], ''.$allowed['firstname']. ' ' . $allowed['lastname'].'')->subject('Tomorrows Schedule!');
			});
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}
