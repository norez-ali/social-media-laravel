  <div class="card w-100 shadow-xss rounded-xxl border-0 ps-4 pt-4 pe-4 pb-3  mt-3">
      <div class="card-body p-0">
          <button type="button" onclick="toggleCreatePost(true)"
              class="font-xssss fw-600 text-grey-500 card-body p-0 d-flex align-items-center">
              <i class="btn-round-sm font-xs text-primary feather-edit-3 me-2 bg-greylight"></i>
              Create Post
          </button>

      </div>
      <div class="card-body p-0 mt-3 position-relative">
          <figure class="avatar position-absolute ms-2 mt-1 top-5">
              @if (auth_user()->profile->profile_photo)
                  <img src="{{ asset('storage/profile_photos/' . auth_user()->profile->profile_photo) }}" alt="image"
                      class="profile-photo shadow-sm rounded-circle"
                      style="width:30px; height:30px; object-fit:cover; object-position:top;" />
              @else
                  <img src="assets/images/user-8.png" alt="image" class="shadow-sm rounded-circle w30" />
              @endif
          </figure>
          <textarea name="message"
              class="h100 bor-0 w-100 rounded-xxl p-2 ps-5 font-xssss text-grey-500 fw-500 border-light-md theme-dark-bg"
              cols="30" rows="10" placeholder="What's on your mind?" onclick="toggleCreatePost(true)" readonly></textarea>
      </div>
      <div class="card-body d-flex p-0 mt-0">
          <button type="button" onclick="toggleCreatePost(true)"
              class="px-2 d-flex align-items-center font-xssss fw-600 ls-1 text-grey-700 text-dark pe-4">
              <i class="font-md text-success feather-image me-2"></i>
              <span class="d-none-xs">Photo/Video</span>
          </button>
          <a href="#" class="ms-auto" id="dropdownMenu4" data-bs-toggle="dropdown" aria-expanded="false"><i
                  class="ti-more-alt text-grey-900 btn-round-md bg-greylight font-xss"></i></a>
          <div class="dropdown-menu dropdown-menu-start p-4 rounded-xxl border-0 shadow-lg"
              aria-labelledby="dropdownMenu4">
              <div class="card-body p-0 d-flex">
                  <i class="feather-bookmark text-grey-500 me-3 font-lg"></i>
                  <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">
                      Save Link
                      <span class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Add this to
                          your saved items</span>
                  </h4>
              </div>
              <div class="card-body p-0 d-flex mt-2">
                  <i class="feather-alert-circle text-grey-500 me-3 font-lg"></i>
                  <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">
                      Hide Post
                      <span class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Save to your
                          saved items</span>
                  </h4>
              </div>
              <div class="card-body p-0 d-flex mt-2">
                  <i class="feather-alert-octagon text-grey-500 me-3 font-lg"></i>
                  <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">
                      Hide all from Group
                      <span class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Save to your
                          saved items</span>
                  </h4>
              </div>
              <div class="card-body p-0 d-flex mt-2">
                  <i class="feather-lock text-grey-500 me-3 font-lg"></i>
                  <h4 class="fw-600 mb-0 text-grey-900 font-xssss mt-0 me-4">
                      Unfollow Group
                      <span class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Save to your
                          saved items</span>
                  </h4>
              </div>
          </div>
      </div>
  </div>

  {{-- create post popup form --}}
  <div class="create_post">
      <button onclick="toggleCreatePost(true)">

      </button>
  </div>

  <!-- Overlay -->
  <div id="createPostWrapper"
      class="hidden fixed inset-0 bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50">

      <!-- Card -->
      <div class="bg-white rounded-2xl shadow-lg w-full max-w-lg p-6 relative">

          <!-- Close Button -->
          <button onclick="toggleCreatePost(false)"
              class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-4xl">&times;</button>

          <h2 class="font-bold text-xl text-center">Create Post</h2>
          <hr>

          <!-- Create Post Form -->
          <form action="{{ route('user.create.post') }}" method="POST" enctype="multipart/form-data"
              id="createPostForm" class="flex flex-col gap-4">
              @csrf

              <!-- Profile + Name -->
              <div class="flex items-center space-x-3">
                  @if (auth_user()->profile->profile_photo)
                      <img src="{{ asset('storage/profile_photos/' . auth_user()->profile->profile_photo) }}"
                          alt="Profile" class="w-12 h-12 rounded-full object-cover object-top border shadow">
                  @else
                      <img src="{{ asset('assets/images/user-12.png') }}" alt="Profile"
                          class="w-12 h-12 rounded-full object-cover border shadow">
                  @endif

                  <span class="bg-gray-200 text-gray-800 font-semibold text-sm px-3 py-1 rounded-lg">
                      {{ auth_user()->name }}
                  </span>
              </div>

              <!-- Textarea -->
              <textarea name="content" placeholder="What's on your mind?"
                  class="w-full min-h-[120px] resize-none bg-gray-50 rounded-lg border border-gray-300 px-3 py-2 outline-none placeholder-gray-500 text-lg"></textarea>

              <!-- Media Upload -->
              <div
                  class="border-2 border-dashed border-gray-300 hover:border-blue-400 transition rounded-md p-3 text-center cursor-pointer">
                  <input type="file" name="media[]" accept="image/*,video/*" multiple class="hidden"
                      id="mediaUpload">
                  <label for="mediaUpload" class="text-gray-500 hover:text-blue-500 cursor-pointer text-sm">
                      📎 Attach photos or videos
                  </label>

                  <!-- Preview -->
                  <div id="filePreview" class="mt-3 flex flex-wrap gap-3 justify-start"></div>
              </div>

              <!-- Actions -->
              <div class="flex justify-end gap-3 pt-2">
                  <button type="button" onclick="toggleCreatePost(false)"
                      class="px-5 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                      Cancel
                  </button>
                  <button type="submit"
                      class="px-5 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 shadow transition">
                      Post
                  </button>
              </div>
          </form>
      </div>
  </div>



  @push('scripts')
      <script>
          const mediaInput = document.getElementById('mediaUpload');
          const filePreview = document.getElementById('filePreview');

          mediaInput.addEventListener('change', function() {
              filePreview.innerHTML = ""; // clear old previews

              [...this.files].forEach(file => {
                  if (file.type.startsWith("image/")) {
                      const img = document.createElement("img");
                      img.src = URL.createObjectURL(file);
                      img.className = "w-20 h-20 object-cover rounded-lg border";
                      filePreview.appendChild(img);
                  } else if (file.type.startsWith("video/")) {
                      const div = document.createElement("div");
                      div.textContent = "🎬 " + file.name;
                      div.className = "text-sm text-gray-700";
                      filePreview.appendChild(div);
                  }
              });
          });

          function toggleCreatePost(show) {
              document.getElementById('createPostWrapper').classList.toggle('hidden', !show);
          }
          //   ajax
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $('#createPostForm').on('submit', function(e) {
              e.preventDefault();

              let formData = new FormData(this);

              $.ajax({
                  url: $(this).attr('action'),
                  type: "POST",
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(response) {
                      console.log(response);
                      $('#createPostForm')[0].reset();
                      $('#filePreview').empty();
                      toggleCreatePost(false);

                      // Optionally: append new post dynamically to the page
                  },
                  error: function(xhr) {
                      console.error(xhr.responseText);
                      alert('Error: ' + xhr.responseJSON.message);
                  }
              });
          });
      </script>
  @endpush
