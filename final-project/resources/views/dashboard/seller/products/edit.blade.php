<x-app-layout>
    <main class="p-1 md:ml-64 h-auto pt-5">
        <section>
            <div class="py-8 px-4 mt-5 mx-auto max-w-2xl lg:py-16">
                <form action="{{ route('dashboard.seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        @csrf
                        @method('PUT')
                        <div class="w-full">
                            <h2 class="mb-4 text-xl font-bold text-gray-900">Edit product</h2>

                            <label for="store_id" class="block mt-8 mb-2 text-sm font-medium text-gray-900">Store</label>
                            <select name="store_id" id="store_id" disabled
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5">
                                <option value="{{ $user->store->id }}" selected>{{ $user->store->name }}</option>
                            </select>
                            <input type="hidden" name="store_id" value="{{ $user->store->id }}">

                            <label for="name"
                                class="block mt-8 mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ $product->name }}" placeholder="Fill the product's name" required="">
                        </div>  

                        <div class="w-full">
                            <div class="flex items-center justify-center w-full">
                                <img id="imagePreview" 
                                     src="{{ asset('storage/' . $product->image) }}" 
                                     alt="Profile Image" 
                                     class="w-44 h-44 rounded-lg object-cover">
                            </div>
                            <div class="flex space-x-4 mt-5 ml-14">
                                <button type="button" 
                                        id="addPictureButton" 
                                        class="inline-flex items-center px-3 py-2 text-sm text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-800">
                                    Add Picture
                                </button>
                                <button type="button" 
                                        id="deletePictureButton" 
                                        class="inline-flex items-center px-3 py-2 text-sm text-white bg-red-600 rounded-lg focus:ring-4 focus:ring-red-300 hover:bg-red-700">
                                    Delete
                                </button>
                            </div>
                            <input type="file" 
                                    name="image" 
                                   id="imageInput" 
                                   class="hidden" 
                                   accept="image/*">
                            <input type="hidden" 
                                   name="deleteImage" 
                                   id="deleteImage" 
                                   value="0">
                        </div>

                        <div class="w-full">
                            <label for="price"
                                class="block mb-2 text-sm font-medium text-gray-900">Price</label>
                            <input type="number" name="price" id="price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ $product->price }}" placeholder="$1234" required="" min="1">
                        </div>
                        <div class="w-full">
                            <label for="stock"
                                class="block mb-2 text-sm font-medium text-gray-900">Stock</label>
                            <input type="number" name="stock" id="stock"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ $product->stock }}" placeholder="123" required="" min="1">
                        </div>

                        <div class="sm:col-span-2">
                            <button id="categoryDropdownButton" data-dropdown-toggle="categoryDropdown"
                                class="w-full md:w-full flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 "
                                type="button">
                                Category
                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>

                            <div id="categoryDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow">
                                <h6 class="mb-3 text-sm font-medium text-gray-900">Choose categories</h6>
                                <ul class="space-y-2 text-sm" aria-labelledby="categoryDropdownButton">
                                    @foreach ($categories as $category)
                                        <li class="flex items-center">
                                            <input id="category-{{ $category->id }}" type="checkbox" name="categories[]"
                                                value="{{ $category->id }}"
                                                @if(in_array($category->id, $productCategories)) checked @endif
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-blue-600 focus:ring-blue-500">
                                            <label for="category-{{ $category->id }}" class="ml-2 text-sm font-medium text-gray-900">
                                                {{ $category->name }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>                            
                        </div>

                        
                        
                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                            <textarea name="description" value="{{ old('description') }}" id="description" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Your description here">{{ $product->description }}></textarea>
                        </div>
                    </div>
                    <x-message.message-form />
                    <div class="flex space-x-4 mt-1 ">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-800">
                            Save Edit
                        </button>
                        <a href="{{ route('dashboard.seller.products.index') }}"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-gray-600 rounded-lg focus:ring-4 focus:ring-gray-300 hover:bg-gray-700">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</x-app-layout>

<script>
    let defaultImage = "{{ asset('storage/products/default-productImage.jpg') }}";
</script>

