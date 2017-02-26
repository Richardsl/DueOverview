<?php

class TablesController extends BaseController {

    /**
     * Show the profile for the given user.
     */
	public function getIndex(){
		return View::make('Tables');
	}
	
    //return View::make('Insert');

}
