  <div class="app-footer border-0 shadow-lg bg-primary-gradiant">
      <a href="default.html" class="nav-content-bttn nav-center"><i class="feather-home"></i></a>
      <a href="default-video.html" class="nav-content-bttn"><i class="feather-package"></i></a>
      <a href="default-live-stream.html" class="nav-content-bttn" data-tab="chats"><i class="feather-layout"></i></a>
      <a href="shop-2.html" class="nav-content-bttn"><i class="feather-layers"></i></a>
      <a href="default-settings.html" class="nav-content-bttn"><img src="images/female-profile.png" alt="user"
              class="w30 shadow-xss" /></a>
  </div>

  <div class="app-header-search">
      <form class="search-form">
          <div class="form-group searchbox mb-0 border-0 p-1">
              <input type="text" class="form-control border-0" placeholder="Search..." />
              <i class="input-icon">
                  <ion-icon name="search-outline" role="img" class="md hydrated"
                      aria-label="search outline"></ion-icon>
              </i>
              <a href="#" class="ms-1 mt-1 d-inline-block close searchbox-close">
                  <i class="ti-close font-xs"></i>
              </a>
          </div>
      </form>
  </div>
  </div>

  <div class="modal bottom side fade" id="Modalstory" tabindex="-1" role="dialog" style="overflow-y: auto">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content border-0 bg-transparent">
              <button type="button" class="close mt-0 position-absolute top--30 right--10" data-dismiss="modal"
                  aria-label="Close">
                  <i class="ti-close text-grey-900 font-xssss"></i>
              </button>
              <div class="modal-body p-0">
                  <div class="card w-100 border-0 rounded-3 overflow-hidden bg-gradiant-bottom bg-gradiant-top">
                      <div class="owl-carousel owl-theme dot-style3 story-slider owl-dot-nav nav-none">

                          {{-- stories injected here by js --}}


                      </div>
                  </div>
                  <div class="form-group mt-3 mb-0 p-3 position-absolute bottom-0 z-index-1 w-100">
                      <form id="storyCommentForm">
                          @csrf
                          <input type="text" id="storyCommentInput"
                              class="style2-input w-100 bg-transparent border-light-md p-3 pe-5 font-xssss fw-500 text-white"
                              placeholder="Write Comments..." />
                          <span id="sendStoryComment" class="feather-send text-white font-md position-absolute"
                              style="bottom: 35px; right: 30px; cursor: pointer;"></span>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>










  <div class="modal-popup-chat">
      <div class="modal-popup-wrap bg-white p-0 shadow-lg rounded-3">
          <div class="modal-popup-header w-100 border-bottom">
              <div class="card p-3 d-block border-0 d-block">
                  <figure class="avatar mb-0 float-left me-2">
                      <img src="images/user-12.png" alt="image" class="w35 me-1" />
                  </figure>
                  <h5 class="fw-700 text-primary font-xssss mt-1 mb-1">
                      Hendrix Stamp
                  </h5>
                  <h4 class="text-grey-500 font-xsssss mt-0 mb-0">
                      <span class="d-inline-block bg-success btn-round-xss m-0"></span>
                      Available
                  </h4>
                  <a href="#" class="font-xssss position-absolute right-0 top-0 mt-3 me-4"><i
                          class="ti-close text-grey-900 mt-2 d-inline-block"></i></a>
              </div>
          </div>
          <div class="modal-popup-body w-100 p-3 h-auto">
              <div class="message">
                  <div class="message-content font-xssss lh-24 fw-500">
                      Hi, how can I help you?
                  </div>
              </div>
              <div class="date-break font-xsssss lh-24 fw-500 text-grey-500 mt-2 mb-2">
                  Mon 10:20am
              </div>
              <div class="message self text-right mt-2">
                  <div class="message-content font-xssss lh-24 fw-500">
                      I want those files for you. I want you to send 1 PDF and 1 image
                      file.
                  </div>
              </div>
              <div class="snippet pt-3 ps-4 pb-2 pe-3 mt-2 bg-grey rounded-xl float-right" data-title=".dot-typing">
                  <div class="stage">
                      <div class="dot-typing"></div>
                  </div>
              </div>
              <div class="clearfix"></div>
          </div>
          <div class="modal-popup-footer w-100 border-top">
              <div class="card p-3 d-block border-0 d-block">
                  <div class="form-group icon-right-input style1-input mb-0">
                      <input type="text" placeholder="Start typing.."
                          class="form-control rounded-xl bg-greylight border-0 font-xssss fw-500 ps-3" /><i
                          class="feather-send text-grey-500 font-md"></i>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <script src="{{ asset('assets/js/plugin.js') }}"></script>
  <script src="{{ asset('assets/js/lightbox.js') }}"></script>
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <script>
      var myModal = document.getElementById('Modalstory');

      myModal.addEventListener('show.bs.modal', function(event) {
          var button = event.relatedTarget;
          var userId = button.getAttribute('data-id');

          // Clear old stories
          let slider = myModal.querySelector('.story-slider');
          slider.innerHTML = '<p class="text-white p-3">Loading...</p>';

          // Fetch user stories via AJAX
          fetch('show-stories/' + userId)
              .then(response => response.json())
              .then(data => {
                  slider.innerHTML = ''; // clear loading text

                  if (data.stories.length > 0) {

                      data.stories.forEach(story => {
                          let viewsCount = story.views ?? 0; // Get views count
                          let slide = '';

                          if (story.media_type === 'image') {
                              slide = `
                            <div class="item story-item position-relative" style="height:600px; background:#000;">
                                <img src="/storage/${story.media}" alt="story"
                                    style="max-height:100%; max-width:100%; object-fit:cover;"
                                    data-story-id="${story.id}" data-user-id="${data.user_id}" />
                               <span class="story-views position-absolute text-white px-3 py-2"
      style="bottom:75px; left:50%; transform:translateX(-50%); background:rgba(0,0,0,0.5); border-radius:20px; font-size:16px;">
    👁 ${viewsCount}
</span>
                            </div>
                        `;
                          } else if (story.media_type === 'video') {
                              slide = `
                            <div class="item story-item position-relative" style="height:600px; background:#000;">
                                <video style="max-height:100%; max-width:100%; object-fit:cover;" controls
                                    data-story-id="${story.id}" data-user-id="${data.user_id}">
                                    <source src="/storage/${story.media}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <span class="story-views position-absolute text-white px-2 py-1" style="bottom:10px; right:10px; background:rgba(0,0,0,0.5); border-radius:12px; font-size:14px;">
                                    👁 ${viewsCount}
                                </span>
                            </div>
                        `;
                          } else {
                              slide = `
                            <div class="item story-item position-relative" style="height:600px; background:#000; color:#fff; font-size:20px; text-align:center;"
                                data-story-id="${story.id}" data-user-id="${data.user_id}">
                                <p class="p-3">${story.content ?? ''}</p>
                                <span class="story-views position-absolute text-white px-2 py-1" style="bottom:10px; right:10px; background:rgba(0,0,0,0.5); border-radius:12px; font-size:14px;">
                                    👁 ${viewsCount}
                                </span>
                            </div>
                        `;
                          }

                          slider.innerHTML += slide;
                      });

                      // ✅ Reset Owl Carousel
                      if ($(slider).hasClass('owl-loaded')) {
                          $(slider).trigger('destroy.owl.carousel');
                          $(slider).removeClass('owl-loaded');
                          $(slider).find('.owl-stage-outer').children().unwrap();
                      }

                      // Initialize Owl Carousel
                      $(slider).owlCarousel({
                          items: 1,
                          loop: true,
                          margin: 10,
                          nav: true,
                          dots: true,
                          autoplay: true,
                          autoplayTimeout: 6000, // 6 seconds per story
                          autoplayHoverPause: true,
                      });

                  } else {
                      slider.innerHTML = '<p class="text-white p-3">No stories found</p>';
                  }
              });
      });

      //adding story comments
      $(document).on("click", "#sendStoryComment", function(e) {
          e.preventDefault();

          let comment = $("#storyCommentInput").val().trim();
          if (!comment) return;

          let activeSlide = $(".story-slider .owl-item.active .item [data-story-id]");
          if (activeSlide.length === 0) {
              alert("No story selected.");
              return;
          }

          let storyId = activeSlide.data("story-id");

          $.ajax({
              url: "/add-story-comment/" + storyId, // ✅ storyId in URL
              type: "POST",
              data: {
                  _token: "{{ csrf_token() }}", // ✅ CSRF
                  content: comment
              },
              success: function(response) {

                  $("#storyCommentInput").val("");
              },
              error: function(xhr) {
                  console.error("❌ AJAX error:", xhr.status, xhr.responseText);
              }
          });
      });
  </script>





  @stack('scripts')
  </body>

  </html>
