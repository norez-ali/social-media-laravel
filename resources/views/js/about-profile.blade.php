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
         //Ajax for liking a post
         $(document).on('click', '.like-btn', function(e) {
             e.preventDefault();

             let button = $(this);
             let postId = button.data('id');

             $.ajax({
                 url: '/post-like/' + postId,
                 type: 'POST',
                 data: {
                     _token: $('meta[name="csrf-token"]').attr('content')
                 },
                 success: function(response) {
                     let countElem = button.find('.like-count');

                     // Update count
                     if (response.count > 0) {
                         if (countElem.length) {
                             countElem.text(response.count);
                         } else {
                             button.append('<span class="like-count ms-1">' + response.count +
                                 '</span>');
                         }
                     } else {
                         countElem.remove();
                     }

                     // Update text + icon
                     if (response.liked) {
                         button.find('.like-text').text('Liked');
                         button.find('i')
                             .removeClass('bg-white text-grey-900 border')
                             .addClass('bg-primary-gradiant text-white');
                     } else {
                         button.find('.like-text').text('Like');
                         button.find('i')
                             .removeClass('bg-primary-gradiant text-white')
                             .addClass('bg-white text-grey-900 border');
                     }
                 }
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
                     }
                 });
             });
         });
         // AJAX for deleting a comment
         $(document).ready(function() {
             $('.delete-comment-form').on('submit', function(e) {
                 e.preventDefault();



                 let form = $(this);
                 let actionUrl = form.attr('action');
                 let token = form.find('input[name="_token"]').val();
                 let commentDiv = form.closest('[id^="comment-"]');

                 $.ajax({
                     url: actionUrl,
                     type: 'POST',
                     data: {
                         _token: token,
                         _method: 'DELETE'
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
                     }
                 });
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
                            class="cancel-request bg-dark p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3">
                            Cancel Request
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
         //handles cancel requests

         document.addEventListener("DOMContentLoaded", function() {
             document.querySelectorAll(".cancel-request").forEach(function(button) {
                 button.addEventListener("click", function(e) {
                     e.preventDefault();

                     let url = this.getAttribute("data-url");
                     let btn = this; // reference to clicked button

                     fetch(url, {
                             method: "POST",
                             headers: {
                                 "X-CSRF-TOKEN": document.querySelector(
                                     'meta[name="csrf-token"]').getAttribute("content"),
                                 "Content-Type": "application/json",
                             },
                             body: JSON.stringify({})
                         })
                         .then(response => response.json())
                         .then(data => {
                             if (data.success) {
                                 // ✅ Replace "Cancel Request" with "Add Friend"
                                 btn.outerHTML = `
                        <a href="javascript:void(0);"
                            data-url="${btn.getAttribute("data-url").replace('cancel.request', 'send.request')}"
                           class="send-request bg-success p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3">
                           Add Friend
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
         //unfriend
         $(document).on("click", ".un-friend", function(e) {
             e.preventDefault();

             let button = $(this);
             let url = button.data("url");

             $.ajax({
                 url: url,
                 type: "POST",
                 data: {
                     _token: "{{ csrf_token() }}",
                 },
                 success: function(response) {
                     // Replace Unfriend button with Add Friend button
                     button.replaceWith(`
                <a href="javascript:void(0);"
                   data-url="/send-request/${response.user_id}"
                   class="send-request bg-success p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3">
                   Add Friend
                </a>
            `);
                 },
                 error: function() {
                     alert("Something went wrong. Try again.");
                 }
             });
         });
     </script>
 @endpush
