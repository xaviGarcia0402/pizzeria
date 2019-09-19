<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User();
      $user->name = 'User';
      $user->email = 'user@example.com';
      $user->password = bcrypt('secret');
      $user->save();

      $admin = new User();
      $admin->name = 'Manager Name';
      $admin->email = 'admin@example.com';
      $admin->password = bcrypt('secret');
      $admin->save();
    }
}
