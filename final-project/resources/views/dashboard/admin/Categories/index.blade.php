@php
    use Illuminate\Support\Str;
@endphp


<x-app-layout>
    <main class="md:ml-64 h-auto pt-20">
        <section class="bg-gray-50 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                        <div
                            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                            <button type="button" data-modal-target="create-category"
                                data-modal-toggle="create-category"
                                class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Add Category
                            </button>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Category name</th>
                                    <th scope="col" class="px-4 py-3">Description</th>
                                    <th scope="col" class="px-4 py-3">Date</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="border-b dark:border-gray-700">
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $category->name }}
                                        </th>
                                        <td class="px-4 py-3"> <a href="#" data-popover-target="category-detail-description-{{ $category->id }}" class="underline">{{ Str::words($category->description, 5, '...') }}</a></td>
                                        <td class="px-4 py-3"> {{ $category->updated_at }} </td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <button id="dropdown-button-{{ $category->id }}"
                                                data-dropdown-toggle="dropdown-{{ $category->id }}"
                                                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                                                type="button">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor"
                                                    viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                            <div id="dropdown-{{ $category->id }}"
                                                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                                    aria-labelledby="dropdown-button-{{ $category->id }}">
                                                    <li>
                                                        <button 
                                                          data-modal-target="edit-category-{{ $category->id }}" 
                                                          data-modal-toggle="edit-category-{{ $category->id }}"
                                                          class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</button>
                                                    </li>
                                                </ul>
                                                <div class="py-1">
                                                    <button 
                                                        data-modal-target="delete-category-{{ $category->id }}" 
                                                        data-modal-toggle="delete-category-{{ $category->id }}"
                                                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</button>
                                                </div>
                                            </div>
                                        </td>

                                        <x-popover.detail-popover 
                                            :id="'category-detail-description-'.$category->id"
                                            :title="'Detail Description'"
                                            :content="$category->description"
                                        />

                                        <x-modals.category.edit-modal 
                                        :category="$category"
                                        :id="'edit-category-'.$category->id" 
                                        :action="route('dashboard.admin.categories.update', $category->id)" />

                                        <x-modals.delete-modal 
                                        :id="'delete-category-'.$category->id" 
                                        :entity="'category'" 
                                        :action="route('dashboard.admin.categories.destroy', $category->id)" />
                                    </tr>
                                @endforeach
                            </tbody>
                            <x-modals.category.create-modal :id="'create-category'" :action="route('dashboard.admin.categories.store')" />
                        </table>
                        <div class="p-3">
                          {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
