<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />


        <!-- Scripts --> 
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
            @if (Auth::check())
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'seller')
                    @include('components.navbar.navbar-admin-seller') 
                @elseif (Auth::user()->role == 'buyer')
                    @include('components.navbar.navbar-buyer')
                @endif
            @elseif (!Auth::check())
                @include('components.navbar.navbar-buyer')
            @endif

            <div class="flex">
                @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'seller'))
                    @include('components.sidebar.sidebar')
                @endif
            </div>


            <!-- Page Content -->
            <main>
                @include('components.message.message-notification')
                
                {{ $slot }}
            </main>

        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
        <script>
            // START: Input gambar
            const addPictureButton = document.getElementById('addPictureButton');
            const deletePictureButton = document.getElementById('deletePictureButton');
            const imageInput = document.getElementById('imageInput');
            const imagePreview = document.getElementById('imagePreview');
            const deleteImageInput = document.getElementById('deleteImage');

            // Klik "Add Picture" membuka file explorer
            addPictureButton.addEventListener('click', () => {
                imageInput.click();
                deleteImageInput.value = 0; // Batal hapus jika memilih file baru
            });

            // Preview gambar yang dipilih
            imageInput.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    deleteImageInput.value = 0; // File baru dipilih
                }
            });

            // Kembalikan ke gambar default
            deletePictureButton.addEventListener('click', () => {
                imagePreview.src = defaultImage;
                imageInput.value = ''; // Hapus pilihan file
                deleteImageInput.value = 1; // Tandai untuk hapus
            });
            // END: Input gambar

            
        </script>
    </body>
</html>
