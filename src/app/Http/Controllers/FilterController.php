<?php

namespace App\Http\Controllers;

use App\Models\Filter;
use App\Models\FilterValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilterController extends Controller
{
    public function index()
    {
        $filters = Filter::with(['translations', 'values.translations'])->get();
        return response()->json($filters);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'translations' => 'required|array|min:1',
            'translations.*.locale' => 'required|in:ar,en',
            'translations.*.name' => 'required|string|max:255',
            'values' => 'nullable|array',
            'values.*.translations' => 'required|array|min:1',
            'values.*.translations.*.locale' => 'required|in:ar,en',
            'values.*.translations.*.value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $filter = Filter::create([]);

        foreach ($request->translations as $translation) {
            $filter->translations()->create([
                'locale' => $translation['locale'],
                'name' => $translation['name'],
            ]);
        }

        if ($request->has('values')) {
            foreach ($request->values as $valueData) {
                $filterValue = $filter->values()->create([]);
                foreach ($valueData['translations'] as $translation) {
                    $filterValue->translations()->create([
                        'locale' => $translation['locale'],
                        'value' => $translation['value'],
                    ]);
                }
            }
        }

        return response()->json($filter->load(['translations', 'values.translations']), 201);
    }

    public function show($id)
    {
        $filter = Filter::with(['translations', 'values.translations'])->findOrFail($id);
        return response()->json($filter);
    }

    public function update(Request $request, $id)
    {
        $filter = Filter::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'translations' => 'sometimes|array|min:1',
            'translations.*.locale' => 'required|in:ar,en',
            'translations.*.name' => 'required|string|max:255',
            'values' => 'nullable|array',
            'values.*.translations' => 'required|array|min:1',
            'values.*.translations.*.locale' => 'required|in:ar,en',
            'values.*.translations.*.value' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if ($request->has('translations')) {
            $filter->translations()->delete();
            foreach ($request->translations as $translation) {
                $filter->translations()->create([
                    'locale' => $translation['locale'],
                    'name' => $translation['name'],
                ]);
            }
        }

        if ($request->has('values')) {
            $filter->values()->delete();
            foreach ($request->values as $valueData) {
                $filterValue = $filter->values()->create([]);
                foreach ($valueData['translations'] as $translation) {
                    $filterValue->translations()->create([
                        'locale' => $translation['locale'],
                        'value' => $translation['value'],
                    ]);
                }
            }
        }

        return response()->json($filter->load(['translations', 'values.translations']));
    }

    public function destroy($id)
    {
        $filter = Filter::findOrFail($id);
        $filter->delete();
        return response()->json(null, 204);
    }
}
