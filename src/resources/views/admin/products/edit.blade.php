@extends('layouts.admin')

@section('title', __('Edit Product'))

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ __('Edit Product') }}</h2>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white p-4 rounded-md shadow-md">
            <h3 class="text-lg font-semibold mb-3">{{ __('General Information') }}</h3>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">{{ __('Price') }}</label>
                <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $product->price) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('price') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">{{ __('Stock') }}</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('stock') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
                <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700">{{ __('Slug') }}</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('slug') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="bg-white p-4 rounded-md shadow-md">
            <h3 class="text-lg font-semibold mb-3">{{ __('Translations') }}</h3>
            <div class="mb-4 grid grid-cols-2 gap-4">
            {{-- Loop through the locales --}}
                
            @foreach (['ar', 'en'] as $locale)
                @php $translation = $product->translations->where('locale', $locale)->first() @endphp
                <div class="mb-4">
                    <h5 class="font-medium">{{ $locale == 'ar' ? __('Arabic') : __('English') }}</h5>
                    <input type="hidden" name="translations[{{$locale}}][locale]" value="{{ $locale }}">
                    <div>
                        <label for="translations_{{ $locale }}_name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                        <input type="text" name="translations[{{$locale}}][name]" id="translations_{{ $locale }}_name" value="{{ old('translations.' . $locale . '.name', $translation->name ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('translations.' . $locale . '.name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-2">
                        <label for="translations_{{ $locale }}_description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                        <textarea name="translations[{{$locale}}][description]" id="translations_{{ $locale }}_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('translations.' . $locale . '.description', $translation->description ?? '') }}</textarea>
                        @error('translations.' . $locale . '.description') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="content_{{ $locale }}" class="block text-sm font-medium text-gray-700">{{ __('Detailed Content') }}</label>
                        <textarea name="content[{{$locale}}]" id="content_{{ $locale }}" class="tinymce">{{ old('content.' . $locale, $product->getContent($locale)) }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">{{ __('This content will be stored as HTML in a text file') }}</p>
                        @error('content.' . $locale) <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                    </div>
                </div>
            @endforeach
            </div>
        </div>

        <div class="bg-white p-4 rounded-md shadow-md">
            <h3 class="text-lg font-semibold mb-3">{{ __('Images') }}</h3>
            <div id="existing-images-container" class="space-y-4 mb-4">
                @if ($product->images->isNotEmpty())
                    <h4 class="text-md font-semibold">{{ __('Existing Images') }}</h4>
                    @foreach ($product->images as $index => $image)
                        <div class="flex items-start space-x-4 border rounded p-3 image-entry">
                            <div class="w-32 h-32">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image {{ $index + 1 }}" class="image w-full h-full object-cover rounded">
                            </div>
                            <div class="flex-1">
                                <label for="images_{{ $index }}_file" class="block text-sm font-medium text-gray-700">{{ __('Replace Image') }} {{ $index + 1 }}</label>
                                <input type="file" name="images[{{$index}}][file]" id="images_{{ $index }}_file" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <input type="hidden" name="images[{{$index}}][id]" value="{{ $image->id }}">
                                <label class="inline-flex items-center mt-2">
                                    <input type="checkbox" name="images[{{$index}}][is_primary]" id="images_{{ $index }}_is_primary" value="1" class="form-checkbox" {{ old('images.' . $index . '.is_primary', $image->is_primary) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-700">{{ __('Primary Image') }}</span>
                                </label>
                                <div class="mt-2">
                                    <label for="images_{{ $index }}_order" class="block text-sm font-medium text-gray-700">{{ __('Order') }}</label>
                                    <input type="number" name="images[{{$index}}][order]" id="images_{{ $index }}_order" value="{{ old('images.' . $index . '.order', $image->order) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <button type="button" class="mt-2 bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 delete-image" data-id="{{ $image->id }}">{{ __('Delete Image') }}</button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>{{ __('No existing images.') }}</p>
                @endif
            </div>

            <h4 class="text-md font-semibold">{{ __('Add New Images') }}</h4>
            <div id="new-images-container" class="space-y-4">
                <div class="new-image-entry border rounded p-3">
                    <label for="new_images_0_file" class="block text-sm font-medium text-gray-700">{{ __('Image File') }}</label>
                    <input type="file" id="new_images_0_file" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm new-image-input">
                    <div class="upload-progress hidden mt-2">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 0%;"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ __('Uploading...') }} <span class="progress-percent">0%</span></p>
                    </div>
                    <div class="uploaded-image-preview hidden mt-2">
                        <img src="" alt="{{ __('Uploaded Image Preview') }}" class="w-32 h-32 object-cover rounded image">
                        <input type="hidden" class="uploaded-image-path" name="new_images[0][image_path]">
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" class="form-checkbox new-image-is-primary" name="new_images[0][is_primary]">
                            <span class="ml-2 text-sm text-gray-700">{{ __('Set as Primary') }}</span>
                        </label>
                        <div class="mt-2">
                            <label for="new_images_0_order" class="block text-sm font-medium text-gray-700">{{ __('Order') }}</label>
                            <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm new-image-order" name="new_images[0][order]" value="0">
                        </div>
                        <button type="button" class="mt-2 bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400 remove-uploaded-image">{{ __('Remove') }}</button>
                    </div>
                    <div class="new-image-controls mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox new-image-set-primary">
                            <span class="ml-2 text-sm text-gray-700">{{ __('Set as Primary') }}</span>
                        </label>
                        <div class="mt-2">
                            <label for="new_images_0_order_input" class="block text-sm font-medium text-gray-700">{{ __('Order') }}</label>
                            <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm new-image-order-input" value="0">
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="add-new-image" class="mt-4 bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">{{ __('Add Another Image') }}</button>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">{{ __('Update Product') }}</button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let newImageCounter = 1;
            const newImagesContainer = document.getElementById('new-images-container');
            const addNewImageButton = document.getElementById('add-new-image');

            addNewImageButton.addEventListener('click', function() {
                const newImageDiv = document.createElement('div');
                newImageDiv.className = 'new-image-entry border rounded p-3';
                newImageDiv.innerHTML = `
                    <label for="new_images_${newImageCounter}_file" class="block text-sm font-medium text-gray-700">{{ __('Image File') }}</label>
                    <input type="file" id="new_images_${newImageCounter}_file" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm new-image-input">
                    <div class="upload-progress hidden mt-2">
                        <div class="bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 0%;"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ __('Uploading...') }} <span class="progress-percent">0%</span></p>
                    </div>
                    <div class="uploaded-image-preview hidden mt-2">
                        <img src="" alt="{{ __('Uploaded Image Preview') }}" class="w-32 h-32 object-cover rounded list-image-none">
                        <input type="hidden" class="uploaded-image-path" name="new_images[${newImageCounter}][image_path]">
                        <label class="inline-flex items-center mt-2">
                            <input type="checkbox" class="form-checkbox new-image-is-primary" name="new_images[${newImageCounter}][is_primary]">
                            <span class="ml-2 text-sm text-gray-700">{{ __('Set as Primary') }}</span>
                        </label>
                        <div class="mt-2">
                            <label for="new_images_${newImageCounter}_order" class="block text-sm font-medium text-gray-700">{{ __('Order') }}</label>
                            <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm new-image-order" name="new_images[${newImageCounter}][order]" value="0">
                        </div>
                        <button type="button" class="mt-2 bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400 remove-uploaded-image">{{ __('Remove') }}</button>
                    </div>
                    <div class="new-image-controls mt-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox new-image-set-primary">
                            <span class="ml-2 text-sm text-gray-700">{{ __('Set as Primary') }}</span>
                        </label>
                        <div class="mt-2">
                            <label for="new_images_${newImageCounter}_order_input" class="block text-sm font-medium text-gray-700">{{ __('Order') }}</label>
                            <input type="number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm new-image-order-input" value="0">
                        </div>
                    </div>
                `;
                newImagesContainer.appendChild(newImageDiv);
                newImageCounter++;
            });

            newImagesContainer.addEventListener('change', function(event) {
                if (event.target.classList.contains('new-image-input')) {
                    const fileInput = event.target;
                    const file = fileInput.files[0];
                    const entryDiv = fileInput.closest('.new-image-entry');
                    const formData = new FormData();
                    formData.append('image', file);
                    formData.append('_token', '{{ csrf_token() }}');
                    const uploadProgress = entryDiv.querySelector('.upload-progress');
                    const progressBar = uploadProgress.querySelector('.bg-green-500');
                    const progressPercent = uploadProgress.querySelector('.progress-percent');
                    const uploadedImagePreview = entryDiv.querySelector('.uploaded-image-preview');
                    const previewImage = uploadedImagePreview.querySelector('img');
                    const uploadedImagePathInput = uploadedImagePreview.querySelector('.uploaded-image-path');
                    const newImageIsPrimaryCheckbox = entryDiv.querySelector('.new-image-set-primary');
                    newImageOrderInput = entryDiv.querySelector('.new-image-order-input');
                    newImageControls = entryDiv.querySelector('.new-image-controls');
                    newImageIsPrimaryHidden = entryDiv.querySelector('.new-image-is-primary');
                    newImageOrderHidden = entryDiv.querySelector('.new-image-order');

                    uploadProgress.classList.remove('hidden');
                    uploadedImagePreview.classList.add('hidden');
                    newImageControls.classList.add('hidden');

                    fetch('{{ route('admin.products.images.upload') }}', {
                        method: 'POST',
                        body: formData,
                        xhr: function() {
                            const xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener('progress', function(evt) {
                                if (evt.lengthComputable) {
                                    const percentComplete = Math.round((evt.loaded / evt.total) * 100);
                                    progressBar.style.width = percentComplete + '%';
                                    progressPercent.textContent = percentComplete + '%';
                                }
                            });
                            return xhr;
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        uploadProgress.classList.add('hidden');
                        if (data.success) {
                            previewImage.src = '/' + data.path; // Adjust if your storage is configured differently
                            uploadedImagePathInput.value = data.path;
                            uploadedImagePreview.classList.remove('hidden');

                            // Transfer values to the hidden input fields for form submission
                            newImageIsPrimaryHidden.checked = newImageIsPrimaryCheckbox.checked;
                            newImageOrderHidden.value = newImageOrderInput.value;
                        } else if (data.error) {
                            alert(`{{ __('Upload failed: ') }}${data.error}`);
                            // Optionally reset the file input
                            fileInput.value = '';
                            newImageControls.classList.remove('hidden');
                        } else {
                            alert('{{ __('Upload failed.') }}');
                            fileInput.value = '';
                            newImageControls.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Upload error:', error);
                        alert('{{ __('An error occurred during upload.') }}');
                        uploadProgress.classList.add('hidden');
                        fileInput.value = '';
                        newImageControls.classList.remove('hidden');
                    });
                }
            });

            newImagesContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-uploaded-image')) {
                    event.target.closest('.new-image-entry').remove();
                }
            });

            const deleteImageButtons = document.querySelectorAll('.delete-image');
            deleteImageButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const imageId = this.dataset.id;
                    console.log("image will be deleted id: ",imageId);
                    if (confirm('{{ __('Are you sure you want to delete this image?') }}')) {
                        fetch(`/admin/products/images/${imageId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("response: ",data);
                            if (data.success) {
                                this.parentNode.parentNode.remove();
                            } else {
                                alert('{{ __('Failed to delete image.') }}');
                                console.error('Error:', data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting image:', error);
                            alert('{{ __('An error occurred while deleting the image.') }}');
                        });
                    }
                });
            });

            // Display validation errors
            const errors = {!! json_encode($errors->toArray()) !!};
            if (errors && Object.keys(errors).length > 0) {
                for (const [key, messages] of Object.entries(errors)) {
                    const field = document.querySelector(`[name="${key}"]`);
                    if (field) {
                        field.classList.add('border-red-500');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'text-red-500 text-xs italic';
                        errorDiv.textContent = messages[0];
                        field.parentNode.insertBefore(errorDiv, field.nextSibling);
                    }
                }
            }
        });




        document.addEventListener('click', function(event) {
            if(event.target.classList.contains('image')) {
                event.preventDefault();
                const imageId = event.target.dataset.id;
                const imagePath = event.target.src;
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50';
                modal.innerHTML = `
                    <div class="bg-white rounded-lg p-4">
                        <img src="${imagePath}" alt="Image" class="w-full h-auto image" style="max-width: 500px;">
                        <button class="mt-4 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 close-modal">{{ __('Close') }}</button>
                    </div>
                `;
                document.body.appendChild(modal);
                modal.querySelector('.close-modal').addEventListener('click', function() {
                    document.body.removeChild(modal);
                });
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        document.body.removeChild(modal);
                    }
                });
            }
        });
    </script>
</div>
@endsection