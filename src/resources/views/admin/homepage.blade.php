{{-- <!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الصفحة الرئيسية</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
   
</body>
</html> --}}


@extends('layouts.admin')

@section('title', 'Homepage')

@section('content')
     <div class="container mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">إدارة بلوكات الصفحة الرئيسية</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- نموذج إضافة بلوك جديد -->
        <form action="{{ route('admin.homepage.store') }}" method="POST" enctype="multipart/form-data" class="mb-10">
            @csrf
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium">الصورة</label>
                <input type="file" name="image" id="image" class="mt-1 block w-full">
                @error('image')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium">العنوان</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded">
                @error('title')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium">الوصف</label>
                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="order" class="block text-sm font-medium">الترتيب</label>
                <input type="number" name="order" id="order" value="{{ old('order', 0) }}" class="mt-1 block w-full border-gray-300 rounded">
                @error('order')
                    <span class="text-red-600">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">إضافة بلوك</button>
        </form>

        <!-- عرض البلوكات الحالية -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($blocks as $block)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden relative">
                    <img src="{{ asset('storage/' . $block->image_path) }}" alt="{{ $block->title ?? 'Block Image' }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold">{{ $block->title ?? 'عنوان افتراضي' }}</h2>
                        <p class="text-gray-600">{{ $block->description ?? 'وصف افتراضي' }}</p>
                        <p class="text-sm text-gray-500">الترتيب: {{ $block->order }}</p>
                    </div>
                    <form action="{{ route('admin.homepage.destroy', $block->id) }}" method="POST" class="absolute top-2 left-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
                    </form>
                </div>
            @empty
                <p class="text-center text-gray-500">لا توجد بلوكات لعرضها حاليًا.</p>
            @endforelse
        </div>
    </div>
@endsection 