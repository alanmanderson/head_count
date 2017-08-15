<?php
use Illuminate\Database\Seeder;
use Alanmanderson\HeadCount\Models\User;
use Ramsey\Uuid\Uuid;

class UsersTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $u = User::create([
                'first_name'=>'Alan',
                'last_name'=>'Anderson',
                'email'=>'alanmanderson@gmail.com',
                'phone' => '6177808043',
                'password' => bcrypt('test1234'),
                'guid' => Uuid::uuid4(),
                'remember_token' => str_random(10)
        ]);
        $u = User::create([
                'first_name'=>'Tony',
                'last_name'=>'Elmore',
                'email'=>'alanmanderson+tony@gmail.com',
                'phone' => '6178194548',
                'password' => bcrypt('test1234'),
                'guid' => Uuid::uuid4(),
                'remember_token' => str_random(10)
        ]);
        $u = User::create([
                'first_name'=>'Mike',
                'last_name'=>'Miller',
                'email'=>'alanmanderson+mike@gmail.com',
                'phone' => '16177808043',
                'password' => bcrypt('test1234'),
                'guid' => Uuid::uuid4(),
                'remember_token' => str_random(10)
        ]);
        $u = User::create([
                'first_name'=>'Trent',
                'last_name'=>'Richardson',
                'email'=>'alanmanderson+trent@gmail.com',
                'phone' => '16178194548',
                'password' => bcrypt('test1234'),
                'guid' => Uuid::uuid4(),
                'remember_token' => str_random(10)
        ]);
    }
}
