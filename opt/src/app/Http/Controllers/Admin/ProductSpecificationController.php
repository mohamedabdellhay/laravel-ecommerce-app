<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Specification;
use Illuminate\Http\Request;

class ProductSpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $productId)
    {
        $product = Product::with('specifications')->findOrFail($productId);
        return view('admin.products.specifications.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $productId)
    {
        $product = Product::with('category.specifications')->findOrFail($productId);

        // Get suggested specifications from the product's category
        $suggestedSpecs = collect([]);
        if ($product->category) {
            $suggestedSpecs = $product->category->specifications;
        }

        // Get all active specifications that are not already attached to this product
        $availableSpecs = Specification::active()
            ->whereDoesntHave('products', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->get();

        return view('admin.products.specifications.create', compact('product', 'suggestedSpecs', 'availableSpecs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $productId)
    {
        $product = Product::findOrFail($productId);

        $validated = $request->validate([
            'specification_id' => 'required|exists:specifications,id',
            'value' => 'required|string',
        ]);

        // Check if specification is already added to this product
        if ($product->specifications()->where('specification_id', $validated['specification_id'])->exists()) {
            return redirect()->back()
                ->with('error', 'This specification is already added to the product.');
        }

        $product->specifications()->attach($validated['specification_id'], [
            'value' => $validated['value']
        ]);

        return redirect()->route('admin.products.specifications.index', $product->id)
            ->with('success', 'Specification added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $productId, string $specificationId)
    {
        $product = Product::findOrFail($productId);
        $specification = $product->specifications()
            ->where('specifications.id', $specificationId)
            ->firstOrFail();

        return view('admin.products.specifications.show', compact('product', 'specification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $productId, string $specificationId)
    {
        $product = Product::findOrFail($productId);
        $specification = $product->specifications()
            ->where('specifications.id', $specificationId)
            ->firstOrFail();

        return view('admin.products.specifications.edit', compact('product', 'specification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $productId, string $specificationId)
    {
        $product = Product::findOrFail($productId);

        // Check if the specification exists for this product
        if (!$product->specifications()->where('specifications.id', $specificationId)->exists()) {
            return redirect()->route('admin.products.specifications.index', $product->id)
                ->with('error', 'This specification is not attached to this product.');
        }

        $validated = $request->validate([
            'value' => 'required|string',
        ]);

        $product->specifications()->updateExistingPivot($specificationId, [
            'value' => $validated['value']
        ]);

        return redirect()->route('admin.products.specifications.index', $product->id)
            ->with('success', 'Specification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $productId, string $specificationId)
    {
        $product = Product::findOrFail($productId);

        // Detach the specification from the product
        $product->specifications()->detach($specificationId);

        return redirect()->route('admin.products.specifications.index', $product->id)
            ->with('success', 'Specification removed successfully.');
    }
}
