<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Chat;

class users_seed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'user01',
            'email' => 'user01@mail.com',
            'password' => '123456',
            'ava_path' => 'ava1.jpg'
        ]);
        $user2 = User::create([
            'name' => 'user02',
            'email' => 'user02@mail.com',
            'password' => '123456',
            'ava_path' => 'ava2.jpg'
        ]);
        
        $user1->chats_sender()->create([
            'receiver_id' => $user2->id,
            'msg' => 'Hi!'
        ]);
    }
}
