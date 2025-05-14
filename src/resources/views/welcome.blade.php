<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الصفحة الرئيسية</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto py-10">
        <h1 class="text-4xl font-bold text-center mb-10">الصفحة الرئيسية</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse ($blocks as $block)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ asset('storage/' . $block->image_path) }}" alt="{{ $block->title ?? 'Block Image' }}" class="w-full h-48 object-cover" style="width
                        : 100%">
                    <div class="p-4">
                        <h2 class="text-xl font-semibold">{{ $block->title ?? 'عنوان افتراضي' }}</h2>
                        <p class="text-gray-600">{{ $block->description ?? 'وصف افتراضي' }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">لا توجد بلوكات لعرضها حاليًا.</p>
            @endforelse
        </div>
    </div>
</body>
</html>