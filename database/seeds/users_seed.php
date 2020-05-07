<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Category;
use App\Chat;
use App\Tag;
use App\Product;
use App\User_product_list;

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

        $categories = ['家具', '家電', '自転車', '服・ファッション', '携帯電話・スマホ', 'おもちゃ', 'パソコン', 'チケット', 'その他'];
        //$tags = ['iphone', 'apple', 'アップル', 'アイフォン'];
        foreach($categories as $category){
            Category::create([
                'name' => $category
            ]);
        }
        /*foreach($tags as $tag){
            Tag::create([
                'name' => $tag
            ]);
        }*/

        $product1 = Product::create([
            'seller_id' => $user1->id,
            'category_id' => 4,
            'name' => 'iPhone XS Max 128GB',
            'desc' => 'long text',
            'price' => 50000,
            'img_path' => 'test.jpg',
            'lat' => 35.656219,
            'lng' => 139.768631
        ]);

        $product2 = Product::create([
            'seller_id' => $user1->id,
            'category_id' => 4,
            'name' => 'iPad Pro 10.5 128GB',
            'desc' => 'long text',
            'price' => 60000,
            'img_path' => 'test.jpg',
            'lat' => 35.656219,
            'lng' => 139.768631
        ]);

        $tags = ['iphone', 'apple', 'アップル', 'アイフォン'];
        
        foreach($tags as $tag){
            $product1->tags()->sync([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

        $tags = ['ipad', 'apple', 'アイパッド', 'アップル'];

        foreach($tags as $tag){
            $product2->tags()->sync([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

    }
}