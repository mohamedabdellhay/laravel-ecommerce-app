<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|max:100|unique:products',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'specifications' => 'nullable|array',
            'specifications.*.id' => 'required|exists:specifications,id',
            'specifications.*.value_id' => 'nullable|exists:specification_values,id',
            'specifications.*.custom_value' => 'nullable|string|max:255',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle main image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        // Handle additional images upload
        if ($request->hasFile('additional_images')) {
            $additionalImages = [];
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products', 'public');
                $additionalImages[] = $path;
            }
            $validated['additional_images'] = $additionalImages;
        }

        $product = Product::create($validated);

        // Handle specifications
        if ($request->has('specifications')) {
            foreach ($request->specifications as $specData) {
                if (!empty($specData['id'])) {
                    $pivotData = [
                        'specification_value_id' => $specData['value_id'] ?? null,
                        'custom_value' => $specData['custom_value'] ?? null,
                    ];

                    $product->specifications()->attach($specData['id'], $pivotData);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::with(['category'])->findOrFail($id);

            // Load specifications separately to handle potential errors
            try {
                $product->load(['specifications', 'specificationValues']);
            } catch (\Exception $e) {
                // Log the error but continue without specifications
                Log::error('Error loading specifications: ' . $e->getMessage());
            }

            return view('admin.products.show', compact('product'));
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Error loading product: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();

        // Load product specifications with their values
        $product->load(['specifications', 'specificationValues']);

        // Get specifications from the product's category
        $categorySpecs = $product->getCategorySpecifications();

        return view('admin.products.edit', compact('product', 'categories', 'categorySpecs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id),
            ],
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_image' => 'nullable|boolean',
            'delete_additional_images' => 'nullable|array',
            'delete_additional_images.*' => 'nullable|integer',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products')->ignore($product->id),
            ],
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'specifications' => 'nullable|array',
            'specifications.*.id' => 'required|exists:specifications,id',
            'specifications.*.value_id' => 'nullable|exists:specification_values,id',
            'specifications.*.custom_value' => 'nullable|string|max:255',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Handle boolean fields
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle main image deletion if requested
        if ($request->has('delete_image') && $product->image) {
            Storage::disk('public')->delete($product->image);
            $validated['image'] = null;
        }

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        } else {
            // Keep current image if not being updated
            unset($validated['image']);
        }

        // Handle additional images deletion if requested
        if ($request->has('delete_additional_images') && is_array($request->delete_additional_images)) {
            $additionalImages = $product->additional_images ?? [];
            foreach ($request->delete_additional_images as $index) {
                if (isset($additionalImages[$index])) {
                    Storage::disk('public')->delete($additionalImages[$index]);
                    unset($additionalImages[$index]);
                }
            }
            $validated['additional_images'] = array_values($additionalImages);
        }

        // Handle additional images upload
        if ($request->hasFile('additional_images')) {
            $additionalImages = $product->additional_images ?? [];
            foreach ($request->file('additional_images') as $image) {
                $path = $image->store('products', 'public');
                $additionalImages[] = $path;
            }
            $validated['additional_images'] = $additionalImages;
        } else {
            // Keep current additional images if not being updated
            unset($validated['additional_images']);
        }

        $product->update($validated);

        // Handle specifications
        if ($request->has('specifications')) {
            // First detach all current specifications
            $product->specifications()->detach();

            // Attach new specifications
            foreach ($request->specifications as $specData) {
                if (!empty($specData['id'])) {
                    $pivotData = [
                        'specification_value_id' => $specData['value_id'] ?? null,
                        'custom_value' => $specData['custom_value'] ?? null,
                    ];

                    $product->specifications()->attach($specData['id'], $pivotData);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Delete product images
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->additional_images && is_array($product->additional_images)) {
            foreach ($product->additional_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // Delete product (specifications will be deleted via cascadeOnDelete)
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
