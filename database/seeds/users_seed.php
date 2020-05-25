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
            'password' => bcrypt('123456'),
            'ava_path' => 'user01.png'
        ]);
        $user2 = User::create([
            'name' => 'user02',
            'email' => 'user02@mail.com',
            'password' => bcrypt('123456'),
            'ava_path' => 'girl-1.png'
        ]);
        $user3 = User::create([
            'name' => 'user03',
            'email' => 'user03@mail.com',
            'password' => bcrypt('123456'),
            'ava_path' => 'user3.png'
        ]);
        $user3 = User::create([
            'name' => 'user03',
            'email' => 'user03@mail.com',
            'password' => bcrypt('123456'),
            'ava_path' => 'user4.png'
        ]);

        $user1->chats_sender()->create([
            'receiver_id' => $user2->id,
            'msg' => 'Hi!'
        ]);

        $categories = ['家具', '家電', '自転車', '服・ファッション', '携帯電話・スマホ', 'おもちゃ', 'パソコン', 'チケット', 'その他'];
        foreach($categories as $category){
            Category::create([
                'name' => $category
            ]);
        }

        $product1 = Product::create([
            'seller_id' => $user1->id,
            'category_id' => 5,
            'name' => 'iPhone XS Max 64GB',
            'desc' => '<p><img src="http://localhost:8000/api/../images/20200525_164930.jpg"></p>',
            'price' => 50000,
            'img_path' => '20200525_164946.jpg',
            'lat' => 35.643652,
            'lng' => 139.671784
        ]);
        $user1->user_product_list_seller()->create([
            'product_id' => $product1->id,
            'buyer_id' => null,
            'status' => 1
        ]);
        foreach(['iphone', 'apple', 'アップル', 'アイフォン'] as $tag){
            $product1->tags()->attach(
                Tag::firstOrCreate(['name' => $tag])->id
            );
        }

        //--------------------

        $product2 = Product::create([
            'seller_id' => $user1->id,
            'category_id' => 5,
            'name' => 'Apple iPad Pro (11-inch, Wi-Fi + Cellular 256GB)',
            'desc' => '<p><img src="http://localhost:8000/api/../images/2350002648099-20374-3.jpg"></p><p><img src="http://localhost:8000/api/../images/2350002648099-20374.jpg"></p>',
            'price' => 60000,
            'img_path' => '61ovkSA9p4L._AC_SL1500_.jpg',
            'lat' => 35.656558,
            'lng' => 139.701732
        ]);
        $user1->user_product_list_seller()->create([
            'product_id' => $product2->id,
            'buyer_id' => null,
            'status' => 1
        ]);
        foreach(['ipad', 'apple', 'アイパッド', 'アップル'] as $tag){
            $product2->tags()->attach([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

        //--------------------

        $product3 = Product::create([
            'seller_id' => $user2->id,
            'category_id' => 6,
            'name' => 'METAL BUILD ストライクガンダム',
            'desc' => '<p><img src="http://localhost:8000/api/../images/item_0000012955_dhzoBx72_01.jpg"></p><p><img src="http://localhost:8000/api/../images/item_0000012955_dhzoBx72_03.jpg"></p>',
            'price' => 16000,
            'img_path' => '61ovkSA9p4L._AC_SL1500_.jpg',
            'lat' => 35.658162,
            'lng' => 139.699972
        ]);
        $user2->user_product_list_seller()->create([
            'product_id' => $product3->id,
            'buyer_id' => null,
            'status' => 1
        ]);
        foreach(['gundam', 'ガンダム', 'ガンプラー', 'モデル'] as $tag){
            $product3->tags()->attach([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

        //--------------------

        $product4 = Product::create([
            'seller_id' => $user3->id,
            'category_id' => 6,
            'name' => 'METAL BUILD エールストライカー',
            'desc' => '<p>取り出していないものです。</p><p><img src="http://localhost:8000/api/../images/15903717101000144542_3.jpg"></p><p><img src="http://localhost:8000/api/../images/15903717201000144542_6.jpg"></p>',
            'price' => 9800,
            'img_path' => '15903719351000144542_1.jpg',
            'lat' => 35.655138,
            'lng' => 139.701946
        ]);
        $user3->user_product_list_seller()->create([
            'product_id' => $product4->id,
            'buyer_id' => null,
            'status' => 1
        ]);
        foreach(['gundam', 'ガンダム', 'ガンプラー', 'モデル', 'ストライカー'] as $tag){
            $product4->tags()->attach([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

    }
}