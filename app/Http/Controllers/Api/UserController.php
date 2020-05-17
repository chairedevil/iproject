<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserCollection;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::all();
        $users = User::paginate(10);
        //return response()->json($users);
        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json(['data' => $request->input('name')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //unset($user['password']);
        //return response()->json($user);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mylist()
    {

        $user = Auth::user();
        //$sell_list = $user->join('user_product_lists', 'user_product_lists.seller_id', '=', 'users.id')->where('users.id', $user->id)->get();
        $sell_list_query = DB::raw("SELECT user_product_lists.id as list_id, products.img_path, products.name as pname, products.price, buyer.name, buyer.ava_path, user_product_lists.status FROM user_product_lists JOIN products ON products.id = user_product_lists.product_id LEFT JOIN users AS seller ON seller.id = user_product_lists.seller_id LEFT JOIN users AS buyer ON buyer.id = user_product_lists.buyer_id WHERE user_product_lists.seller_id = " . $user->id . " AND status <> 5");
        $sell_list = DB::select($sell_list_query);
        $buy_list_query =  DB::raw("SELECT user_product_lists.id as list_id, products.img_path, products.name as pname, products.price, seller.name, seller.id as seller_id, seller.ava_path, user_product_lists.status FROM user_product_lists JOIN products ON products.id = user_product_lists.product_id LEFT JOIN users AS seller ON seller.id = user_product_lists.seller_id LEFT JOIN users AS buyer ON buyer.id = user_product_lists.buyer_id WHERE user_product_lists.buyer_id = " . $user->id);
        $buy_list = DB::select($buy_list_query);
        
        return $this->sendResponse([$sell_list, $buy_list], 'get my list');
    }
}
