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
		$date = date('m-d-Y', time());
		$array = ["Earhart", "Ford", "Hillenbrand", "Wiley", "Windsor"];
		foreach($array as $hall) {
			$url = "http://api.hfs.purdue.edu/menus/v2/locations/". $hall . "/".$date."";
			if (!Cache::has($hall . "_" . $date)) {
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
		}
		$this->info('Successfully Cached');
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
