<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Rating;
use App\User_product_list;
use Illuminate\Support\Facades\Auth;

class UserProductListsController extends BaseController
{
    //
    public function reserve(Request $request)
    {
        $user = Auth::user();
        $query_array = $request->all();
        $product_id = $query_array['product_id'];
    
        $product_list = User_product_list::where('product_id', $product_id)->first();
        //$userProduct = User_product_list::find($product_id);
        if($product_list->status !== 1){
            return $this->sendError('この商品が予約されました。');
        }
        $product_list->update([
            'buyer_id' => $user->id,
            'status' => 2
        ]);

        $productData = Product::find($product_id);
        
        $user->chats_sender()->create([
            'receiver_id' => $product_list->seller_id,
            'msg' => "['reserved', '{$productData->name}', '{$productData->img_path}']"
        ]);

        return $this->sendResponse([], 'reserved');
    }

    public function cancel_reserve(Request $request)
    {
        $user = Auth::user();
        $query_array = $request->all();
        $list_id = $query_array['list_id'];
        
        $product_list = User_product_list::find($list_id);
        if($product_list->seller_id !== $user->id && $product_list->buyer_id !== $user->id){
            return $this->sendError('予約者と販売者しかキャンセルできません。');
        }
        $product_list->update([
            'status' => 1,
            'buyer_id' => null
        ]);

        return $this->sendResponse([], 'cancel reserve');
    }

    public function delete_product(Request $request)
    {
        $user = Auth::user();
        $query_array = $request->all();
        $list_id = $query_array['list_id'];
        
        $product_list = User_product_list::find($list_id);
        if($product_list->seller_id !== $user->id){
            return $this->sendError('販売者しか削除できません。');
        }
        $product_list->update([
            'status' => 5
        ]);

        return $this->sendResponse([], 'delete product');
    }

    public function done_transaction(Request $request)
    {
        $user = Auth::user();
        $query_array = $request->all();
        $list_id = $query_array['list_id'];
        
        $product_list = User_product_list::find($list_id);
        if($product_list->seller_id !== $user->id && $product_list->buyer_id !== $user->id){
            return $this->sendError('予約者と販売者しか完了できません。');
        }
        $product_list->update([
            'status' => 3
        ]);

        return $this->sendResponse([], 'done_transaction');
    }

    public function rate_user(Request $request)
    {
        $user = Auth::user();
        $query_array = $request->all();
        $list_id = $query_array['list_id'];
        $rating = $query_array['rating'];
        
        $product_list = User_product_list::find($list_id);
        if($product_list->buyer_id !== $user->id){
            return $this->sendError('予約者しか評価できません。');
        }
        $product_list->update([
            'status' => 4
        ]);
        Rating::create([
            'user_id' => $user->id,
            'rating' => $rating
        ]);

        return $this->sendResponse($query_array, 'rated');
    }
}
