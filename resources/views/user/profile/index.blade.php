@extends('layout.main')
@section('content')
    <!-- main content -->
    @push('styles')
        <style>
            .post-gallery-row .gallery-img {
                height: 150px;
                /* fixed height */
                object-fit: cover;
                /* crop image without distortion */
                object-position: top;
                /* focus on top */
            }
        </style>
    @endpush
    @push('title')
        <title>Sociala. user-profile</title>
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

                                @if ($user->id == auth_user()->id)
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
                                @endif
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
                                    @if ($user->id == auth_user()->id)
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
                                    @endif
                                </figure>

                                <h4 class="fw-700 font-sm mt-2 mb-lg-5 mb-4 pl-15">{{ $user->name }}
                                    @php
                                        $friends_count = count($friends);
                                    @endphp
                                    <span
                                        class="fw-500 font-xssss text-grey-500 mt-1 mb-3 d-block">{{ $friends_count . ' friends' }}</span>
                                </h4>
                                <div
                                    class="d-flex align-items-center justify-content-center position-absolute-md right-15 top-0 me-2">


                                    @if ($user->id === auth()->id())
                                        {{-- If logged-in user is viewing their own profile --}}
                                        <button onclick="toggleEditCard(true)"
                                            class="d-none d-lg-block bg-success p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3">
                                            Edit Profile
                                        </button>
                                    @else
                                        @if ($checkFriend && $checkFriend->sender_id == auth()->id() && $checkFriend->status == 'pending')
                                            {{-- Logged-in user already sent a request --}}
                                            <a href="javascript:void(0);"
                                                data-url="{{ route('user.cancel.request', $user->id) }}"
                                                class="cancel-request bg-dark p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3">
                                                Cancel Request
                                            </a>
                                        @elseif ($checkFriend && $checkFriend->status == 'accepted')
                                            {{-- They are already friends --}}
                                            <a href="javascript:void(0);"
                                                data-url="{{ route('user.unfriend.request', $user->id) }}"
                                                class="un-friend bg-dark p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3 mx-1">
                                                Unfriend
                                            </a>
                                        @else
                                            {{-- No friendship exists yet --}}
                                            <a href="javascript:void(0);"
                                                data-url="{{ route('user.send.request', $user->id) }}"
                                                class="send-request bg-success p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3">
                                                Add Friend
                                            </a>
                                        @endif

                                        <a href="#"
                                            class="d-none d-lg-block bg-greylight btn-round-lg ms-2 rounded-3 text-grey-700">
                                            <i class="feather-mail font-md"></i>
                                        </a>
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
                                    <li class="active list-inline-item me-5"><a
                                            class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block active"
                                            href="{{ route('user.profile.ajax', $user->id) }}" id="about_section"
                                            data-toggle="tab">About</a>
                                    </li>
                                    <li class="list-inline-item me-5"><a
                                            class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs2" data-toggle="tab">Friends</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs3" data-toggle="tab">Discussion</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs4" data-toggle="tab">Video</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs3" data-toggle="tab">Group</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs1" data-toggle="tab">Events</a></li>
                                    <li class="list-inline-item me-5"><a id="tab-photos"
                                            class="link fw-700 me-sm-5 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="{{ route('user.profile.photos', $user->id) }}" data-toggle="tab">
                                            Photos
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    {{-- abbout nav tab below --}}
                    <div id="tabContent" class="mt-3">
                        @include('user.profile.nav.about')
                    </div>


                </div>
            </div>

        </div>
    </div>
    <!-- main content -->

    @push('scripts')
        <script>
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
        </script>
    @endpush


@endsection
