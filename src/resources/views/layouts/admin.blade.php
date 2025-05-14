<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/mnesigz4q012kk6c2n9eg3ag1izynqhlujdovkn02jdx9vqj/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap');
        body { font-family: 'Tajawal', sans-serif; }
        [dir="rtl"] .text-right { text-align: right; }
    </style>
    @section('styles')
    <style>
        #pagination-container.opacity-50 {
            transition: opacity 0.3s ease;
        }
        #pagination-container .pointer-events-none {
            cursor: not-allowed;
        }
    </style>
    @endsection
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white h-screen fixed">
            <div class="p-4">
                <h2 class="text-lg font-semibold">{{ __('Admin Panel') }}</h2>
            </div>
            <nav class="mt-4">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="block p-3 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                            {{ __('Dashboard') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="block p-3 hover:bg-gray-700 {{ request()->routeIs('admin.products.*') ? 'bg-gray-700' : '' }}">
                            {{ __('Products') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="block p-3 hover:bg-gray-700 {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700' : '' }}">
                            {{ __('Categories') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="block p-3 hover:bg-gray-700 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : '' }}">
                            {{ __('Orders') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="block p-3 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : '' }}">
                            {{ __('Users') }}
                        </a>
                    </li>
                    <li>
                        <a class="block p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700' : '' }} ">Settings</a>
                        <div class="ml-4">
                            <a href="{{ route('admin.homepage') }}" class="block pl-6 p-3 hover:bg-gray-700 {{ request()->routeIs('admin.homepage.index') ? 'bg-gray-700' : '' }}">
                                {{ __('Home Page') }}
                            </a>
                            <a  class="block pl-6 p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.general') ? 'bg-gray-700' : '' }}">
                                {{ __('General Settings') }}
                            </a>
                            <a  class="block pl-6 p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.payment') ? 'bg-gray-700' : '' }}">
                                {{ __('Payment Settings') }}
                            </a>
                            <a class="block pl-6 p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.shipping') ? 'bg-gray-700' : '' }}">
                                {{ __('Shipping Settings') }}
                            </a>
                            <a  class="block pl-6 p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.seo') ? 'bg-gray-700' : '' }}">
                                {{ __('SEO Settings') }}
                            </a>
                            <a  class="block pl-6 p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.social') ? 'bg-gray-700' : '' }}">
                                {{ __('Social Media Settings') }}
                            </a>
                            <a  class="block pl-6 p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.privacy') ? 'bg-gray-700' : '' }}">
                                {{ __('Privacy Policy') }}
                            </a>
                            <a  class="block pl-6 p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.terms') ? 'bg-gray-700' : '' }}">
                                {{ __('Terms and Conditions') }}
                            </a>
                    </li>
                    {{-- <li>
                        <a href="{{ route('admin.settings.index') }}" class="block p-3 hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700' : '' }}">
                            {{ __('Settings') }}
                        </a>
                    </li> --}}
                    <li class="mt-auto position-bottom " style="position: absolute; bottom: 0; width: 100%;">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left p-3 hover:bg-gray-700 {{ request()->routeIs('logout') ? 'bg-gray-700' : '' }}">
                                {{ __('Logout') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="ml-64 p-6 flex-1">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>
    
    @stack('scripts')

    <script>
        $(document).ready(function() {
            // Set up AJAX with CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            // Initialize TinyMCE for any element with .tinymce class
            tinymce.init({
                selector: '.tinymce',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                height: 400,
                images_upload_handler: function (blobInfo, success, failure) {
                    // For this example, we'll just use base64 encoding
                    // In production, you might want to handle file uploads properly
                    const reader = new FileReader();
                    reader.onload = function () {
                        success(reader.result);
                    };
                    reader.readAsDataURL(blobInfo.blob());
                }
            });

            // Handle setting active class for sidebar links
            // $('nav ul li a').each(function() {
            //     if ($(this).attr('href') === window.location.href) {
            //         $(this).addClass('bg-gray-700');
            //     }
            // });

           
        });
    </script>
</body>
</html>