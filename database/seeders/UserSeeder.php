<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * The administrators to be seeded.
     *
     * @var array
     */
    protected $administrators = [
        ['name' => 'Admin', 'email' => 'admin@localhost'],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->administrators as $user) {
            User::factory()->administrator()->create($user);
        }
    }
}
