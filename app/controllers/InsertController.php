<?php

class InsertController extends BaseController {

    /**
     * Show Insert page
     */
	public function getIndex(){
		return View::make('Insert');
	}
	
	/**
     * Post file
     */
	public function post_upload(){
	
		set_time_limit(500);
		
		$rules = array('file' => 'mimes:xml,XML');
		
		$validation = Validator::make(Input::all(), $rules);
		
		if ($validation->fails())
		{
			return Response::json($validation->errors('file')->first(), 400);
		}
	 
		// Store XML file in 'uploads' Folder
		$xml = simplexml_load_file(Input::file('file'));	
		$destinationPath = '../uploads';		
		$childname = (string)$xml->children()->getname();
		
		$filename = $childname . (string)str_replace(array(':','.','-'),'',$xml->$childname->date) .'.xml';	
		$upload_success = Input::file('file')->move($destinationPath, $filename);
		//---------
		
		// date the xml file was taken from tmmaster, in case its uploaded at a later time.
		// the hoursminutesseconds is removed so that we don't get multiple rows each day
		$insertDate = substr($xml->{$childname}[0]->date, 0,10) . ' 00:00:00';	
		
		
		$boats = BoatInfo::all()->sortBy('year');
		
		foreach ($boats as $boat){
	   
			if($childname == 'TMDUE'){
				$due = new Due;
				$due->overdueCount = 0;
			
				foreach($xml->TMDUE as $tmdue){
					if($tmdue->TmUnitID == $boat->tmId){
						$due->overdueCount++;
					}
				}	
				
				/*
				* Find if there's already a row containing same date and id, if so delete the old and insert the new
				* cant update because both id and date is unique()
				*/			
				$db = DB::connection()->getPdo();
				
				try{ // Select row in due with duplicate date and boat, if so delete it and insert new one
					$xx = $db->prepare("select due.id from due INNER JOIN boatinfo ON due.boatinfo_id = boatinfo.id WHERE boatinfo.id = ? AND due.storageDate = ?");
				}catch (PDOException $e)
				{echo $e->getMessage();}
				
				$xx->execute(array($boat->id , $insertDate));
				$currentRow = $xx->fetch(PDO::FETCH_ASSOC);
	
				try{
				if(isset($currentRow['id'])){//delete old row with duplicate date and boat		
					Due::destroy($currentRow['id']);	
				}
				}catch (PDOException $e)
				{echo $e->getMessage();exit();}
				
				$due->boatinfo_id = $boat->id;
				$due->storageDate = $insertDate;								
				$due->save();	
				
				
				
			}
				
			if($childname == 'TMCOMPONENTJOB'){
				$job = new TotalJobs;
				$job->jobCount = 0;
				
				foreach($xml->TMCOMPONENTJOB as $tmjob){
					if($tmjob->UnitID == $boat->tmId AND $tmjob->RowDeleted != 'true'){
						$job->jobCount++;	
					}	
				}
				/*
				* Find if there's already a row containing same date and id, if so delete the old and insert the new
				* cant update because both id and date is unique()
				*/
				
				$db = DB::connection()->getPdo();
				
				try{ // Select row in totaljobs with duplicate date and boat, if so delete it and insert new one
					$xx = $db->prepare("select totaljobs.id from totaljobs INNER JOIN boatinfo ON totaljobs.boatinfo_id = boatinfo.id WHERE boatinfo.id = ? AND totaljobs.storageDate = ?");
				}catch (PDOException $e)
				{echo $e->getMessage();}
				$xx->execute(array($boat->id , $insertDate));
				$currentRow = $xx->fetch(PDO::FETCH_ASSOC);
	
				try{
				if(isset($currentRow['id'])){//delete old row with duplicate date and boat		
					TotalJobs::destroy($currentRow['id']);	
				}
				}catch (PDOException $e)
				{echo $e->getMessage();exit();}
				
				$job->boatinfo_id = $boat->id;
				$job->storageDate = $insertDate;								
				$job->save();	
			}
				
		}

		
		/*		
		//return Response::json(array('m' => $due->overdueCount, 200));
		die();
		
	
		
		
		
		$errormessage = '';
		$rootname = mysql_real_escape_string($file->children()->getName());
		
		$db = DB::connection()->getPdo();
		
		
		
		
		
		
		
	

		
		
		if($upload_success) {
			if($errormessage == ''){
				return Response::json(array('part'=>$part,'column'=>$rootname,'m'=>'Success!'), 200);
			}else {
				return Response::json('error sql ' .  $errormessage, 400);
			}	
		} else {
			return Response::json('error upload ' .  $errormessage, 400);
		}	
*/		
	}
   

}
