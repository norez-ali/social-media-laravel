 @push('scripts')
     <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
     <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
     <script>
         $(document).ready(function() {
             $(".owl-carousel").owlCarousel({
                 loop: true,
                 margin: 10,
                 nav: true,
                 responsive: {
                     0: {
                         items: 2,
                     },
                     600: {
                         items: 4,
                     },
                     1000: {
                         items: 6,
                     },
                 },
             });
         });
         // AJAX for deleting a post
         $(document).on("submit", ".delete-post-form", function(e) {
             e.preventDefault(); // stop normal form submission

             let form = $(this);
             let url = form.attr("action");
             let postId = form.data("id");

             $.ajax({
                 url: url,
                 type: "POST", // Laravel needs POST + _method=DELETE
                 data: form.serialize(),
                 success: function(response) {
                     if (response.success) {
                         $("#post-" + postId).remove(); // remove deleted post card
                     }
                 },
                 error: function(xhr) {
                     alert("Something went wrong while deleting the post.");
                     console.log(xhr.responseText);
                 },
             });
         });
         //Ajax for liking a post
         $(document).on("click", ".like-btn", function(e) {
             e.preventDefault();

             let button = $(this);
             let postId = button.data("id");

             $.ajax({
                 url: "/post-like/" + postId,
                 type: "POST",
                 data: {
                     _token: $('meta[name="csrf-token"]').attr("content"),
                 },
                 success: function(response) {
                     let countElem = button.find(".like-count");

                     // Update count
                     if (response.count > 0) {
                         if (countElem.length) {
                             countElem.text(response.count);
                         } else {
                             button.append(
                                 '<span class="like-count ms-1">' +
                                 response.count +
                                 "</span>"
                             );
                         }
                     } else {
                         countElem.remove();
                     }

                     // Update text + icon
                     if (response.liked) {
                         button.find(".like-text").text("Liked");
                         button
                             .find("i")
                             .removeClass("bg-white text-grey-900 border")
                             .addClass("bg-primary-gradiant text-white");
                     } else {
                         button.find(".like-text").text("Like");
                         button
                             .find("i")
                             .removeClass("bg-primary-gradiant text-white")
                             .addClass("bg-white text-grey-900 border");
                     }
                 },
             });
         });

         //Ajax for Comments
         function toggleComments(show) {
             $("#commentsPopup").toggleClass("d-none", !show);
         }
         // AJAX for comment form
         $(document).ready(function() {
             $("#commentForm").on("submit", function(e) {
                 e.preventDefault();

                 let form = $(this);
                 let url = form.attr("action");
                 let commentText = $("#newComment").val();

                 if (commentText.trim() === "") return;

                 $.ajax({
                     url: url,
                     type: "POST",
                     data: form.serialize(),
                     success: function(response) {
                         if (response.success) {
                             let commentHtml = `
                        <div class="d-flex mb-3">
                            <img src="${response.comment.profile_photo}"
                                 class="rounded-circle me-2"
                                 style="width:40px; height:40px; object-fit:cover; object-position:top;"
                                 alt="user">
                            <div>
                                <div class="bg-light p-2 rounded">
                                    <strong>${response.comment.user_name}</strong><br>
                                    ${response.comment.text}
                                </div>
                                <small class="text-muted">${response.comment.time}</small>
                            </div>
                        </div>
                    `;

                             // Append instantly
                             $("#commentsList").append(commentHtml);

                             // Clear input
                             $("#newComment").val("");
                         }
                     },
                     error: function() {
                         alert("Failed to add comment. Please try again.");
                     },
                 });
             });
         });
         // AJAX for deleting a comment
         $(document).ready(function() {
             $(".delete-comment-form").on("submit", function(e) {
                 e.preventDefault();

                 let form = $(this);
                 let actionUrl = form.attr("action");
                 let token = form.find('input[name="_token"]').val();
                 let commentDiv = form.closest('[id^="comment-"]');

                 $.ajax({
                     url: actionUrl,
                     type: "POST",
                     data: {
                         _token: token,
                         _method: "DELETE",
                     },
                     success: function(response) {
                         if (response.success) {
                             commentDiv.fadeOut(300, function() {
                                 $(this).remove();
                             });
                         } else {
                             alert(response.error || "Failed to delete comment.");
                         }
                     },
                     error: function() {
                         alert("Something went wrong.");
                     },
                 });
             });
         });
         // Open/closestory popup
         function toggleStoryPopup(show) {
             if (show) {
                 $("#storyPopup").removeClass("hidden");
             } else {
                 $("#storyPopup").addClass("hidden");
                 $("#photoStoryForm, #textStoryForm").addClass("hidden");
                 $("#storyOptions").removeClass("hidden");
                 $("#previewMedia").addClass("hidden").empty(); // reset preview
             }
         }

         // Show photo form
         function openPhotoStoryForm() {
             $("#storyOptions").addClass("hidden");
             $("#photoStoryForm").removeClass("hidden");
         }

         // Show text form
         function openTextStoryForm() {
             $("#storyOptions").addClass("hidden");
             $("#textStoryForm").removeClass("hidden");
         }

         // Trigger hidden input on card click
         $("#selectMediaCard").on("click", function() {
             $("#mediaInput").click();
         });

         // Preview + add remove cross
         $("#mediaInput").on("change", function(e) {
             let file = e.target.files[0];
             if (!file) return;

             let preview = $("#mediaPreview");
             preview.removeClass("hidden").empty();

             let url = URL.createObjectURL(file);

             // Hide card
             $("#selectMediaCard").addClass("hidden");

             // Add media preview
             if (file.type.startsWith("image/")) {
                 preview.append(
                     `<img src="${url}" class="w-full h-full object-cover rounded-lg" />`
                 );
             } else if (file.type.startsWith("video/")) {
                 preview.append(
                     `<video src="${url}" controls class="w-full h-full object-cover rounded-lg"></video>`
                 );
             }

             // Add remove button (inside preview corner)
             preview.append(`
        <button id="removeMediaBtn" type="button"
            class="absolute top-2 right-2 bg-white text-gray-800 rounded-full w-7 h-7 flex items-center justify-center shadow-md hover:bg-red-500 hover:text-white transition">
            &times;
        </button>
    `);
         });

         // Remove media & reset
         $(document).on("click", "#removeMediaBtn", function() {
             $("#mediaInput").val(""); // clear input
             $("#mediaPreview").addClass("hidden").empty(); // clear preview
             $("#selectMediaCard").removeClass("hidden"); // show card back
         });

         // ✅ AJAX for Photo/Video Story
         $("#photoStoryForm").on("submit", function(e) {
             e.preventDefault();
             let formData = new FormData(this);

             $.ajax({
                 url: "{{ route('user.add.story') }}",
                 type: "POST",
                 data: formData,
                 contentType: false,
                 processData: false,
                 headers: {
                     "X-CSRF-TOKEN": "{{ csrf_token() }}",
                 },
                 success: function(response) {
                     toggleStoryPopup(false);
                 },
                 error: function(xhr) {
                     console.error(xhr.responseText);
                 },
             });
         });

         // ✅ AJAX for Text Story
         $("#textStoryForm").on("submit", function(e) {
             e.preventDefault();
             let formData = new FormData(this);

             $.ajax({
                 url: "{{ route('user.add.story') }}",
                 type: "POST",
                 data: formData,
                 contentType: false,
                 processData: false,
                 headers: {
                     "X-CSRF-TOKEN": "{{ csrf_token() }}",
                 },
                 success: function(response) {
                     toggleStoryPopup(false);
                 },
                 error: function(xhr) {
                     console.error(xhr.responseText);
                 },
             });
         });
         //send friend request
         document.addEventListener("DOMContentLoaded", function() {
             document.querySelectorAll(".send-request").forEach(function(button) {
                 button.addEventListener("click", function(e) {
                     e.preventDefault();

                     let url = this.getAttribute("data-url");
                     let btn = this; // keep reference to clicked button

                     fetch(url, {
                             method: "POST",
                             headers: {
                                 "X-CSRF-TOKEN": document.querySelector(
                                     'meta[name="csrf-token"]').getAttribute("content"),
                                 "Content-Type": "application/json",
                             },
                             body: JSON.stringify({}) // user_id already passed in route
                         })
                         .then(response => response.json())
                         .then(data => {
                             if (data.success) {
                                 // ✅ Replace "Add Friend" button with "Cancel Request"
                                 btn.outerHTML = `
                        <a href="javascript:void(0);"
                            data-url="${btn.getAttribute("data-url").replace('send.request', 'cancel.request')}"
                            class="cancel-request text-center p-2 lh-20 w100 ms-1 ls-3 d-inline-block rounded-xl bg-dark font-xsssss fw-700 ls-lg text-white">
                            Cancel
                        </a>
                    `;
                             } else {
                                 alert(data.error);
                             }
                         })
                         .catch(error => console.error("Error:", error));
                 });
             });
         });
     </script>
 @endpush
