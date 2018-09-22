<?php
namespace App\Http\Controllers;
use App\Category;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Image;
class ItemsController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except('items');
    }
    public function items() {
        $items = Item::with('category')->with('user')->latest()->paginate(10);
        if(!empty(Auth::user())){
            $items = Auth::user()->items()->with('category')->with('user')->latest()->paginate(10);
        }
        return $items;
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $this->adminMove();
        $user = Auth::user();
        $items = $user->items()->with('category')->get();
        $categories = Category::all();
        if (request()->ajax()) {
            return $items;
        }
        return view('items.index', compact('items'))->with(compact('user'))->withCategories($categories);
    }
    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::all();
        $user = Auth::user();
        return view('items.form', compact('categories'))->with(compact('user'));
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $user = Auth::user();
        $images = [];
        if ($request->hasFile('images')):
            foreach ($request->images as $image) {
                $file_name = random_string() . '.' . $image->extension();
                $path = storage_path('app/items') . '/';
                if(!is_dir(storage_path('app/items/'))){
                    mkdir(storage_path('app/items/'),0777);
                }
                if (!file_exists($path . $file_name)):
                    Image::make($image)->heighten(1024, function ($constraint) {
                        $constraint->upsize();
                    })->save($path . $file_name);
                    $images[] = $file_name;
                endif;
            }
        endif;
        $item = $user->items()->create([
            'item_name' => $request->item_name,
            'category_id' => $request->category_id,
            'image_path' => !empty($images) ? json_encode($images) : ""
        ]);
        return $item->load('category');
    }
    /**
     * Display the specified resource.
     * @param Item $item
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Item $item) {
        return $item;
    }
    /**
     * Show the form for editing the specified resource.
     * @param Item $item
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Item $item) {
        $categories = Category::all();
        if(request()->ajax()):
            return $item->load('category');
        endif;
        return view('items.form', compact('item'))->with(compact('categories'));
    }
    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param Item $item
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request,Item $item) {
        $images = json_decode($item->image_path,true);
        if (request()->hasFile('images')):
            foreach (request('images') as $image) {
                $file_name = random_string() . '.' . $image->extension();
                $path = storage_path('app/items') . '/';
                if (!file_exists($path . $file_name)):
                    Image::make($image)->heighten(1024, function ($constraint) {
                        $constraint->upsize();
                    })->save($path . $file_name);
                    $images[] = $file_name;
                endif;
            }
        endif;
        $item->item_name = request('item_name');
        $item->category_id = request('category_id');
        $item->image_path = json_encode($images);
        $item->save();
        return $item->load('category');
    }
    /**
     * Remove the specified resource from storage.
     * @param Item $item
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Item $item) {
        $images = json_decode($item->image_path, true);
        if (!empty($images)):
            $images = array_map(function ($image) {
                return 'items/' . $image;
            }, $images);
            Storage::delete($images);
        endif;
        return $item->delete();
    }
    public function delImage(Item $item) {
        $image = request()->image;
        $images = array_flip(json_decode($item->image_path,true));
        unset($images[$image]);
        $item->image_path = json_encode(array_values(array_flip($images)));
        $item->save();
        Storage::delete('items/'.$image);
    }
    private function adminMove() {
        if (Auth::user()->role != "ADMIN"):
            return redirect('/');
        else:
            return redirect('/admin/categories');
        endif;
    }
}
