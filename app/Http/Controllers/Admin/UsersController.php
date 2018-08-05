<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User as UserMod;
use App\Model\Shop as ShopMod;
use App\Model\Product as ProductMod;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
      // $data = [
      //      'name' => 'My Name',
      //      'surname' => 'My SurName',
      //      'email' => 'myemail@gmail.com'
      //  ];

      //   $user = UserMod::find(1);
      //   $mods = UserMod::all();

      //   return view('template', compact('data', 'user', 'mods'));

    $mods = UserMod::orderBy('id','desc')->paginate(10);
    return view('admin.user.lists', compact('mods') );

 }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
        // $count = UserMod::where('active', 1)->count();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required|min:5|max:50',
            'surname' => 'required|min:2|max:50',
            'mobile' => 'required|numeric',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'age' => 'required|numeric',
            'confirm_password' => 'required|min:6|max:20|same:password',
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name must be at least 5 characters.',
            'name.max' => 'Name should not be greater than 50 characters.',
            'email.unique' => 'Email is not correct',
        ]);


        $mod = new UserMod;
        $mod->email    = $request->email;
        $mod->password = bcrypt($request->password);
        $mod->name     = $request->name;
        $mod->surname  = $request->surname;
        $mod->mobile   = $request->mobile;
        $mod->age      = $request->age;
        $mod->address  = $request->address;
        $mod->city     = $request->city;
        $mod->save();

        return redirect('admin/users')
            ->with('success', 'User ['.$request->name.'] created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        // $mod = UserMod::find($id);
        // echo $mod->name. " ".$mod->surname." => is owner Shop
        // : . ".$mod->shop->name;
        // echo "<br />";
       
        // $shop = UserMod::find($id)->shop;
        // echo $shop->name;
 
        // $mod = ShopMod::find($id);
        // echo $mod->name;

        // echo "<br />";
        // echo $mod->user->name;

        // $products = ShopMod::find($id)->products;
 
        // foreach ($products as $product) {
        //    echo $product->name;
        //    echo "<br />";
        // }
        //  echo "OR <br /><br />";

        // $shops = ShopMod::find($id);
        // echo $shops->name;
        // echo "<br />";

        // foreach ($shops->products as $product) {
        //    echo $product->name;
        //    echo "<br />";
        // }

        $product = ProductMod::find($id);
        echo "Product name is : ".$product->name;
        echo "<br /><br />";
        echo "Shop Owner Is : ".$product->shop->name;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = UserMod::find($id);
        return view('admin.user.edit', compact('item') );
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
        $mod = UserMod::find($id);
        $mod->name = $request->name;
        $mod->password = bcrypt($request->password);
        $mod->save();
        echo "Update Success";
        //return "Update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mod = UserMod::find($id);
        $mod->delete();
        echo "Delete Success";
    }
}
