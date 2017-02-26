<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;
use LaravelBook\Ardent\Ardent;

class Due extends Ardent implements UserInterface, RemindableInterface {

	protected $guarded = array('id');
	protected $table = 'due';
	protected $lastJobRatio = 0;
//4.1 The number of outstanding planned maintenance tasks of non-critical equipment for individual vessels and the fleet as a whole is expressed as a percentage of the total number of monthly planned maintenance tasks.
	/**
	 * Ardent validation rules
	 */
	/*
	public static $rules = array(
		'boatId' => 'required',
		'storageDate' => 'required',
	);
	*/	
	
	
	
	
	
	
	
	
	
	
	/*
	/ Supply only boat id to get the last due ratio, can also supply date to get a specific due ratio
	/
	*/
	public static function getJobPercentage($id, $date = false, $endDate = false)
	{	
		// if no date, get last date
		if(!$date){$date = self::getLastJobDate($id);}
		
		// get due number based of date
		if(!$endDate){
			try{
				$due = parent::whereRaw('boatinfo_id = ? AND storageDate = ?', array($id, $date))->firstOrFail()->overdueCount;
				
				$totalJobs = TotalJobs::whereRaw('boatinfo_id = ? AND storageDate <= ?', array($id, $date))->firstOrFail()->jobCount;
			}
			catch(Exception $e){
				return 'Error: '.__FILE__ . __LINE__ . ' - ' . $e->getMessage();
			}
		}else{
	
			// MÅ ha en foreach loop som velge ALLE samplesane mellom datoane, åso legge dei isammen å dele på antall samples
			// san d e no fe ej berre ijønasnitt av fyrste å siste, som ikkje e bra nokk
			try{
				$dueArray = parent::whereRaw('boatinfo_id = ? AND storageDate >= ? AND storageDate <= ?', array($id, $date, $endDate))->get();
			}
			catch(Exception $e){
				return 'Error: '.__FILE__ . __LINE__ . ' - ' . $e->getMessage();
			}
			/*
			return $dueArray;
			exit();
			*/
			$due = 0;
			$i = 0;
			foreach($dueArray as $d){
				$due += $d['overdueCount'];
				$i++;
			}
			$due = $due/$i;
			
			
			
			try{
				$totalJobsArray = TotalJobs::whereRaw('boatinfo_id = ? AND storageDate >= ? AND storageDate <= ?', array($id, $date, $endDate))->get();
			}
			catch(Exception $e){
				return 'Error: '.__FILE__ . __LINE__ . ' - ' . $e->getMessage();
			}
			
			
			$totalJobs = 0;
			$i = 0;
			foreach($totalJobsArray as $d){
			//return  $d;
				$totalJobs += $d['jobCount'];
				$i++;
			}
			$totalJobs = $totalJobs/$i;
			
		}
		
		
		
		/*
		båtens id
		dato
		
		*/
		
		return ($due/$totalJobs)*100;
	}	
	
	
	/*
	/ Supply only boat id to get the last due count, can also supply date to get a specific due count
	/
	*/
	public static function getJobCount($id, $date = false)
	{
		// if no date, get last date
		if(!$date){$date = self::getLastJobDate($id);}
		try{
			$due = parent::whereRaw('boatinfo_id = ? AND storageDate = ?', array($id, $date))->firstOrFail()->overdueCount;
		}
		catch(Exception $e){
			return 'Error: '.__FILE__ . __LINE__ . ' - ' . $e->getMessage();
		}
		
		return $due;
		
	}	
		
		
	public static function getLastJobDate($id)
	{
		// get the last stored storageDate from due table	
		try{
			$date = parent::where('boatinfo_id', '=', $id)->orderBy('storageDate', 'desc')->firstOrFail()->storageDate;
			return $date;
		}
		catch(Exception $e){
			return 'Error: '.__FILE__ . __LINE__ .' - ' . $e->getMessage();
		}
			
	}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
