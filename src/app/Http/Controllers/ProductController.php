<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private const DEFAULT_PAGENATE = 6;

    public function index(Request $request)
    {
        $products = $this->getProducts($request);

        return view('index', compact('products'));
    }

    public function search(Request $request)
    {
        Log::info('Search request received', $request->all());
        $keyword = $request->input('keyword');
        Log::info('Keyword: ' . $keyword);

        $products = $this->getProducts($request);

        return view('index', compact('products'));
    }

    public function sort(Request $request)
    {
        if ($request->has('sort_order')) {
            session(['sort_order' => $request->input('sort_order')]);
        }

        $products = $this->getProducts($request);

        return view('index', compact('products'));
    }

    public function resetSort(Request $request)
    {
        session()->forget('sort_order');

        $products = $this->getProducts($request);

        return view('index', compact('products'));
    }

    private function getProducts(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->input('keyword') . '%');
        }

        if (session('sort_order')) {
            $query->orderBy('price', session('sort_order'));
        }

        $perPage = $request->input('per_page', self::DEFAULT_PAGENATE);
        return $query->paginate($perPage);
    }

    public function registerView()
    {
        return view('register');
    }

    public function register(ProductRequest $request)
    {
        $validated = $request->validated();

        $productData = [
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/products');
            $imageName = basename($imagePath);
            $productData['image'] = $imageName;
            $imagePreviewPath = asset('storage/products/' . $imageName);
            $request->session()->flash('image_preview', $imagePreviewPath);
        } else {
            return redirect()->back()->with('error', '商品画像を登録してください');
        }

        $product = Product::create($productData);

        if ($request->has('season')) {
            $product->seasons()->attach($request->input('season'));
        }

        return redirect('/products');
    }

    public function show($productId)
    {
        $product = Product::findOrFail($productId);

        $seasons = $product->seasons;

        return view('show', compact('product', 'seasons'));
    }

    public function update(ProductRequest $request, $productId)
    {
        $validated = $request->validated();

        $product = Product::findOrFail($productId);

        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'],
        ]);

        if ($request->has('season')) {
            $product->seasons()->sync($request->input('season'));
        } else {
            $product->seasons()->detach();
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/products');
            $product->image = basename($imagePath);
        }

        $product->save();

        return redirect('/products');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect('/products');
    }
}
