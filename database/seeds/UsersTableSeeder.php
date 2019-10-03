<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->delete();

      $role_user = Role::where('name', 'user')->first();
      $role_admin = Role::where('name', 'admin')->first();
      $role_notas = Role::where('name', 'notas')->first();

      $user = new User();
      $user->name = 'User';
      $user->email = 'user@example.com';
      $user->password = bcrypt('secret');
      $user->save();
      $user->roles()->attach($role_user);

      $admin = new User();
      $admin->name = 'Manager Name';
      $admin->email = 'admin@example.com';
      $admin->password = bcrypt('secret');
      $admin->save();
      $admin->roles()->attach($role_admin);
      $admin->roles()->attach($role_notas);

      $admin = new User();
      $admin->name = 'Inactivo';
      $admin->email = 'inactivo@example.com';
      $admin->password = bcrypt('secret');
      $admin->save();
      $admin->roles()->attach($role_user);
      $admin->roles()->attach($role_notas);
      $admin->delete();
    }
}
