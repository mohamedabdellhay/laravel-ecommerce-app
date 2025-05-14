<?php
namespace App\Http\Controllers;

use App\Models\HomepageBlock;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
  
    public function index()
    {
        $blocks = HomepageBlock::orderBy('order')->get();
        return view('welcome', compact('blocks'));
    }

    
    public function admin()
    {
        $blocks = HomepageBlock::orderBy('order')->get();
        return view('admin.homepage', compact('blocks'));
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $imagePath = $request->file('image')->store('blocks', 'public');

        HomepageBlock::create([
            'image_path' => $imagePath,
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.homepage')->with('success', 'تم إضافة البلوك بنجاح!');
    }

    public function destroy($id)
    {
        $block = HomepageBlock::findOrFail($id);
        // يمكنك إضافة حذف الصورة من التخزين إذا أردت
        $block->delete();

        return redirect()->route('admin.homepage')->with('success', 'تم حذف البلوك بنجاح!');
    }
}