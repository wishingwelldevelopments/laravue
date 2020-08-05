<?php

namespace App\Http\Controllers;
use App\Prisoner;
use Illuminate\Http\Request;

class addPrisoner extends Controller
{
	public function index(Request $req){
		$prisoners = $req->ArrayData;
		foreach($prisoners as $prisoner){
			$obj = new Prisoner();
			if(isset($prisoner['Given names']) && isset($prisoner['Last name']) && isset($prisoner['Court sitting location'])){
				$exists = $obj::where('id', '=', $prisoner['_id'])->first();
				if ($exists === null) {
					$obj->id = $prisoner[ '_id' ];
					$obj->FirstName = $prisoner[ 'Given names' ];
					$obj->LastName = $prisoner[ 'Last name' ];
					$obj->Location = $prisoner[ 'Court sitting location' ];
					$obj->save();
				}else{
					echo "Not Added, Duplicate Entries";
				}
			}else{
				echo "Prisoner was not added as fullname was not provided";
			}
		}
	}
}
