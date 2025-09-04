@extends('layout.main')
@push('title')
    <title>Sociala. user-photos</title>
@endpush
<div class="main-content right-chat-active">

    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card w-100 border-0 p-0 bg-white shadow-xss rounded-xxl">
                        <div class="card-body h250 p-0 rounded-xxl overflow-hidden m-3 relative">
                            <!-- Cover Image -->
                            @if ($user->profile->cover_photo)
                                <img src="{{ asset('storage/cover_photos/' . $user->profile->cover_photo) }}"
                                    alt="Cover Photo" class="cover-photo w-full h-[250px] rounded-xl border object-cover">
                            @else
                                <img src="{{ asset('assets/images/u-bg.jpg') }}" alt="Cover Photo"
                                    class="w-full h-[250px] rounded-xl border object-cover">
                            @endif

                            <!-- Edit Cover Button + Form -->
                            <form action="{{ route('user.updateProfile') }}" method="POST"
                                enctype="multipart/form-data" class="absolute bottom-3 right-3 ajax-form">
                                @csrf
                                @method('PUT')

                                <!-- Hidden File Input -->
                                <input type="file" name="cover_photo" id="cover_photo" class="hidden"
                                    onchange="$(this).closest('form').submit()">

                                <!-- Custom Button -->
                                <label for="cover_photo"
                                    class="flex items-center bg-gray-600 bg-opacity-50 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-opacity-70">
                                    <i class="feather-camera me-2"></i>
                                    Edit Cover
                                </label>
                            </form>
                        </div>

                        <div class="card-body p-0 position-relative">
                            <figure class="avatar position-absolute w100 z-index-1" style="top:-40px; left: 30px;">

                                @if ($user->profile->profile_photo)
                                    <img src="{{ asset('storage/profile_photos/' . $user->profile->profile_photo) }}"
                                        alt="Profile"
                                        class="profile-photo p-1 bg-white rounded-circle object-top object-cover"
                                        style="width:100px; height:100px;">
                                @else
                                    <img src="{{ asset('assets/images/user-12.png') }}" alt="Profile"
                                        class="p-1 bg-white rounded-circle object-top object-cover"
                                        style="width:100px; height:100px;">
                                @endif

                                <!-- Edit Profile Photo Button -->
                                <form action="{{ route('user.updateProfile') }}" method="POST"
                                    enctype="multipart/form-data"
                                    class="absolute bottom-0 right-0 transform translate-x-2 translate-y-2 ajax-form ">
                                    @csrf
                                    @method('PUT')

                                    <!-- Hidden File Input -->
                                    <input type="file" name="profile_photo" id="profile_photo" class="hidden"
                                        onchange="$(this).closest('form').submit()">

                                    <!-- Camera Icon Button -->
                                    <label for="profile_photo"
                                        class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-600 text-white cursor-pointer hover:bg-gray-800">
                                        <i class="feather-camera text-sm"></i>
                                    </label>
                                </form>
                            </figure>

                            <h4 class="fw-700 font-sm mt-2 mb-lg-5 mb-4 pl-15">{{ $user->name }} <span
                                    class="fw-500 font-xssss text-grey-500 mt-1 mb-3 d-block">{{ $user->email }}</span>
                            </h4>
                            <div
                                class="d-flex align-items-center justify-content-center position-absolute-md right-15 top-0 me-2">


                                @if ($user->id === auth_user()->id)
                                    {{-- If logged-in user is viewing their own profile --}}
                                    <button onclick="toggleEditCard(true)"
                                        class="d-none d-lg-block bg-success p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3">
                                        Edit Profile
                                    </button>
                                @else
                                    {{-- If viewing someone else’s profile --}}
                                    <a href="#"
                                        class="d-none d-lg-block bg-success p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3">
                                        Add Friend
                                    </a>
                                    <a href="#"
                                        class="d-none d-lg-block bg-greylight btn-round-lg ms-2 rounded-3 text-grey-700"><i
                                            class="feather-mail font-md"></i></a>
                                @endif
                                <!-- Edit Profile Card Starts here -->
                                <div id="editCardWrapper"
                                    class="hidden fixed inset-0 flex items-start justify-center bg-opacity-50 backdrop-blur-sm z-50 overflow-y-auto p-6">

                                    <!-- Card -->
                                    <div id="editCard"
                                        class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative transform transition-all duration-300 scale-95 overflow-y-auto max-h-[90vh]">

                                        <!-- Close button -->
                                        <button onclick="toggleEditCard(false)"
                                            class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">
                                            ✕
                                        </button>

                                        <!-- Profile Info -->
                                        <div class="profile_heading">
                                            <p class="text-xl font-bold text-center">Edit Profile</p>
                                            <hr>
                                        </div>
                                        <div class="profile_photo m-4">
                                            <p class=" font-bold text-xl ">Profile Photo</p>
                                            @if ($user->profile->profile_photo)
                                                <img src="{{ asset('storage/profile_photos/' . $user->profile->profile_photo) }}"
                                                    alt="Profile"
                                                    class=" profile-photo w-40 h-40 rounded-full border mx-auto block object-top object-cover">
                                            @else
                                                <img src="{{ asset('assets/images/user-12.png') }}" alt="Profile"
                                                    class="w-40 rounded-full border mx-auto block">
                                            @endif
                                            <form action="{{ route('user.updateProfile') }}" method="POST"
                                                enctype="multipart/form-data"
                                                class="ajax-form flex m-2 space-x-2 items-center justify-center">
                                                @csrf
                                                @method('PUT')

                                                <!-- Hidden file input -->
                                                <input type="file" id="imageInput" name="profile_photo"
                                                    accept="image/*" class="hidden">

                                                <!-- Custom choose file button -->
                                                <label for="imageInput"
                                                    class="h-10 px-6 flex items-center justify-center text-sm font-medium bg-white text-blue-500 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-100">
                                                    Choose File
                                                </label>

                                                <!-- Upload button -->
                                                <button type="submit"
                                                    class="h-10 px-4 text-sm font-medium bg-blue-500 text-white border border-blue-500 rounded-md hover:bg-blue-600">
                                                    Upload
                                                </button>
                                            </form>


                                        </div>
                                        <div class="cover_photo m-4">
                                            <p class="font-bold text-xl">Cover Photo</p>
                                            @if ($user->profile->cover_photo)
                                                <img src="{{ asset('storage/cover_photos/' . $user->profile->cover_photo) }}"
                                                    alt="Cover Photo"
                                                    class="cover-photo w-full h-40 rounded-xl border object-cover">
                                            @else
                                                <img src="{{ asset('assets/images/u-bg.jpg') }}" alt="Cover Photo"
                                                    class="w-full h-40 rounded-xl border object-cover">
                                            @endif
                                            <form action="{{ route('user.updateProfile') }}" method="POST"
                                                enctype="multipart/form-data"
                                                class="ajax-form flex m-2 space-x-2 items-center justify-center">
                                                @csrf
                                                @method('PUT')

                                                <!-- Hidden file input -->
                                                <input type="file" id="cover_photo" name="cover_photo"
                                                    accept="image/*" class="hidden">

                                                <!-- Custom choose file button -->
                                                <label for="cover_photo"
                                                    class="h-10 px-6 flex items-center justify-center text-sm font-medium bg-white text-blue-500 border border-gray-300 rounded-md cursor-pointer hover:bg-gray-100">
                                                    Choose File
                                                </label>

                                                <!-- Upload button -->
                                                <button type="submit"
                                                    class="h-10 px-4 text-sm font-medium bg-blue-500 text-white border border-blue-500 rounded-md hover:bg-blue-600">
                                                    Upload
                                                </button>
                                            </form>

                                        </div>
                                        <div class="bio m-4">
                                            <p class="font-bold text-xl">Bio</p>

                                            <form action="{{ route('user.updateProfile') }}" method="POST"
                                                class="ajax-form">
                                                @csrf
                                                @method('PUT')

                                                <textarea name="bio" id="bio" placeholder="Describe yourself"
                                                    class="profile-bio w-full min-h-[120px] border rounded-lg px-3 py-2 mt-2">{{ $user->profile->bio }}</textarea>

                                                <div class="flex justify-end mt-3">
                                                    <button type="submit"
                                                        class="h-10 px-6 text-sm font-medium bg-blue-500 text-white border border-blue-500 rounded-md hover:bg-blue-600">
                                                        Save Bio
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="featured m-4">
                                            <p class="font-bold text-xl">Featured</p>
                                            <img src="{{ asset('assets/images/featured.png') }}" alt=""
                                                class="w-full h-40 object-top rounded-xl  object-cover">

                                        </div>
                                    </div>
                                </div>
                                {{-- The Edit profile Card Ends Here --}}



                                <a href="#" id="dropdownMenu4"
                                    class="d-none d-lg-block bg-greylight btn-round-lg ms-2 rounded-3 text-grey-700"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                        class="ti-more font-md tetx-dark"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-4 rounded-xxl border-0 shadow-lg"
                                    aria-labelledby="dropdownMenu4">
                                    <div class="card-body p-0 d-flex">
                                        <i class="feather-bookmark text-grey-500 me-3 font-lg"></i>
                                        <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-0">Save Link <span
                                                class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Add this to
                                                your saved items</span></h4>
                                    </div>
                                    <div class="card-body p-0 d-flex mt-2">
                                        <i class="feather-alert-circle text-grey-500 me-3 font-lg"></i>
                                        <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-0">Hide Post <span
                                                class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Save to your
                                                saved items</span></h4>
                                    </div>
                                    <div class="card-body p-0 d-flex mt-2">
                                        <i class="feather-alert-octagon text-grey-500 me-3 font-lg"></i>
                                        <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-0">Hide all from Group <span
                                                class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Save to your
                                                saved items</span></h4>
                                    </div>
                                    <div class="card-body p-0 d-flex mt-2">
                                        <i class="feather-lock text-grey-500 me-3 font-lg"></i>
                                        <h4 class="fw-600 mb-0 text-grey-900 font-xssss mt-0 me-0">Unfollow Group <span
                                                class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Save to your
                                                saved items</span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body d-block w-100 shadow-none mb-0 p-0 border-top-xs">
                            <ul class="nav nav-tabs h55 d-flex product-info-tab border-bottom-0 ps-4" id="pills-tab"
                                role="tablist">
                                <li class="list-inline-item me-5">
                                    <a class="fw-700 font-xssss pt-3 pb-3 ls-1 d-inline-block {{ request()->routeIs('user.profile') ? 'active text-primary border-bottom' : 'text-grey-500' }}"
                                        href="{{ route('user.profile', auth_user()->id) }}">
                                        About
                                    </a>
                                </li>
                                <li class="list-inline-item me-5">
                                    <a class="fw-700 font-xssss pt-3 pb-3 ls-1 d-inline-block {{ request()->routeIs('user.profile.membership') ? 'active text-primary border-bottom' : 'text-grey-500' }}"
                                        href="">
                                        Membership
                                    </a>
                                </li>
                                <li class="list-inline-item me-5">
                                    <a class="fw-700 font-xssss pt-3 pb-3 ls-1 d-inline-block {{ request()->routeIs('user.profile.discussion') ? 'active text-primary border-bottom' : 'text-grey-500' }}"
                                        href="">
                                        Discussion
                                    </a>
                                </li>
                                <li class="list-inline-item me-5">
                                    <a class="fw-700 font-xssss pt-3 pb-3 ls-1 d-inline-block {{ request()->routeIs('user.profile.video') ? 'active text-primary border-bottom' : 'text-grey-500' }}"
                                        href="">
                                        Video
                                    </a>
                                </li>
                                <li class="list-inline-item me-5">
                                    <a class="fw-700 font-xssss pt-3 pb-3 ls-1 d-inline-block {{ request()->routeIs('user.profile.group') ? 'active text-primary border-bottom' : 'text-grey-500' }}"
                                        href="">
                                        Group
                                    </a>
                                </li>
                                <li class="list-inline-item me-5">
                                    <a class="fw-700 font-xssss pt-3 pb-3 ls-1 d-inline-block {{ request()->routeIs('user.profile.events') ? 'active text-primary border-bottom' : 'text-grey-500' }}"
                                        href="">
                                        Events
                                    </a>
                                </li>
                                <li class="list-inline-item me-5">
                                    <a class="fw-700 font-xssss pt-3 pb-3 ls-1 d-inline-block {{ request()->routeIs('user.profile.photos') ? 'active text-primary border-bottom' : 'text-grey-500' }}"
                                        href="{{ route('user.profile.photos') }}">
                                        Photos
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3">
                </div>
            </div>
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
                                                class="rounded-3 w-100 h-60 object-cover object-top shadow-sm"
                                                alt="User photo">
                                        </a>

                                        {{-- Dropdown for delete --}}
                                        @if ($user->id === auth_user()->id)
                                            <div class="dropdown position-absolute top-0 end-0 m-2">
                                                <a href="#" id="dropdownMenu{{ $post->id }}"
                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i
                                                        class="ti-more-alt text-grey-900 btn-round-md bg-greylight font-xss"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end p-2 rounded-xxl border-0 shadow-lg"
                                                    aria-labelledby="dropdownMenu{{ $post->id }}">
                                                    <form action="{{ route('user.delete.post', $post->id) }}"
                                                        method="POST" class="delete-post-form"
                                                        data-id="{{ $post->id }}">
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









        </div>
    </div>
</div>

</div>
</div>
<!-- main content -->
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
