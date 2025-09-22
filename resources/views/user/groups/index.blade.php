  <!-- main content -->
  <div class="main-content right-chat-active">

      <div class="middle-sidebar-bottom">
          <div class="middle-sidebar-left pe-0">
              <div class="row">
                  <div class="col-xl-12">
                      <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                          <div class="card-body d-flex align-items-center p-0">
                              <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">Group</h2>
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
                                              class="open-create-group d-flex align-items-center justify-content-center w-100 h-100">
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
                                          <p class="text-muted small mb-0">See the groups you’re a admin of</p>
                                      </div>

                                      <!-- Right: Icon -->
                                      <div
                                          class="bg-primary bg-opacity-5 rounded-circle p-3 d-flex align-items-center justify-content-center">
                                          <i class="feather-chevron-right text-white"
                                              style="font-size:2rem; line-height:1;"></i>
                                      </div>
                                  </div>
                              </div>

                          </div>
                          <div class="col-md-6 col-sm-6 pe-2 ps-2">
                              <div class="card d-block border-0 shadow-xss rounded-3 overflow-hidden mb-3">
                                  <div class="card-body position-relative h100 bg-image-cover bg-image-center"
                                      style="background-image: url(images/e-4.jpg);"></div>
                                  <div class="card-body d-block w-100 pl-10 pe-4 pb-4 pt-0 text-left position-relative">
                                      <figure class="avatar position-absolute w75 z-index-1"
                                          style="top:-40px; left: 15px;"><img src="images/user_1.png" alt="image"
                                              class="float-right p-1 bg-white rounded-circle w-100"></figure>
                                      <div class="clearfix"></div>
                                      <h4 class="fw-700 font-xsss mt-3 mb-1">Surfiya Zakir</h4>
                                      <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">support@gmail.com</p>
                                      <span class="position-absolute right-15 top-0 d-flex align-items-center">
                                          <a href="#" class="d-lg-block d-none"><i
                                                  class="feather-video btn-round-md font-md bg-primary-gradiant text-white"></i></a>
                                          <a href="#"
                                              class="text-center p-2 lh-24 w100 ms-1 ls-3 d-inline-block rounded-xl bg-current font-xsssss fw-700 ls-lg text-white">FOLLOW</a>
                                      </span>
                                  </div>
                              </div>
                          </div>






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
          $(document).on("click", ".open-create-group", function(e) {
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
      </script>
  @endpush
