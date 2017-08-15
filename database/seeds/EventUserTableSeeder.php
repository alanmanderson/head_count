<?php
use Alanmanderson\HeadCount\Models\User;
use Illuminate\Database\Seeder;

class EventUserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $u = User::find(1);
        $u->events()->attach([1,2,3]);
        $u = User::find(2);
        $u->events()->attach(1);
        $u = User::find(3);
        $u->events()->attach([2,3]);
        $u = User::find(4);
        $u->events()->attach(3);
    }
}
