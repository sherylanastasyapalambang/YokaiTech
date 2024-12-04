<x-app-layout>
    <main class="p-1 md:ml-64 h-auto pt-5">
        <section>
            <div class="py-8 px-4 mt-5 mx-auto max-w-2xl lg:py-16">
                <form action="{{ route('dashboard.seller.stores.update', $store->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        @csrf
                        @method('PUT')
                        <div class="w-full">
                            <h2 class="mb-4 text-xl font-bold text-gray-900">Add a new store</h2>

                            <label for="seller_id" class="block mt-8 mb-2 text-sm font-medium text-gray-900">Seller</label>
                            <select name="seller_id" id="seller_id" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" disabled>
                                <option value="">Select seller</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" 
                                        {{ $user->id == $store->seller_id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>



                            <label for="name"
                                class="block mt-8 mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ $store->name }}" placeholder="Fill the store's name" required="">
                        </div>  

                        <div class="w-full">
                            <div class="flex items-center justify-center w-full">
                                <img id="imagePreview" 
                                     src="{{ asset('storage/' . $store->storeImage) }}" 
                                     alt="store Image" 
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
                                   name="storeImage" 
                                   id="imageInput" 
                                   class="hidden" 
                                   accept="image/*">
                            <input type="hidden" 
                                    name="deleteStoreImage" 
                                   id="deleteImage" 
                                   value="0"> 
                        </div>

                        <div class="w-full">
                            <label for="phone"
                                class="block mb-2 text-sm font-medium text-gray-900">Phonenumber</label>
                            <input type="text" name="phone" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ $store->phone }}" placeholder="08xxxxxxxxxx" required="">
                        </div>
                        <div class="w-full">
                            <label for="address"
                                class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                            <input type="text" name="address" id="address"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ $store->address }}" placeholder="st. michidoko, yokaimachi, Japan" required="">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                            <textarea name="description" id="description" rows="8" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Your description here">{{ $store->description }}</textarea>
                        </div>
                    </div>
                    <x-message.message-form />
                    <div class="flex space-x-4 mt-1 ">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-800">
                            Save store
                        </button>
                        <a href="{{ route('dashboard.seller.stores.show', $store->slug) }}"
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
    let defaultImage = "{{ asset('storage/stores/default-storeImage.jpg') }}";
</script>

