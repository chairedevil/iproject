<?php

namespace App\Http\Controllers\Api;

use App\Tag;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Undefined;
use Symfony\Component\Console\Input\Input;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query_array = $request->query();
        $lat = explode(",", $query_array['geo'])[0];
        $lng = explode(",", $query_array['geo'])[1];
        $distance = 5;//5km area

        $query_tag = '';
        if($query_array['tags'] !== null){
            $query_tag = "AND tags LIKE '%" . $query_array['tags'] . "%'"; 
        }
        $query_category = '';
        if($query_array['category'] !== null){
            $query_category = 'AND products.category_id = ' . $query_array['category']; 
        }

        //$query = DB::raw('SELECT id , ( 6371 * acos( cos( radians(' . $lat . ') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(' . $lng . ') ) + sin( radians(' . $lat . ') ) * sin( radians(lat) ) ) ) AS distance FROM products HAVING distance < ' . $distance . ' ORDER BY distance');
        $query = DB::raw("SELECT users.name as username, users.ava_path, users.id as seller_id , products.id, products.name, products.img_path, products.lat, products.lng, products.price, products.desc, ( 6371 * acos( cos( radians(" . $lat . ") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(" . $lng . ") ) + sin( radians(" . $lat . ") ) * sin( radians(lat) ) ) ) AS distance, group_concat(tags.name separator ', ') as tags FROM products JOIN user_product_lists ON products.id = user_product_lists.product_id JOIN product_tag ON products.id = product_tag.product_id JOIN tags ON product_tag.tag_id = tags.id JOIN users ON users.id = products.seller_id WHERE user_product_lists.status = 1 " . $query_category . " GROUP BY products.id HAVING distance < " . $distance . " " . $query_tag . " ORDER BY distance");
        $products = DB::select($query);
        
        //$products = Product::all();
        //return response()->json($products);
        return $this->sendResponse($products, 'get products');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validate
        $v = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'category_id' => 'required',
            'desc' => 'required',
            'price' => 'required',
            'img_path' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'tags' => 'required',
        ]);

        if ($v->fails())
        {
            //return redirect()->back()->withErrors($v->errors());
            return $this->sendError('lack of data');
        }

        $user = Auth::user();
        $input = $request->except('img_path', 'tags');
        $tags = explode(",", $request->only('tags')['tags']);

        /*$product = new Product;
        $product->seller_id = $request->input('seller_id');
        $product->category_id = $request->input('category_id');
        $product->name = $request->input('name');
        $product->desc = $request->input('desc');
        $product->price = $request->input('price');
        $product->img_path = $request->input('img_path');
        $product->lat = $request->input('lat');
        $product->lng = $request->input('lng');*/

        if($file = $request->file('img_path')){
            $name = time().$file->getClientOriginalName();
            $file->move('images', $name);
            $input['img_path'] = $name;
        }else{
            return $this->sendError('no image');
        }

        $product = $user->products()->create($input);
        
        foreach($tags as $tag){
            $product->tags()->attach([
                Tag::firstOrCreate(['name' => $tag])->id
            ]);
        }

        $user->user_product_list_seller()->create([
            'product_id' => $product->id,
            'buyer_id' => null,
            'status' => 1
        ]);

        return $this->sendResponse($input, 'get products');
    }

    public function add_img(Request $request)
    {
        $user = Auth::user();
        $filename = "";

        if($file = $request->file('image')){
            $name = time().$file->getClientOriginalName();
            $file->move('images', $name);
            $filename = $name;
        }else{
            return $this->sendError('no image');
        }


        return $this->sendResponse($filename, 'add image');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
