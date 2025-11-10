<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class ItemController extends Controller
{
    public function index()
    {
        if(Auth::check()){
            $user = Auth::user();
            $items = Item::where('user_id','!=',$user->id)->with('purchase')->get();
            $likes = $user->likedItems()->with('purchase')->get();

            return view('index',compact('items','likes'));

        }else{
            $items = Item::with('purchase')->get();

            return view('index',compact('items'));
        }
    }

    public function search(Request $request)
    {
        if(Auth::check()){
            $user = Auth::user();
            $items = Item::where('user_id','!=',$user->id)
                ->ItemSearch($request->keyword)->with('purchase')->get();
            $likes = $user->likedItems()
                ->ItemSearch($request->keyword)->with('purchase')->get();

                return view('index',compact('items','likes'));

        }else{
            $items = Item::with('purchase')->ItemSearch($request->keyword)->get();

            return view('index',compact('items'));
        }
    }

    public function show($id)
    {
        $user = Auth::user();
        $item = Item::withExists(['likers as liked_by_user' => function ($query) use ($user){
            if($user){
                $query->where('user_id',$user->id);
            }
        }])
        ->withCount('likers')
        ->with(['categories','purchase'])
        ->with([
            'comments' => function ($query){
                $query->with('user.profile');
            }
        ])
        ->withCount('comments')
        ->findOrFail($id);

        return view('detail',compact('item'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('exhibition',compact('categories'));
    }

    public function store(Request $request)
    {
        $exhibition = $request->only(['user_id','name','bland','description','status']);

        $exhibition['price'] = str_replace(',','',$request->input('price'));

        if($request->hasFile('image')){
            $imageName = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('item_image',$imageName,'public');
            $exhibition['image'] = $path;
        }

        DB::beginTransaction();

        try {
            $item = Item::create($exhibition);
            $categoryIds = $request->input('category_ids');
            $item->categories()->sync($categoryIds);

            DB::commit();

            return redirect()->route('item.index')->with('success','商品を出品しました');

        } catch(\Exception $e){
            DB::rollBack();

            return back()->withInput()->withErrors(['error' => '商品の出品に失敗しました']);
        }
    }
}
