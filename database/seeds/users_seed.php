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
        $user4 = User::create([
            'name' => 'user04',
            'email' => 'user04@mail.com',
            'password' => bcrypt('123456'),
            'ava_path' => 'user4.png'
        ]);

        $user1->chats_sender()->create([
            'receiver_id' => $user2->id,
            'msg' => 'Hi!'
        ]);

        $categories = ['家具', '家電', '自転車', '服・ファッション', '携帯電話・スマホ', 'おもちゃ', 'パソコン', 'チケット', 'カメラ・レンズ', 'その他'];
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
            'img_path' => '1000134667_1.jpg',
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

        //--------------------

        $product5 = Product::create([
            'seller_id' => $user2->id,
            'category_id' => 9,
            'name' => 'ニコン（Nikon）D500 ﾎﾞﾃﾞｨ',
            'desc' => '<p>付属品: ストラップ、取扱説明書、バッテリー１個、充電器、ボディキャップ、USBケーブルクリップ、HDMIケーブルクリップ</p><p></p>外観小スレあり、記入済みメーカー保証書2021年3月2日まで有効。元箱は16-80レンズキッドのものです。<p><img src="http://localhost:8000/api/../images/nikon2.jpg"></p><p><img src="http://localhost:8000/api/../images/nikon3.jpg"></p>',
            'price' => 110000,
            'img_path' => 'nikon1.jpg',
            'lat' => 35.67812547946558,
            'lng' => 139.70274912938882
        ]);
        $user3->user_product_list_seller()->create([
            'product_id' => $product5->id,
            'buyer_id' => null,
            'status' => 1
        ]);
        foreach(['nikon', 'ニコン', 'd500'] as $tag){
            $product5->tags()->attach([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

        //--------------------

        $product6 = Product::create([
            'seller_id' => $user4->id,
            'category_id' => 9,
            'name' => 'ニコン（Nikon） AF-P DX NIKKOR 10-20/4.5-5.6G VR',
            'desc' => '<p>付属品: レンズフロントキャップ、レンズリアキャップ</p><p></p>外観小スレあり、レンズ内小ゴミあり、外観小キズあり<p><img src="http://localhost:8000/api/../images/nilens2.jpg"></p><p><img src="http://localhost:8000/api/../images/nilens3.jpg"></p>',
            'price' => 23100,
            'img_path' => 'nilens1.jpg',
            'lat' => 35.67064537035959,
            'lng' => 139.71802245769976
        ]);
        $user4->user_product_list_seller()->create([
            'product_id' => $product6->id,
            'buyer_id' => null,
            'status' => 1
        ]);
        foreach(['nikon', 'ニコン', 'nikkor', 'lens', 'レンズ'] as $tag){
            $product6->tags()->attach([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

        //--------------------

        $product7 = Product::create([
            'seller_id' => $user4->id,
            'category_id' => 9,
            'name' => 'X-T3 ズームレンズキット シルバー',
            'desc' => '<p>付属品：外箱、バッテリーパック、バッテリーチャージャー、フロントキャップ、マウント部キャップ、レンズ、レンズフード</p><p><img src="http://localhost:8000/api/../images/15904616152133021012382_3.jpg"></p><p><img src="http://localhost:8000/api/../images/15904616242133021012382_2.jpg"></p><p><br></p><p><img src="http://localhost:8000/api/../images/15904616372133021012382_4.jpg"></p><p><img src="http://localhost:8000/api/../images/15904616612133021012382_5.jpg"></p><p><img src="http://localhost:8000/api/../images/15904616702133021012382_6.jpg"></p>',
            'price' => 129228,
            'img_path' => '15904618612133021012382_1.jpg',
            'lat' => 35.661074,
            'lng' => 139.684581
        ]);
        $user4->user_product_list_seller()->create([
            'product_id' => $product7->id,
            'buyer_id' => null,
            'status' => 1
        ]);
        foreach(['fujifilm', 'x-t3'] as $tag){
            $product7->tags()->attach([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

    }
}