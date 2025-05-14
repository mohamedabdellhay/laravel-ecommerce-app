<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SpecificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specifications = Specification::latest()->paginate(10);
        // return $specifications;
        return view('admin.specifications.index', compact('specifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.specifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100|unique:specifications',
            'description' => 'nullable|string',
            'has_multiple_values' => 'sometimes|boolean',
        ]);
        // return $validated;
        // return $request;
        // Generate code if not provided
        if (empty($validated['code'])) {
            $validated['code'] = Str::slug($validated['name']);
        }

        // Handle boolean field
        $validated['has_multiple_values'] = $request->has('has_multiple_values');

        $specification = Specification::create($validated);
        // return $specification;
        return redirect()->route('admin.specifications.index')
            ->with('success', 'Specification created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $specification = Specification::with('values')->findOrFail($id);
        return view('admin.specifications.show', compact('specification'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $specification = Specification::findOrFail($id);
        return view('admin.specifications.edit', compact('specification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $specification = Specification::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('specifications')->ignore($specification->id),
            ],
            'description' => 'nullable|string',
            'has_multiple_values' => 'sometimes|boolean',
        ]);

        // Generate code if not provided
        if (empty($validated['code'])) {
            $validated['code'] = Str::slug($validated['name']);
        }

        // Handle boolean field
        $validated['has_multiple_values'] = $request->has('has_multiple_values');

        $specification->update($validated);

        return redirect()->route('admin.specifications.index')
            ->with('success', 'Specification updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $specification = Specification::with('values')->findOrFail($id);
        // return $specification;
        // Check if the specification is in use on products or categories
        $hasProducts = $specification->products()->exists();
        $hasCategories = $specification->categories()->exists();
        $hasValues = $specification->values->count() > 0;

        if ($hasProducts || $hasCategories || $hasValues) {
            return redirect()->route('admin.specifications.index')
                ->with('error', 'Cannot delete this specification as it is in use.');
        }

        $specification->delete();

        return redirect()->route('admin.specifications.index')
            ->with('success', 'Specification deleted successfully.');
    }
}
