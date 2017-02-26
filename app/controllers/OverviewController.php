<?php

class OverviewController extends BaseController {

 
	public function getIndex(){
		// Template variables:
		$t = array();	
		$t['graph1_data'] = '';
		$t['graph2_data'] = array();
		//--------------------
		
		
		foreach (BoatInfo::all()->sortBy('year') as $boat){	
		
			
			$t['graph1_data'] .= "['" . $boat->name . "', " . Due::getJobPercentage($boat->id) . "],"; 
			
			$t['graph2_data'][$boat->name]['id'] = $boat->id;
			$t['graph2_data'][$boat->name]['name'] = $boat->name;
			$t['graph2_data'][$boat->name]['color'] = $boat->graphColor;
			$t['graph2_data'][$boat->name]['list'] = array();
			$t['graph2_data'][$boat->name]['flags'] = array();
			$i = 0;
			foreach(Due::where('boatinfo_id', '=', $boat->id)->get() as $due){
				$t['graph2_data'][$boat->name]['list'][$i]['overdueCount'] = $due->overdueCount;
				$t['graph2_data'][$boat->name]['list'][$i]['id'] = $due->id;
				$t['graph2_data'][$boat->name]['list'][$i]['boatinfo_id'] = $due->boatinfo_id;	
				$t['graph2_data'][$boat->name]['list'][$i]['percentage'] = Due::getJobPercentage($boat->id, $due->storageDate);
				
				// format date to fit chart data
				$year = substr($due->storageDate, 0,4);
				$month = (int)substr($due->storageDate, 5,2);
				$month--; //january starts with 0 not 1
				$day = substr($due->storageDate, 8,2);
				
				$t['graph2_data'][$boat->name]['list'][$i]['storageDate'] = $year . ', ' . $month . ', ' . $day;
				
				// create flags array
				if($due->flag != null){
					$t['graph2_data'][$boat->name]['flags'][$i]['text'] = $due->flag;
					$t['graph2_data'][$boat->name]['flags'][$i]['storageDate'] = $year . ', ' . $month . ', ' . $day;
				}
				
				$i++;
			}
			
			
			//[Date.UTC(1970,  9, 18), 0   ],
		}
	/*
		echo '<pre>';
			print_r($t['graph2_data']);
			
			echo '<pre>';
			exit();
		*/	
	
		return View::make('Overview', $t);
	}

}
