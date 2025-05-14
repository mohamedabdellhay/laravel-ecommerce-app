<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with(['translations', 'category', 'images'])
            ->filtered()
            ->sorted();

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        if (request()->ajax()) {
            return response()->json([
                'products' => view('admin.products.partials.product_rows', compact('products'))->render(),
                'pagination' => $products->links()->toHtml(),
            ]);
        }

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(ProductStoreRequest $request)
    {
        $product = DB::transaction(function () use ($request) {
            $product = Product::create([
                'price' => $request->price,
                'sku' => $request->sku,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'slug' => $request->slug,
                'has_content' => !empty($request->content),
            ]);

            $this->saveTranslations($product, $request->translations);
            $this->saveImages($product, $request->images ?? []);
            $this->saveContent($product, $request->content ?? []);

            return $product;
        });

        return redirect()->route('admin.products.index')
            ->with('success', __('Product created successfully'));
    }

    public function show(Product $product)
    {
        $product->load(['translations', 'category', 'images', 'variants']);
        
        $content = [];
        foreach (['ar', 'en'] as $locale) {
            $content[$locale] = $product->getContent($locale);
        }

        return view('admin.products.show', compact('product', 'content'));
    }

    public function edit(Product $product)
    {
        $product->load(['translations', 'images']);
        $categories = Category::all();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $path = $request->file('image')->store('products', 'public');
        
        return response()->json([
            'success' => true,
            'path' => 'storage/' . $path
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        DB::transaction(function () use ($request, $product) {
            $product->update([
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'slug' => $request->slug,
                'has_content' => !empty($request->content),
            ]);

            $this->updateTranslations($product, $request->translations);
            $this->updateImages($product, $request->images ?? []);
            $this->addNewImages($product, $request->new_images ?? []);
            $this->updateContent($product, $request->content ?? []);
        });

        return redirect()->route('admin.products.index')
            ->with('success', __('Product updated successfully'));
    }

    public function destroyImage($id)
    {
        try {
            $image = ProductImage::find($id);
            
            if (!$image) {
                return response()->json(['error' => 'Image not found'], 404);
            }
    
            // Delete from storage
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
    
            // Delete from database
            $image->delete();
    
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete image: ' . $e->getMessage()
            ], 500);
        }
    }
      

    public function destroy(Product $product)
    {
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', __('Product deleted successfully'));
    }

    // Protected helper methods
    protected function saveTranslations(Product $product, array $translations): void
    {
        foreach ($translations as $translation) {
            $product->translations()->create([
                'locale' => $translation['locale'],
                'name' => $translation['name'],
                'description' => $translation['description'] ?? null,
            ]);
        }
    }

    protected function updateTranslations(Product $product, array $translations): void
    {
        foreach ($translations as $locale => $translation) {
            $product->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'name' => $translation['name'],
                    'description' => $translation['description'] ?? null
                ]
            );
        }
    }

    protected function saveImages(Product $product, array $images): void
    {
        foreach ($images as $index => $imageData) {
            if (isset($imageData['image']) && $imageData['image'] instanceof UploadedFile) {
                $product->images()->create([
                    'image_path' => $imageData['image']->store('products', 'public'),
                    'is_primary' => $imageData['is_primary'] ?? false,
                    'order' => $imageData['order'] ?? $index,
                ]);
            }
        }
    }

    protected function updateImages(Product $product, array $images): void
    {
        foreach ($images as $index => $imageData) {
            $image = ProductImage::find($imageData['id'] ?? null);
            
            if (!$image) {
                continue;
            }

            if (isset($imageData['file']) && $imageData['file'] instanceof UploadedFile) {
                Storage::disk('public')->delete($image->image_path);
                $image->image_path = $imageData['file']->store('products', 'public');
            }

            $image->update([
                'is_primary' => $imageData['is_primary'] ?? false,
                'order' => $imageData['order'] ?? $index
            ]);
        }
    }

    protected function addNewImages(Product $product, array $images): void
    {
        foreach ($images as $imageData) {
            if (isset($imageData['image_path'])) {
                $product->images()->create([
                    'image_path' => $imageData['image_path'],
                    'is_primary' => $imageData['is_primary'] ?? false,
                    'order' => $imageData['order'] ?? 0,
                ]);
            }
        }
    }

    protected function saveContent(Product $product, array $content): void
    {
        foreach ($content as $locale => $contentText) {
            if (!empty($contentText)) {
                $product->saveContent($contentText, $locale);
            }
        }
    }

    protected function updateContent(Product $product, array $content): void
    {
        $this->saveContent($product, $content);
    }
}