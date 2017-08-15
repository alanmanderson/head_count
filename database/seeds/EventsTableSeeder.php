<?php
use Illuminate\Database\Seeder;
use Alanmanderson\HeadCount\Models\Event;
class EventsTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $u = Event::create([
                'name'=>"Elder's Quorum Basketball",
                'address'=>'1000 Shell Blvd',
                'city'=>'Foster City',
                'state'=>'CA',
                'zip'=>'94404',
                'schedule'=>'0 21 * * Tue'
        ]);
        $u = Event::create([
                'name'=>"Elder's Quorum Basketball",
                'address'=>'7118 S Ledge Rock Dr',
                'city'=>'Ammon',
                'state'=>'ID',
                'zip'=>'83406',
                'schedule'=>'0 21 * * Wed'
        ]);
        $u = Event::create([
                'name'=>"Morning Baskeball",
                'address'=>'3102 Pinnacle Dr',
                'city'=>'Idaho Falls',
                'state'=>'ID',
                'zip'=>'83401',
                'schedule'=>'0 6 * * Tue,Thu'
        ]);
    }
}
