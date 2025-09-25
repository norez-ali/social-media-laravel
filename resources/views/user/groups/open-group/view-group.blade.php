 @push('title')
     <title>view-group</title>
 @endpush
 <div class="main-content right-chat-active">

     <div class="middle-sidebar-bottom">
         <div class="middle-sidebar-left">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card w-100 border-0 p-0 bg-white shadow-xss rounded-xxl">
                         <div class="card-body h250 p-0 rounded-xxl overflow-hidden m-3 relative">
                             <!-- Cover Image -->
                             @if ($group->cover_photo)
                                 <img src="{{ asset('storage/' . $group->cover_photo) }}" alt="Cover Photo"
                                     class="cover-photo w-full h-[300px] rounded-xl border object-cover"
                                     id="group-cover-photo">
                             @else
                                 <img src="{{ asset('assets/images/u-bg.jpg') }}" alt="Cover Photo"
                                     class="w-full h-[300px] rounded-xl border object-cover" id="group-cover-photo">
                             @endif

                             @if ($currentUser && $currentUser->pivot->role === 'admin')
                                 <!-- Edit Cover Button + Form -->
                                 <form action="{{ route('admin.update.group.cover', $group->id) }}" method="POST"
                                     enctype="multipart/form-data" class="absolute bottom-3 right-3 ajax-form">
                                     @csrf
                                     @method('PUT')

                                     <!-- Hidden File Input -->
                                     <input type="file" name="cover_photo" id="cover_photo" class="hidden">

                                     <!-- Custom Button -->
                                     <label for="cover_photo"
                                         class="flex items-center bg-gray-600 bg-opacity-50 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-opacity-70">
                                         <i class="feather-camera me-2"></i>
                                         Edit Cover
                                     </label>
                                 </form>
                             @endif
                         </div>
                         <div class="mt-2 mb-4 px-6 flex items-center justify-between">
                             <!-- Left Side: Group Info -->
                             <div>
                                 <h2 class="text-black text-2xl font-bold">{{ $group->name }}</h2>

                                 <div class="flex items-center space-x-2 text-gray-600 text-sm mt-1">
                                     <span class="capitalize">{{ $group->privacy }} Group</span>
                                     <span>•</span>
                                     <span>{{ $group->members->count() }} members</span>
                                 </div>
                             </div>

                             <!-- Right Side: Buttons -->
                             <div class="flex space-x-2 mr-4">
                                 {{-- Not a member yet --}}
                                 @if (!$currentUser && $group->privacy === 'private')
                                     <a href="{{ route('user.join.group', $group->id) }}"
                                         data-leave-url="{{ route('user.leave.group', $group->id) }}"
                                         class="join-group bg-success text-white px-4 py-2 rounded-lg font-semibold hover:opacity-90">
                                         Request to Join
                                     </a>
                                 @elseif(!$currentUser)
                                     <a href="{{ route('user.join.group', $group->id) }}"
                                         data-leave-url="{{ route('user.leave.group', $group->id) }}"
                                         class="join-group bg-success text-white px-4 py-2 rounded-lg font-semibold hover:opacity-90">
                                         Join
                                     </a>
                                 @elseif ($currentUser->pivot->status === 'pending')
                                     {{-- Pending approval --}}
                                     <a href="{{ route('user.join.group', $group->id) }}"
                                         data-leave-url="{{ route('user.leave.group', $group->id) }}"
                                         class="leave-group bg-dark text-white px-4 py-2 rounded-lg font-semibold hover:opacity-90">
                                         Withdraw Request
                                     </a>
                                 @elseif ($currentUser->pivot->status === 'approved')
                                     {{-- Member (approved) --}}
                                     @if ($currentUser->pivot->role === 'admin')
                                         <a href="{{ route('admin.delete.group', $group->id) }}"
                                             data-url="{{ route('admin.delete.group', $group->id) }}"
                                             class="delete-group bg-dark text-white px-4 py-2 rounded-lg font-semibold hover:opacity-90">
                                             Delete & Leave
                                         </a>
                                     @else
                                         <a href="{{ route('user.join.group', $group->id) }}"
                                             data-leave-url="{{ route('user.leave.group', $group->id) }}"
                                             class="leave-group bg-dark text-white px-4 py-2 rounded-lg font-semibold hover:opacity-90">
                                             Leave
                                         </a>
                                     @endif
                                 @endif
                             </div>


                         </div>




                         <div class="card-body d-block w-100 shadow-none mb-0 p-0 border-top-xs">
                             <ul class="nav nav-tabs h55 d-flex product-info-tab border-bottom-0 ps-4" id="pills-tab"
                                 role="tablist">

                                 <li class="active list-inline-item me-5">
                                     <a class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block active"
                                         href="" id="about_section" data-toggle="tab">About</a>
                                 </li>

                                 <li class="list-inline-item me-5">
                                     <a class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="" data-toggle="tab">Friends</a>
                                 </li>

                                 <li class="list-inline-item me-5">
                                     <a class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="#navtabs3" data-toggle="tab">Discussion</a>
                                 </li>

                                 <li class="list-inline-item me-5">
                                     <a class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="#navtabs4" data-toggle="tab">Video</a>
                                 </li>

                                 <li class="list-inline-item me-5">
                                     <a class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="#navtabs3" data-toggle="tab">Group</a>
                                 </li>

                                 <li class="list-inline-item me-5">
                                     <a class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="#navtabs1" data-toggle="tab">Events</a>
                                 </li>

                                 <li class="list-inline-item me-5">
                                     <a id="tab-photos"
                                         class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="" data-toggle="tab">Photos</a>
                                 </li>

                                 @if ($group->privacy === 'private' && $currentUser && $currentUser->pivot->role === 'admin')
                                     <li class="list-inline-item me-5">
                                         <a id="tab-requests"
                                             class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                             href="{{ route('admin.view.requests', $group->id) }}"
                                             data-toggle="tab">Requests</a>
                                     </li>
                                 @endif
                             </ul>
                         </div>
                     </div>
                 </div>
                 {{-- abbout nav tab below --}}
                 @if ($group->privacy === 'private')
                     @if (!$currentUser)
                         <div class="mt-3">
                             <h4 class="ml-4 text-gray-700 text-base font-medium">
                                 🔒 Private group. Join to see posts
                             </h4>
                         </div>
                     @elseif ($currentUser->pivot->status === 'pending')
                         <div class="mt-3">
                             <h4 class="ml-4 text-yellow-600 text-base font-medium">
                                 ⏳ Your request to join is pending approval
                             </h4>
                         </div>
                     @elseif ($currentUser->pivot->status === 'approved')
                         <div id="tabContent" class="mt-3">
                             <h4 class="ml-4 text-black text-base font-semibold">See posts</h4>

                             {{-- posts listing goes here --}}
                         </div>
                     @endif
                 @else
                     <div id="tabContent" class="mt-3">
                         <h4 class="ml-4 text-black text-base font-semibold">See posts</h4>
                         {{-- posts listing goes here --}}
                     </div>
                 @endif




             </div>
         </div>

     </div>
 </div>
 @push('scripts')
     <script>
         //for toggling tabs
         $(document).ready(function() {
             $(".nav-tabs a").on("click", function(e) {
                 e.preventDefault();

                 var url = $(this).attr("href"); // get href
                 if (!url || url.startsWith("#")) return; // skip empty or #

                 // remove active class
                 $(".nav-tabs a").removeClass("active");
                 $(this).addClass("active");

                 // show loader
                 $("#tabContent").html('<div class="text-center p-5">Loading...</div>');

                 // AJAX request
                 $.ajax({
                     url: url,
                     type: "GET",
                     success: function(response) {
                         $("#tabContent").html(response);
                     },
                     error: function() {
                         $("#tabContent").html(
                             '<div class="text-danger p-3">Failed to load content.</div>');
                     }
                 });
             });

             // Optional: load first tab automatically
             $(".nav-tabs a.active").trigger("click");
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
                             .addClass("bg-success join-group");
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
         //to update the group cover
         $(document).on("change", "#cover_photo", function(e) {
             e.preventDefault();

             let form = $(this).closest("form")[0];
             let formData = new FormData(form);

             $.ajax({
                 url: $(form).attr("action"),
                 type: "POST",
                 data: formData,
                 processData: false,
                 contentType: false,
                 success: function(response) {
                     if (response.cover_photo_url) {
                         // Replace the cover photo
                         $("#group-cover-photo").attr("src", response.cover_photo_url);
                     }


                 },
                 error: function(xhr) {
                     console.error(xhr.responseText);
                     alert("Something went wrong while updating cover photo!");
                 }
             });
         });
         //approve the request
         $(document).on("click", ".approve-request", function(e) {
             e.preventDefault();

             let groupId = $(this).data("group-id");
             let userId = $(this).data("user-id");
             $.ajax({
                 url: "{{ route('user.approve.request') }}", // your Laravel route
                 type: "POST",
                 data: {
                     _token: $('meta[name="csrf-token"]').attr("content"),
                     group_id: groupId,
                     user_id: userId
                 },
                 success: function(res) {


                 },
                 error: function(xhr) {
                     console.error(xhr.responseText);
                 }
             });
         });

         // Reject group join request
         // Reject
         $(document).on("click", ".reject-request", function(e) {
             e.preventDefault();
             let groupId = $(this).data("group-id");
             let userId = $(this).data("user-id");

             $.ajax({
                 url: "{{ route('user.reject.request') }}",
                 type: "POST",
                 data: {
                     _token: $('meta[name="csrf-token"]').attr("content"),
                     group_id: groupId,
                     user_id: userId
                 },
                 success: function(res) {
                     $(e.target).closest(".card").remove();
                 }
             });
         });
     </script>
 @endpush
