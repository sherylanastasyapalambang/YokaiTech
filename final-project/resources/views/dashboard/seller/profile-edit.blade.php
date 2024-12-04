<x-app-layout>
    <main class="h-auto md:ml-64">
        <section class="bg-white py-8 antialiased md:py-8">
            <div class="mx-auto max-w-screen-lg px-4 2xl:px-0">
              <h2 class="mb-4 mt-10 text-xl font-semibold text-gray-900 sm:text-2xl md:mb-6">Edit Detail</h2>
                <div class="py-4 md:py-8">
                    <form action="{{ route('dashboard.seller.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4 grid gap-4 sm:grid-cols-2 sm:gap-8 lg:gap-16">
                        <div class="space-y-4">
                            <div class="flex space-x-4">
                            {{-- <img class="h-32 w-32 rounded-lg" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/avatars/helene-engels.png" alt="Helene avatar" /> --}}

                            <div class="w-full">
                                <div class="flex items-center justify-center w-full">
                                    <img id="imagePreview" 
                                         src="{{ asset('storage/' . $user->profileImage) }}" 
                                         alt="Profile Image" 
                                         class="h-32 w-32 rounded-lg object-cover">
                                </div>
                                <div class="flex space-x-10 mt-2">
                                    <button type="button" 
                                            id="addPictureButton" 
                                            class="ml-2 mr-5 inline-flex items-center text-sm text-blue-600 hover:underline">
                                        Add 
                                    </button>
                                    <button type="button" 
                                            id="deletePictureButton" 
                                            class="inline-flex items-center text-sm text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </div> 
                                <input type="file" 
                                       name="profileImage" 
                                       id="imageInput" 
                                       class="hidden" 
                                       accept="image/*">
                                <input type="hidden" 
                                       name="deleteProfileImage" 
                                       id="deleteImage" 
                                       value="0"> <!-- Default: Tidak dihapus -->
                            </div>

                            <div class="flex items-center"> 
                                <div class="relative w-full sm:w-96 md:w-96 lg:w-96 mx-auto z-0">
                                    <input 
                                        type="text"
                                        value="{{ $user->name }}" 
                                        name="name" 
                                        id="name-floating" 
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none  dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" 
                                        placeholder=" " 
                                        required/>
                                    <label for="name-floating" class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto">
                                        Name
                                    </label>
                                </div>
                            </div>
                            </div>
                            <dl >
                                <dt class="font-semibold text-gray-900 ml-9">
                                    Email
                                </dt>
                                <div class="flex items-center gap-x-4">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 6H5m2 3H5m2 3H5m2 3H5m2 3H5m11-1a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2M7 3h11a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Zm8 7a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z"/>
                                    </svg>
                                    <div class="relative w-full sm:w-96 md:w-96 lg:w-96">
                                    <input 
                                        type="email" 
                                        name="email"
                                        value="{{ $user->email }}" 
                                        id="email-floating" 
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer dark:border-gray-600 dark:focus:border-blue-500" 
                                        placeholder="example@example.com" />
                                    <label 
                                        for="email-floating" 
                                        class="absolute text-sm text-black duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Email
                                    </label>
                                    </div>
                                </div>
                            </dl>
        
                            <dl class="mb-2">
                                <dt class="font-semibold text-gray-900 ml-9">
                                    Address
                                </dt>
        
                                <div class="flex items-center gap-x-4">
                                    <svg class="hidden h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5" />
                                    </svg>
                                    <div class="relative w-full sm:w-96 md:w-96 lg:w-96">
                                    <input 
                                        type="text" 
                                        name="address"
                                        value="{{ $user->address }}" 
                                        id="address-floating" 
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer dark:border-gray-600 dark:focus:border-blue-500" 
                                        placeholder="st. doko, koko, kokojanai" />
                                    <label 
                                        for="address-floating" 
                                        class="absolute text-sm text-black duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        address
                                    </label>
                                    </div>
                                </div>
                            </dl>
                            <dl class="mb-2">
                                <dt class="font-semibold text-gray-900 ml-9">
                                    Phonenumber
                                </dt>
                                <div class="flex items-center gap-x-4">
                                    <svg class="hidden h-5 w-5 shrink-0 text-gray-400 dark:text-gray-500 lg:inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.427 14.768 17.2 13.542a1.733 1.733 0 0 0-2.45 0l-.613.613a1.732 1.732 0 0 1-2.45 0l-1.838-1.84a1.735 1.735 0 0 1 0-2.452l.612-.613a1.735 1.735 0 0 0 0-2.452L9.237 5.572a1.6 1.6 0 0 0-2.45 0c-3.223 3.2-1.702 6.896 1.519 10.117 3.22 3.221 6.914 4.745 10.12 1.535a1.601 1.601 0 0 0 0-2.456Z"/>
                                    </svg> 
                                    <div class="relative w-full sm:w-96 md:w-96 lg:w-96">
                                    <input 
                                        type="text" 
                                        name="phone"
                                        value="{{ $user->phone }}" 
                                        id="phone-floating" 
                                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer dark:border-gray-600 dark:focus:border-blue-500" 
                                        placeholder="08xxxxxxxxxx" />
                                    <label 
                                        for="phone-floating" 
                                        class="absolute text-sm text-black duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        phone
                                    </label>
                                    </div>
                                </div>
                            </dl>
                        </div>
                        </div>
                    <x-message.message-form />

                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:w-auto">
                    <svg class="-ms-0.5 me-1.5 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"></path>
                    </svg>
                    Save
                    </button>
                </form>
              </div>
            </div>
        </section>
    </main>
</x-app-layout>

<script>
    let defaultImage = "{{ asset('storage/profile/default-profileImage.jpg') }}";
</script>