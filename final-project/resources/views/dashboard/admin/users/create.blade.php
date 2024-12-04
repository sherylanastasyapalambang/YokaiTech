<x-app-layout>
    <main class="p-1 md:ml-64 h-auto pt-5">
        <section>
            <div class="py-8 px-4 mt-5 mx-auto max-w-2xl lg:py-16">
                <form action="{{ route('dashboard.admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        @csrf
                        <div class="w-full">
                            <h2 class="mb-4 text-xl font-bold text-gray-900">Add a new user</h2>
                            <label for="name"
                                class="block mt-8 mb-2 text-sm font-medium text-gray-900">Name</label>
                            <input type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ old('name') }}" placeholder="Fill user's name" required="">

                            <label for="email"
                                class="block mt-10 mb-2 text-sm font-medium text-gray-900">Email</label>
                            <input type="text" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ old('email') }}" placeholder="fill user's email" required="">
                        </div>  

                        <div class="w-full">
                                <div class="flex items-center justify-center w-full">
                                    <img id="imagePreview" 
                                         src="{{ asset('storage/profile/default-profileImage.jpg') }}" 
                                         alt="Profile Image" 
                                         class="w-44 h-44 rounded-full object-cover">
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
                                       name="profileImage" 
                                       id="imageInput" 
                                       class="hidden" 
                                       accept="image/*">
                        </div>

                        <div class="w-full">
                            <label for="phone"
                                class="block mb-2 text-sm font-medium text-gray-900">Phonenumber</label>
                            <input type="text" name="phone" id="phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" required="">
                        </div>
                        <div class="w-full">
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ old('password') }}" required="">
                        </div>
                        <div class="w-full">
                            <label for="address"
                                class="block mb-2 text-sm font-medium text-gray-900">Address</label>
                            <input type="text" name="address" id="address"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5"
                                value="{{ old('address') }}" placeholder="st. michidoko, yokaimachi, Japan" required="">
                        </div>
                        <div class="w-full">
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Select role</label>
                            <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="" {{ old('role') == '' ? 'selected' : '' }}>Choose a role</option>
                                <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Seller</option>
                                <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>Buyer</option>
                            </select>
                        </div>
                    </div>
                    <x-message.message-form />
                    <div class="flex space-x-4 mt-1 ">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-800">
                            Add user
                        </button>
                        <a href="{{ route('dashboard.admin.users.index') }}"
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
    let defaultImage = "{{ asset('storage/profile/default-profileImage.jpg') }}";
</script>

