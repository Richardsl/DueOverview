<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('BoatinfoTableSeeder');
	}

}
class BoatinfoTableSeeder extends Seeder {

	public function run()
	{
		DB::table('boatinfo')->delete();

        Boatinfo::create(
			array(
			'name' => 'Sea',
			'year' => '1999',
			'tmId' => 'ab407c24-7685-489b-9413-e3ff0ea9e05a',
			'graphColor' => 'f',
			),
			array(
			'name' => 'Chaser',
			'year' => '2002',
			'tmId' => 'ab407c24-7685-489b-9413-e3ff0ea9e05a',
			'graphColor' => 'f',
			),
			array(
			'name' => 'Sky',
			'year' => '2007',
			'tmId' => 'ab407c24-7685-489b-9413-e3ff0ea9e05a',
			'graphColor' => 'f',
			),
			array(
			'name' => 'Star',
			'year' => '2008',
			'tmId' => 'ab407c24-7685-489b-9413-e3ff0ea9e05a',
			'graphColor' => 'f',
			),
			array(
			'name' => 'Spirit',
			'year' => '2009',
			'tmId' => 'ab407c24-7685-489b-9413-e3ff0ea9e05a',
			'graphColor' => 'f',
			),
			array(
			'name' => 'Swift',
			'year' => '2013',
			'tmId' => 'ab407c24-7685-489b-9413-e3ff0ea9e05a',
			'graphColor' => 'f',
			),
			array(
			'name' => 'Sword',
			'year' => '2014',
			'tmId' => 'ab407c24-7685-489b-9413-e3ff0ea9e05a',
			'graphColor' => 'f',
			),
		);
	}

}
