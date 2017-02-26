<?php

class ApiController extends BaseController {
	
	/*
	* Get all you need top build graph, either at specific time or latest time
	*
	*/
	public function getPointData($graph, $due_id = false){	
		// if no due is added, as in when first initiating the page, select id with the latest storageDate
		if($due_id==false){$due_id = DB::table('due')->orderBy('storageDate','desc')->limit(1)->pluck('id');}
		
		$storageDate = Due::find($due_id)->storageDate;
		$data = $this->getFleetDueData($graph, $storageDate);
		$date = $this->getNiceDate($storageDate);
		
		return Response::json(array(
			'data' => $data, 
			'date' => $date
		), 200);
		
	}
	
	/*
	* Get all you need top build graph, with avarage percentage between two points in time
	*
	*/
	public function getAvgData($graph, $startDate, $endDate){	
		
		$startDate .= ' 00:00:00';
		$endDate .= ' 00:00:00';
		
		$data = $this->getFleetDueData($graph, $startDate, $endDate);
	
		return Response::json(array(
			'data' => $data, 
			'date' => 'Average ' . $this->getNiceDate($startDate) . ' - ' . $this->getNiceDate($endDate)
		), 200);
		
	}
	
	/*
	*
	*
	*
	*/
	public function getFleetDueData($graph, $date = false, $endDate = false){
		$data = array();		
		if($graph == 1){
		
			$allShipsAvarage = 0; 
			$i = 0;
			foreach (BoatInfo::all()->sortBy('year') as $boat){
				$data[$boat->name]['percentage'] = Due::getJobPercentage($boat->id, $date, $endDate); 
				$data[$boat->name]['color'] = $boat->graphColor;  
				$allShipsAvarage = $allShipsAvarage + $data[$boat->name]['percentage']; 
				$i++;
			}
			
			$data['Avarage']['percentage'] = $allShipsAvarage/$i;
			$data['Avarage']['color'] = '#434348';
			
			return $data;
		}
		
		elseif($graph == 2){
			foreach (BoatInfo::all()->sortBy('year') as $boat){
			
				$t['graph2_data'][$boat->name]['name'] = $boat->name;				
				$t['graph2_data'][$boat->name]['list'] = array();
				$i = 0;
				foreach(Due::where('boatinfo_id', '=', $boat->id)->get() as $due){
					$t['graph2_data'][$boat->name]['list'][$i]['overdueCount'] = $due->overdueCount;	
					$t['graph2_data'][$boat->name]['list'][$i]['boatinfo_id'] = $due->boatinfo_id;	
					$t['graph2_data'][$boat->name]['list'][$i]['percentage'] = Due::getJobPercentage($boat->id, $due->storageDate);
					
					// format date to fit chart data
					$t['graph2_data'][$boat->name]['list'][$i]['storageDate'] = $this->getNiceDate($due->storageDate, true);
					
					$i++;
				}		
			}
		}
		
		else{
			return Response::json(array('error' => 'No graph selected'), 400);
		}
		
		//[Date.UTC(1970,  9, 18), 0   ],
	
		/*
		
			echo '<pre>';
			print_r($t['graph2_data']);			
			echo '</pre>';
			exit();
			
		*/	
	
	}
	
	// format date 
	// ugly 2014-09-29 00:00:00
	// nice JS true : 2014, 09, 29
	// nice JS false : 29.09.2014
	public function getNiceDate($uglyDate, $javascript = false){
		
		$year = substr($uglyDate, 0, 4);
		$month = substr($uglyDate, 5, 2);		
		$day = substr($uglyDate, 8, 2);
		if($javascript){
			$month--; //JS starts jan with 0, feb with 1 and so on
			return $year . ', ' . $month . ', ' . $day;
		}
		return $day . '.' . $month . '.' . $year;
	}				

}
