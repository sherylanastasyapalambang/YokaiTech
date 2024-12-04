<section class="bg-white py-8 antialiased md:py-14">
    <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
      <div class="flex flex-wrap items-center gap-4">
        <!-- Bagian Reviews -->
        <div class="flex items-center gap-2">
          <h2 class="text-2xl font-semibold text-gray-900">Reviews</h2>
          <div class="mt-2 flex items-center gap-2 sm:mt-0">
            <div class="flex items-center gap-0.5">
                <x-products.products-rating-stars :rating="$product->rounded_rating" />
            </div>
            <p class="text-sm font-medium leading-none text-gray-900">{{ $product->reviews_count }} Reviews</p>
          </div>
        </div>
    
        <!-- Bagian Category dan Write a Review -->
        <div class="flex flex-col items-start sm:flex-row sm:items-center sm:gap-4 sm:ml-auto w-full sm:w-auto">
            <form method="GET" action="">
              @csrf
                <div class="w-full sm:w-auto">
                    <label for="rating" class="sr-only">Rating</label>
                    <select id="rating" name="rating" onchange="this.form.submit()"
                      class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full sm:w-auto p-2">
                      <option value="">All Ratings</option>
                      @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                            {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                        </option>
                      @endfor
                    </select>
                </div>
            </form>
            @if (auth()->check() && $user->role == 'buyer')
              <button type="button" data-modal-target="review-modal-{{ $product->id }}" data-modal-toggle="review-modal-{{ $product->id }}" class="mt-2 sm:mt-0 rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">
                Write a review
              </button>
            @endif
        </div>
      </div>
    
  
      <div class="mt-6 divide-y divide-gray-200">
        <hr>
        @foreach($reviews as $review)
            @if (!$review->parent_id)
            <div class="pt-2 gap-3 pb-6 sm:flex sm:items-start">
            <div class="shrink-0 space-y-2 sm:w-48 md:w-72">
              @if ($review->User->role == 'buyer')
                <div class="flex items-center gap-0.5">
                    <x-products.products-rating-stars :rating="$review->rating" />
                </div>
              @endif
    
                <div class="space-y-0.5">
                <p class="text-base font-semibold text-gray-900 ">
                  {{ $review->User->name }} 
                  @if ($review->User->role === 'admin')
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">
                      Admin
                    </span>
                  @elseif ($review->User->role === 'seller')
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">
                      seller
                    </span>
                  @endif
                </p>
                <p class="text-sm font-normal text-gray-500 ">{{ $review->updated_at }}</p>
                </div>          
            </div>
    
            <div class="mt-4 min-w-0 flex-1 space-y-4 sm:mt-0">
                <p class="text-base font-normal text-gray-500">
                {{ $review->review }}
                </p>

                <button 
                  type="button" 
                  data-modal-target="reply-modal-{{ $review->id }}" 
                  data-modal-toggle="reply-modal-{{ $review->id }}"  
                  class="text-base font-normal text-gray-700 hover:underline" >
                  @if ($review->replies->count() == 1)
                    ({{ $review->replies->count() }}) Reply
                  @elseif ($review->replies->count() > 1)
                    ({{ $review->replies->count() }}) Replies
                  @else
                    Reply
                  @endif
                </button>
            </div>
            </div>

            {{-- Reply Modal --}}
            <div id="reply-modal-{{ $review->id }}" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 antialiased">
              <div class="relative max-h-full w-full max-w-2xl p-4">
                <!-- Modal content -->
                <div class="relative rounded-lg bg-white shadow">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 ">
                    <div>
                      <h3 class="mb-1 text-lg font-semibold text-gray-900 ">View Reply:</h3>
                      <div class="col-span-2 mb-2">
                        <x-products.products-rating-stars :rating="$review->rating" />
                      </div>
                      <p class="text-base font-semibold text-gray-900 ">
                        {{ $review->User->name }} 
                        @if ($review->User->role === 'admin')
                          <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">
                            Admin
                          </span>
                        @elseif ($review->User->role === 'seller')
                          <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">
                            seller
                          </span>
                        @endif
                      </p>
                      <p  class="font-medium text-gray-500">{{ $review->review }}</p>
                    </div>
                    <button type="button" class="absolute right-5 top-5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 " data-modal-toggle="reply-modal-{{ $review->id }}">
                      <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <!-- Modal body -->
                  <div class="p-4 md:p-5">
                    <div>
                      <h3 class="mb-1 text-lg font-semibold text-gray-900 ">Replies:</h3>
                      @forelse($review->replies as $reply)
                      <div class="space-y-5 border-b py-3">
                        <div class="shrink-0 space-y-2 sm:w-48 md:w-72">
                          <div class="space-y-0.5">
                            <p class="text-base font-semibold text-gray-900 ">
                              {{ $reply->User->name }} 
                              @if ($reply->User->role === 'admin')
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">
                                  Admin
                                </span>
                              @elseif ($reply->User->role === 'seller')
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded">
                                  seller
                                </span>
                              @endif
                              <span class="ml-5 text-sm font-normal text-gray-500 "> {{ $reply->updated_at }}</span>
                            </p>
                          </div>          
                        </div>

                        <div class="mt-4 min-w-0 flex-1 space-y-4 sm:mt-0">
                          <p class="text-base font-normal text-gray-500">
                          {{ $reply->review }}
                          </p>
                        </div>
                      </div>
                      @empty
                        <p class="text-base font-normal text-gray-500 ">No replies yet.</p>
                      @endforelse
                    </div>
                    @if (auth()->check() && ($user->role === 'buyer' || $user->role === 'seller'))
                      <form action="{{ $action }}" method="POST" >
                          @csrf
                          <input type="hidden" name="parent_id" value="{{ $review->id }}">
                          <input type="hidden" name="product_id" value="{{ $review->product_id }}">
                          <div class="mt-4 mb-4 grid grid-cols-2 gap-4">
                              <div class="col-span-2">
                                  <label for="description" class="mb-2 block text-sm font-medium text-gray-900">Reply: </label>
                                  <textarea id="description" name="review" rows="6" class="mb-2 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required></textarea>
                              </div>
                          </div>
                          <x-message.message-form />
                          <div class="border-t border-gray-200 pt-4 md:pt-5">
                              <button type="submit" class="me-2 inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">Add reply</button>
                              <button type="button" data-modal-toggle="reply-modal-{{ $review->id }}" class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100">Cancel</button>
                          </div>
                      </form>
                    @endif
                  </div>
                </div>
              </div>
            </div>
            @endif
        @endforeach
      </div>
    </div>
  </section>
  
  {{-- Add review modal --}}
  <div id="review-modal-{{ $product->id }}" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0 antialiased">
    <div class="relative max-h-full w-full max-w-2xl p-4">
      <div class="relative rounded-lg bg-white shadow">
        <div class="flex items-center justify-between rounded-t border-b border-gray-200 p-4 ">
          <div>
            <h3 class="mb-1 text-lg font-semibold text-gray-900 ">Add a review for:</h3>
            <p class="font-medium text-blue-700">{{ $product->name }}</p>
          </div>
          <button type="button" class="absolute right-5 top-5 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 " data-modal-toggle="review-modal-{{ $product->id }}">
            <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <form action="{{ $action }}" method="POST" class="p-4 md:p-5">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <div class="flex items-center">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg data-rating="{{ $i }}" 
                                 class="h-6 w-6 text-gray-300 cursor-pointer" 
                                 aria-hidden="true" 
                                 xmlns="http://www.w3.org/2000/svg" 
                                 fill="currentColor" 
                                 viewBox="0 0 22 20"
                                 onclick="setRating({{ $product->id }}, {{ $i }})">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                            </svg>
                        @endfor
                        <span class="ms-2 text-lg font-bold text-gray-900">0.0 out of 5</span>
                        <input type="hidden" id="rating-{{ $product->id }}" name="rating" value="0">
                    </div>
                </div>
                <div class="col-span-2">
                    <label for="description" class="mb-2 block text-sm font-medium text-gray-900">Review description</label>
                    <textarea id="description" name="review" rows="6" class="mb-2 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500" required></textarea>
                </div>
            </div>
            <x-message.message-form />
            <div class="border-t border-gray-200 pt-4 md:pt-5">
                <button type="submit" class="me-2 inline-flex items-center rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300">Add review</button>
                <button type="button" data-modal-toggle="review-modal-{{ $product->id }}" class="me-2 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100">Cancel</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  

<script>
    function setRating(productId, rating) {
      const ratingInput = document.getElementById(`rating-${productId}`);
      ratingInput.value = rating;

      const stars = document.querySelectorAll(`#review-modal-${productId} svg[data-rating]`);
      stars.forEach(star => {
          if (parseInt(star.getAttribute('data-rating')) <= rating) {
              star.classList.add('text-yellow-300');
              star.classList.remove('text-gray-300');
          } else {
              star.classList.add('text-gray-300');
              star.classList.remove('text-yellow-300');
          }
      });

      const ratingText = document.querySelector(`#review-modal-${productId} .ms-2.text-lg`);
      ratingText.textContent = `${rating}.0 out of 5`;
  }

</script>
