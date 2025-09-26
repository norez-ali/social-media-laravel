  <!-- main content -->
  <div class="main-content right-chat-active">

      <div class="middle-sidebar-bottom">
          <div class="middle-sidebar-left pe-0">
              <div class="row">
                  <div class="col-xl-12">
                      <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                          <div class="card-body d-flex align-items-center p-0">
                              <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">Groups</h2>
                              <div class="search-form-2 ms-auto">
                                  <i class="ti-search font-xss"></i>
                                  <input type="text"
                                      class="form-control text-grey-500 mb-0 bg-greylight theme-dark-bg border-0"
                                      placeholder="Search here.">
                              </div>
                              <a href="#" class="btn-round-md ms-2 bg-greylight theme-dark-bg rounded-3"><i
                                      class="feather-filter font-xss text-grey-500"></i></a>
                          </div>
                      </div>

                      <div class="row ps-2 pe-1">
                          <div class="col-md-6 col-sm-6 pe-2 ps-2">
                              <div class="card border-0 shadow-sm rounded-4 mb-4">
                                  <div class="card-body d-flex align-items-center justify-content-between p-4">
                                      <!-- Left: Title -->
                                      <div>
                                          <h4 class="fw-bold mb-0 text-dark">Create Group</h4>
                                          <p class="text-muted small mb-0">Start a new group and invite members</p>
                                      </div>

                                      <!-- Right: Icon -->
                                      <div class="bg-primary bg-opacity-5 rounded-circle p-3 d-flex align-items-center justify-content-center"
                                          style="width:60px; height:60px;">
                                          <a href="{{ route('user.create.group') }}"
                                              class="open-group d-flex align-items-center justify-content-center w-100 h-100">
                                              <i class="feather-plus text-white"
                                                  style="font-size:2rem; line-height:1;"></i>
                                          </a>
                                      </div>


                                  </div>
                              </div>
                          </div>



                          <div class="col-md-6 col-sm-6 pe-2 ps-2">
                              <div class="card border-0 shadow-sm rounded-4 mb-4">
                                  <div class="card-body d-flex align-items-center justify-content-between p-4">
                                      <!-- Left: Title -->
                                      <div>
                                          <h4 class="fw-bold mb-0 text-dark">My Groups</h4>
                                          <p class="text-muted small mb-0">See the groups you’re a member of</p>
                                      </div>

                                      <!-- Right: Icon -->
                                      <div class="bg-primary bg-opacity-5 rounded-circle p-3 d-flex align-items-center justify-content-center"
                                          style="width:60px; height:60px;">
                                          <a href="{{ route('user.my.groups') }}"
                                              class="open-group d-flex align-items-center justify-content-center w-100 h-100">
                                              <i class="feather-chevron-right text-white"
                                                  style="font-size:2rem; line-height:1;"></i>
                                          </a>
                                      </div>
                                  </div>
                              </div>

                          </div>
                          {{-- Explore groups banner --}}
                          <div class="w-fit mb-4 px-2">
                              <h2 class="fw-bold text-lg text-gray-800 border-b border-gray-200 pb-1"> Explore Groups
                              </h2>
                          </div>

                          @isset($groups)
                              @forelse ($groups as $group)
                                  <div class="col-md-3 col-sm-6 mb-3">
                                      <div class="card border-0 shadow-xss rounded-3 overflow-hidden h-100">

                                          <!-- Image Cover -->
                                          <div class="card-img-top position-relative"
                                              style="height:180px; overflow:hidden;">
                                              <img src="{{ $group->cover_photo && $group->cover_photo
                                                  ? asset('storage/' . $group->cover_photo)
                                                  : asset('assets/images/user-12.png') }}"
                                                  class="w-100 h-100 object-fit object-cover object-top"
                                                  alt="profile-photo">
                                          </div>



                                          <!-- Body -->
                                          <div class="card-body text-center">
                                              <!-- Name -->
                                              <h4 class="fw-700 font-xsss mt-3 mb-3">{{ $group->name }}
                                                  <span
                                                      class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">{{ $group->privacy }}</span>
                                              </h4>




                                              <!-- Buttons -->
                                              <div class="d-flex justify-content-between">
                                                  @if ($group->privacy === 'public')
                                                      <a href="{{ route('user.join.group', $group->id) }}"
                                                          data-leave-url="{{ route('user.leave.group', $group->id) }}"
                                                          class="join-group text-center p-2 flex-fill me-1 d-inline-flex align-items-center justify-content-center rounded-lg bg-primary font-xsssss fw-700 text-white"
                                                          data-id="{{ $group->id }}">
                                                          Join
                                                      </a>
                                                  @else
                                                      <a href="{{ route('user.join.group', $group->id) }}"
                                                          data-leave-url="{{ route('user.leave.group', $group->id) }}"
                                                          class="join-group text-center p-2 flex-fill me-1 d-inline-flex align-items-center justify-content-center rounded-lg bg-primary font-xsssss fw-700 text-white"
                                                          data-id="{{ $group->id }}">
                                                          Request to Join
                                                      </a>
                                                  @endif

                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              @empty
                                  <div class="mb-3">
                                      <h2> No Groups to show</h2>
                                  </div>
                              @endforelse
                          @endisset





                          <div class="col-md-12 pe-2 ps-2">
                              <div class="card w-100 text-center shadow-xss rounded-xxl border-0 p-4 mb-3 mt-0">
                                  <div class="snippet mt-2 ms-auto me-auto" data-title=".dot-typing">
                                      <div class="stage">
                                          <div class="dot-typing"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>



                      </div>
                  </div>
              </div>
          </div>

      </div>
  </div>
  <!-- main content -->

  @push('scripts')
      <script>
          $(document).on("click", ".open-group", function(e) {
              e.preventDefault();

              let url = $(this).attr("href");

              $.ajax({
                  url: url,
                  type: "GET",
                  success: function(response) {
                      // Inject response
                      $(".content").html(response);

                      // Push URL to browser without reload
                      window.history.pushState({
                          path: url
                      }, "", url);
                  },
                  error: function(xhr) {
                      console.error("Error loading view:", xhr.responseText);
                  }
              });
          });

          // Handle back/forward buttons
          $(window).on("popstate", function(e) {
              let url = window.location.href;
              $.ajax({
                  url: url,
                  type: "GET",
                  success: function(response) {
                      $(".content").html(response);
                  }
              });
          });
          //for joining group
          $(document).on("click", ".join-group", function(e) {
              e.preventDefault();

              let button = $(this);
              let url = button.attr("href");
              let groupId = button.data("id");

              $.ajax({
                  url: url,
                  type: "POST",
                  data: {
                      _token: $('meta[name="csrf-token"]').attr("content"),
                  },
                  success: function(response) {
                      if (response.status === "approved") {
                          // Public group → instantly joined
                          button.text("Leave")
                              .removeClass("bg-primary")
                              .addClass("bg-dark text-white leave-group");
                      } else if (response.status === "pending") {
                          // Private group → request sent
                          button.text("Withdraw Request")
                              .removeClass("bg-primary")
                              .addClass("bg-dark text-white leave-group");
                      }
                  },
                  error: function(xhr) {
                      console.error(xhr.responseText);
                      alert("Something went wrong!");
                  }
              });
          });
          // Leave group
          $(document).on("click", ".leave-group", function(e) {
              e.preventDefault();

              let button = $(this);
              let url = button.data("leave-url"); // Set in Blade

              $.ajax({
                  url: url,
                  type: "DELETE",
                  data: {
                      _token: $('meta[name="csrf-token"]').attr("content"),
                  },
                  success: function(response) {
                      if (response.success) {
                          // Decide new button text based on privacy
                          let newText = response.privacy === "public" ? "Join" : "Request to Join";

                          button.text(newText)
                              .removeClass("bg-dark leave-group withdraw-request")
                              .addClass("bg-primary join-group");
                      }
                  },
                  error: function(xhr) {
                      console.error(xhr.responseText);
                      alert("Something went wrong!");
                  }
              });
          });
          //deleting the group
          $(document).on("click", ".delete-group", function(e) {
              e.preventDefault();

              if (!confirm("Are you sure you want to delete this group?")) {
                  return;
              }

              let button = $(this);
              let url = button.data("url");

              $.ajax({
                  url: url,
                  type: "DELETE",
                  data: {
                      _token: $('meta[name="csrf-token"]').attr("content"),
                  },
                  success: function(response) {
                      alert(response.message);

                      // Redirect after successful delete
                      window.location.href = response.redirect;
                  },
                  error: function(xhr) {
                      console.error(xhr.responseText);
                      alert("Something went wrong!");
                  }
              });
          });
      </script>
  @endpush
