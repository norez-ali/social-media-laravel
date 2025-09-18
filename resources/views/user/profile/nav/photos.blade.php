 @push('title')
     <title>Sociala. user-photos</title>
 @endpush
 <div class="col-12">
     {{-- User Photos --}}
     <div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mb-3 bg-white">
         <h2 class="font-bold mb-3">Your Photos</h2>

         <div class="row g-3">
             @foreach ($user->posts as $post)
                 @php
                     // Get only images from media array
                     $images = collect($post->media)->where('media_type', 'image');
                 @endphp

                 @foreach ($images as $file)
                     <div class="col-6 col-md-4" id="post-{{ $post->id }}">
                         <div class="position-relative">
                             <a href="{{ $file['file_path'] }}" data-lightbox="user-photos">
                                 <img src="{{ $file['file_path'] }}"
                                     class="rounded-3 w-100 h-60 object-cover object-top shadow-sm" alt="User photo">
                             </a>

                             {{-- Dropdown for delete --}}
                             @if ($user->id === auth_user()->id)
                                 <div class="dropdown position-absolute top-0 end-0 m-2">
                                     <a href="#" id="dropdownMenu{{ $post->id }}" data-bs-toggle="dropdown"
                                         aria-haspopup="true" aria-expanded="false">
                                         <i class="ti-more-alt text-grey-900 btn-round-md bg-greylight font-xss"></i>
                                     </a>
                                     <div class="dropdown-menu dropdown-menu-end p-2 rounded-xxl border-0 shadow-lg"
                                         aria-labelledby="dropdownMenu{{ $post->id }}">
                                         <form action="{{ route('user.delete.post', $post->id) }}" method="POST"
                                             class="delete-post-form" data-id="{{ $post->id }}">
                                             @csrf
                                             @method('DELETE')

                                             <button type="submit"
                                                 class="btn btn-sm d-flex align-items-center text-danger bg-transparent border-0">
                                                 <i class="feather-trash me-2"></i>
                                                 <span class="small">Delete This Post</span>
                                             </button>
                                         </form>
                                     </div>
                                 </div>
                             @endif
                         </div>
                     </div>
                 @endforeach
             @endforeach
         </div>
     </div>
 </div>

 @push('scripts')
     <script>
         function toggleEditCard(show) {
             const wrapper = document.getElementById("editCardWrapper");

             if (show) {
                 wrapper.classList.remove("hidden");
                 setTimeout(() => {
                     wrapper.classList.add("opacity-100");
                     wrapper.querySelector("#editCard").classList.remove("scale-95");
                 }, 10);
             } else {
                 wrapper.classList.remove("opacity-100");
                 wrapper.querySelector("#editCard").classList.add("scale-95");
                 setTimeout(() => wrapper.classList.add("hidden"), 300); // wait fade-out
             }
         }

         function toggleBioEdit(editing) {
             document.getElementById('bioDisplay').classList.toggle('hidden', editing);
             document.getElementById('bioEdit').classList.toggle('hidden', !editing);
         }

         function toggleDetailsEdit(show) {
             document.getElementById('detailsDisplay').classList.toggle('hidden', show);
             document.getElementById('detailsEdit').classList.toggle('hidden', !show);
         }

         function toggleFeaturedCard(show) {
             const card = document.getElementById("featuredCardWrapper");
             if (show) {
                 card.classList.remove("hidden");
             } else {
                 card.classList.add("hidden");
             }
         }
         $(document).ready(function() {
             // Attach AJAX to all forms with class "ajax-form"
             $(document).on('submit', '.ajax-form', function(e) {
                 e.preventDefault();

                 let form = $(this);
                 let url = form.attr('action');
                 let method = form.attr('method');
                 let formData = new FormData(this);

                 $.ajax({
                     url: url,
                     type: method,
                     data: formData,
                     processData: false,
                     contentType: false,
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     success: function(response) {


                         // ✅ Update fields individually if returned
                         if (response.profile_photo) {
                             $('.profile-photo').attr('src', response.profile_photo);
                         }

                         if (response.cover_photo) {
                             $('.cover-photo').attr('src', response.cover_photo);
                         }

                         if (response.gender) {
                             $('.profile-gender').text(response.gender);
                         }

                         if (response.location) {
                             $('.profile-location').text(response.location);
                         }

                         if (response.username) {
                             $('.profile-username').text(response.username);
                         }

                         if (response.education) {
                             $('.profile-education').text(response.education);
                         }

                         if (response.work) {
                             $('.profile-work').text(response.work);
                         }

                         if (response.bio) {
                             $('.profile-bio').text(response.bio);
                         }
                         closeAllEdits();
                     },
                     error: function(xhr) {
                         alert('Something went wrong!');
                     }
                 });
             });
         });

         function closeAllEdits() {
             // Close edit card
             toggleEditCard(false);

             // Close bio editor
             toggleBioEdit(false);

             // Close details editor
             toggleDetailsEdit(false);

             // Close featured card
             toggleFeaturedCard(false);
         }
         // AJAX for deleting a post
         $(document).on('submit', '.delete-post-form', function(e) {
             e.preventDefault(); // stop normal form submission



             let form = $(this);
             let url = form.attr('action');
             let postId = form.data('id');

             $.ajax({
                 url: url,
                 type: 'POST', // Laravel needs POST + _method=DELETE
                 data: form.serialize(),
                 success: function(response) {
                     if (response.success) {
                         $('#post-' + postId).remove(); // remove deleted post card
                     }
                 },
                 error: function(xhr) {
                     alert('Something went wrong while deleting the post.');
                     console.log(xhr.responseText);
                 }
             });
         });
     </script>
 @endpush
