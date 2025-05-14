<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('translations')->get();
        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|unique:categories',
            'parent_id' => 'nullable|exists:categories,id',
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|in:ar,en',
            'translations.*.name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category = Category::create([
            'slug' => $request->slug,
            'parent_id' => $request->parent_id,
        ]);

        foreach ($request->translations as $translation) {
            $category->translations()->create([
                'locale' => $translation['locale'],
                'name' => $translation['name'],
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show($id)
    {
        $category = Category::with('translations')->findOrFail($id);
        $products = Product::where('category_id', $id)->paginate(10);
        if ($category->parent_id) {
            $parentCategory = Category::find($category->parent_id);
            $products = Product::where('category_id', $parentCategory->id)->paginate(10);
        } else {
            $parentCategory = null;
            $products = Product::where('category_id', $category->id)->paginate(10);
        }
            

        if (request()->ajax()) {
            return response()->json([
                'products' => view('admin.products.partials.product_rows', compact('products'))->render(),
                'pagination' => $products->links()->toHtml(),
            ]);
        }
 
        return view('admin.categories.show', compact('category', 'products'));
    }

    public function edit($id)
    {
        $category = Category::with('translations')->findOrFail($id);
        $categories = Category::all();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'slug' => 'sometimes|string|unique:categories,slug,' . $id,
            'parent_id' => 'nullable|exists:categories,id',
            'translations' => 'sometimes|array|min:1',
            'translations.*.locale' => 'required|in:ar,en',
            'translations.*.name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $category->update($request->only(['slug', 'parent_id']));

        if ($request->has('translations')) {
            $category->translations()->delete();
            foreach ($request->translations as $translation) {
                $category->translations()->create([
                    'locale' => $translation['locale'],
                    'name' => $translation['name'],
                ]);
            }
        }

        return response()->json($category->load('translations'));
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    }
}
