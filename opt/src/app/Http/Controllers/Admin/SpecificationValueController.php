<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Specification;
use App\Models\SpecificationValue;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SpecificationValueController extends Controller
{
    /**
     * Display the values for a specification.
     */
    public function index(string $specId)
    {
        $specification = Specification::with('values')->findOrFail($specId);
        return view('admin.specifications.values.index', compact('specification'));
    }

    /**
     * Show the form for creating a new value.
     */
    public function create(string $specId)
    {
        $specification = Specification::findOrFail($specId);
        return view('admin.specifications.values.create', compact('specification'));
    }

    /**
     * Store a newly created value in storage.
     */
    public function store(Request $request, string $specId)
    {
        $specification = Specification::findOrFail($specId);

        $validated = $request->validate([
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specification_values')->where(function ($query) use ($specId) {
                    return $query->where('specification_id', $specId);
                }),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('specification_values')->where(function ($query) use ($specId) {
                    return $query->where('specification_id', $specId);
                }),
            ],
            'color_code' => 'nullable|string|max:50',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['value']);
        }

        $specification->values()->create($validated);

        return redirect()->route('admin.specifications.values.index', $specification->id)
            ->with('success', 'Specification value created successfully.');
    }

    /**
     * Show the form for editing a value.
     */
    public function edit(string $specId, string $valueId)
    {
        $specification = Specification::findOrFail($specId);
        $value = SpecificationValue::where('specification_id', $specId)
            ->findOrFail($valueId);

        return view('admin.specifications.values.edit', compact('specification', 'value'));
    }

    /**
     * Update the specified value in storage.
     */
    public function update(Request $request, string $specId, string $valueId)
    {
        $specification = Specification::findOrFail($specId);
        $value = SpecificationValue::where('specification_id', $specId)
            ->findOrFail($valueId);

        $validated = $request->validate([
            'value' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specification_values')->where(function ($query) use ($specId) {
                    return $query->where('specification_id', $specId);
                })->ignore($valueId),
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('specification_values')->where(function ($query) use ($specId) {
                    return $query->where('specification_id', $specId);
                })->ignore($valueId),
            ],
            'color_code' => 'nullable|string|max:50',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['value']);
        }

        $value->update($validated);

        return redirect()->route('admin.specifications.values.index', $specification->id)
            ->with('success', 'Specification value updated successfully.');
    }

    /**
     * Remove the specified value from storage.
     */
    public function destroy(string $specId, string $valueId)
    {
        $specification = Specification::findOrFail($specId);
        $value = SpecificationValue::where('specification_id', $specId)
            ->findOrFail($valueId);

        // Check if the value is in use
        $inUse = $value->products()->exists();

        if ($inUse) {
            return redirect()->route('admin.specifications.values.index', $specification->id)
                ->with('error', 'Cannot delete this value as it is being used by one or more products.');
        }

        $value->delete();

        return redirect()->route('admin.specifications.values.index', $specification->id)
            ->with('success', 'Specification value deleted successfully.');
    }
}
