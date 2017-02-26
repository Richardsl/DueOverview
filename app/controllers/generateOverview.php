<?php

class generateOverview  extends BaseController {

	public function generateOverview(){		
		set_time_limit(500);
		
		$check = DB::select('SELECT COUNT(*) AS amount FROM tmcomponent');
		
		$boats = DB::select('select * from boatinfo');
		/*
		echo '<pre>';
		print_r($boats);
		echo '</pre>';
		*/
		foreach($boats as &$boat){

			$data = DB::select(
							"SELECT COUNT(*) AS jobCount, xmldate AS xmlDate  FROM tmcomponentjob 
							where UnitID      =  ?
							AND   RowDeleted !=  'true';
							", array((string)$boat->ID)
						);
			$boat->jobCount	= $data[0]->jobCount;		
			$boat->xmlDate	= $data[0]->xmlDate;			
			
			$data = DB::select(
							"SELECT COUNT(*) AS dueCount FROM tmdue
							INNER JOIN tmcomponentjob
							ON tmcomponentjob.TmComponentJobID = tmdue.ComponentJobID
							INNER JOIN tmcomponent
							ON tmcomponentjob.ComponentID = tmcomponent.TmComponentID
							INNER JOIN tmcomponentjobinterval
							ON tmdue.TmComponentJobIntervalID = tmcomponentjobinterval.TmComponentJobIntervalID
											WHERE
								  tmdue.TmUnitID              =  ? 		
							AND   tmdue.RowDeleted           !=  'true'
							AND   tmcomponent.RowDeleted     !=  'true'
							AND   tmcomponentjob.RowDeleted  !=  'true'
							AND   tmdue.Disabled             !=  'true'
							
											 AND
											 
							((  tmdue.Postponed              !=  'true')
											 OR
							(  	tmdue.Postponed               =  'true'									
							AND tmdue.TmJobListID             =  ''
							))
							
											 AND   
											 
							((	  tmdue.DueAtEnd              <  '2014-05-30T00:00:00'
							AND   tmdue.DueAtEnd             !=  ''
							AND TmComponentJobInterval.IntervalType = 'I')
											 OR
							(     tmcomponent.RunningHours   !=  0
							AND   tmdue.DueCounter           !=  0
							AND   tmcomponent.RunningHours    > tmdue.DueCounter
							AND TmComponentJobInterval.IntervalType = 'C'))
							ORDER BY tmcomponent.Code ASC;
							", array((string)$boat->ID)
						);
			$boat->dueCount	= $data[0]->dueCount;	
		
		}
		unset($boat); 


		if($boats){
			return Response::json(array('m' => $boats), 200);
		}else{
			return Response::json(array('m' => 'error!'), 400);
		}

		
	}
}
