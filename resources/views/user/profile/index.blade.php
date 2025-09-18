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
                                            class="fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block active"
                                            href="#navtabs1" data-toggle="tab">About</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs2" data-toggle="tab">Membership</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs3" data-toggle="tab">Discussion</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs4" data-toggle="tab">Video</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs3" data-toggle="tab">Group</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="#navtabs1" data-toggle="tab">Events</a></li>
                                    <li class="list-inline-item me-5"><a
                                            class="fw-700 me-sm-5 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                            href="{{ route('user.profile.photos') }}" data-toggle="tab">Photos</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-xxl-3 col-lg-4 pe-0">
                        <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3 mt-3">
                            <div class="card-body p-3 border-0">
                                <div class="row px-4">

                                    <div class="ps-1 flex-1">
                                        <h4 class="profile-work font-xsss d-block fw-700 mt-2 mb-0">
                                            {{ $user->profile->work ?? 'No position added yet!' }}
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3">
                            {{-- About card starts here --}}
                            <div class="card-body d-block p-4">
                                <h4 class="fw-700 mb-3 font-xsss text-grey-900">About</h4>

                                <!-- Bio Section -->
                                <div id="bioDisplay">
                                    @if ($user->profile->bio)
                                        <p
                                            class="profile-bio fw-500 text-grey-500 lh-24 font-xssss mb-2 border rounded-lg p-2">
                                            {{ $user->profile->bio }}
                                        </p>
                                    @else
                                        <p class="fw-500 text-grey-500 lh-24 font-xssss mb-2 border rounded-lg p-2">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi nulla dolor,
                                            ornare at commodo non,
                                            feugiat non nisi. Phasellus faucibus mollis pharetra. Proin blandit ac massa sed
                                            rhoncus
                                        </p>
                                    @endif
                                    @if ($user->id == auth_user()->id)
                                        <button onclick="toggleBioEdit(true)"
                                            class="w-full bg-gray-300 rounded-lg hover:bg-gray-400">
                                            Edit Bio
                                        </button>
                                    @endif
                                </div>

                                <!-- Editable Form (hidden by default) -->
                                <div id="bioEdit" class="hidden">
                                    <form action="{{ route('user.updateProfile') }}" method="POST" class="ajax-form">
                                        @csrf
                                        @method('PUT')

                                        <textarea name="bio" id="bio" placeholder="Describe yourself"
                                            class="profile-bio w-full min-h-[120px] border rounded-lg px-3 py-2 mt-2">{{ $user->profile->bio }}</textarea>

                                        <div class="flex justify-end mt-3 space-x-2">
                                            <!-- Cancel button -->
                                            <button type="button" onclick="toggleBioEdit(false)"
                                                class="h-10 px-6 text-sm font-medium bg-gray-300 text-gray-800 border border-gray-400 rounded-md hover:bg-gray-400">
                                                Cancel
                                            </button>

                                            <!-- Save button -->
                                            <button type="submit"
                                                class="h-10 px-6 text-sm font-medium bg-blue-500 text-white border border-blue-500 rounded-md hover:bg-blue-600">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Static Display -->
                                @if ($user->id == auth_user()->id)
                                    <div id="detailsDisplay" class="mb-2">

                                        <button onclick="toggleDetailsEdit(true)"
                                            class="w-full bg-gray-300 rounded-lg hover:bg-gray-400 mt-2">
                                            Edit Details
                                        </button>
                                    </div>
                                @endif

                                <!-- Editable Form -->
                                <div id="detailsEdit" class="hidden">
                                    <form action="{{ route('user.updateProfile') }}" method="POST" class="ajax-form">
                                        @csrf
                                        @method('PUT')

                                        <div class="mb-2">
                                            <label class="block text-sm font-medium">Gender</label>
                                            <input type="text" name="gender" value="{{ $user->profile->gender }}"
                                                class="profile-gender w-full border rounded-lg px-3 py-2 mt-1">
                                        </div>

                                        <div class="mb-2">
                                            <label class="block text-sm font-medium">Location</label>
                                            <input type="text" name="location" value="{{ $user->profile->location }}"
                                                class="profile-location w-full border rounded-lg px-3 py-2 mt-1">
                                        </div>

                                        <div class="mb-2">
                                            <label class="block text-sm font-medium">Education</label>
                                            <input type="text" name="education"
                                                value="{{ $user->profile->education }}"
                                                class="profile-education w-full border rounded-lg px-3 py-2 mt-1">
                                        </div>

                                        <div class="mb-2">
                                            <label class="block text-sm font-medium">Work</label>
                                            <input type="text" name="work" value="{{ $user->profile->work }}"
                                                class="profile-work w-full border rounded-lg px-3 py-2 mt-1">
                                        </div>

                                        <div class="flex justify-end gap-2 mt-3 mb-2">
                                            <button type="button" onclick="toggleDetailsEdit(false)"
                                                class="h-10 px-6 text-sm font-medium bg-gray-300 border rounded-md hover:bg-gray-400">
                                                Cancel
                                            </button>
                                            <button type="submit"
                                                class="h-10 px-6 text-sm font-medium bg-blue-500 text-white border border-blue-500 rounded-md hover:bg-blue-600">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                @if ($user->id == auth_user()->id)
                                    <!-- Add Featured Button -->
                                    <div class="add_featured ">
                                        <button onclick="toggleFeaturedCard(true)"
                                            class="w-full bg-gray-300 rounded-lg hover:bg-gray-400">
                                            Add Featured
                                        </button>

                                        <!-- Featured Popup -->
                                        <div id="featuredCardWrapper"
                                            class="hidden fixed inset-0 flex items-center justify-center bg-opacity-50 backdrop-blur-sm z-50 p-6">

                                            <!-- Card -->
                                            <div id="featuredCard"
                                                class="bg-white rounded-2xl shadow-lg w-full max-w-md p-6 relative transform transition-all duration-300 scale-95">

                                                <!-- Close button -->
                                                <button onclick="toggleFeaturedCard(false)"
                                                    class="absolute top-3 right-3 text-gray-500 hover:text-gray-800 text-xl font-bold">
                                                    ✕
                                                </button>

                                                <!-- Heading -->
                                                <div class="profile_heading mb-4">
                                                    <p class="text-xl font-bold text-center">Add Featured</p>
                                                    <hr>
                                                </div>

                                                <!-- Featured Form -->
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <label class="block font-semibold mb-2">Upload Post / Image</label>
                                                    <input type="file" name="featured" accept="image/*"
                                                        class="w-full border rounded-md px-3 py-2 mb-4">

                                                    <label class="block font-semibold mb-2">Description</label>
                                                    <textarea name="description" placeholder="Write something..."
                                                        class="w-full min-h-[100px] border rounded-md px-3 py-2 mb-4"></textarea>

                                                    <div class="flex justify-end">
                                                        <button type="submit"
                                                            class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                                            Save Featured
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>



                            <div class="card-body border-top-xs d-flex">
                                <i class="feather-briefcase text-grey-500 me-3 font-lg"></i>
                                <h4 class="profile-work fw-700 text-grey-900 font-xssss mt-2">
                                    {{ $user->profile->work ?? 'No Work Added' }}
                                </h4>
                            </div>

                            <div class="card-body d-flex pt-0">
                                <i class="feather-book text-grey-500 me-3 font-lg"></i>

                                <h4 class="profile-education fw-700 text-grey-900 font-xssss mt-1">
                                    {{ $user->profile->education ?? 'No Education Added' }} <br>

                                </h4>
                            </div>

                            <div class="card-body d-flex pt-0">
                                <i class="feather-map-pin text-grey-500 me-3 font-lg"></i>
                                <h4 class="profile-location fw-700 text-grey-900 font-xssss mt-1">
                                    {{ $user->profile->location ?? 'No Location Added' }}</h4>
                            </div>

                            <div class="card-body d-flex pt-0">
                                <i class="feather-user text-grey-500 me-3 font-lg"></i>

                                <h4 class="profile-gender fw-700 text-grey-900 font-xssss mt-1">
                                    {{ $user->profile->gender ?? 'No Gender Added' }}</h4>
                            </div>
                        </div>
                        {{-- About card ends here --}}
                        <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3">
                            <div class="card-body d-flex align-items-center  p-4">
                                <h4 class="fw-700 mb-0 font-xssss text-grey-900">Photos</h4>
                                <a href="{{ route('user.profile.photos') }}"
                                    class="fw-600 ms-auto font-xssss text-primary">See all</a>
                            </div>
                            <div class="card-body d-block pt-0 pb-2">
                                <div class="row post-gallery-row">
                                    @forelse ($user->posts as $post)
                                        @if (is_array($post->media) && count($post->media))
                                            @foreach ($post->media as $file)
                                                @if ($file['media_type'] === 'image')
                                                    <div class="col-6 mb-2 pe-1">
                                                        <a href="{{ asset($file['file_path']) }}"
                                                            data-lightbox="post-{{ $post->id }}">
                                                            <img src="{{ asset($file['file_path']) }}" alt="post image"
                                                                class="gallery-img w-100 rounded-3 shadow-sm">
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    @empty
                                        <p class="text-center text-muted">No Posts Yet!</p>
                                    @endforelse
                                </div>


                            </div>
                            <div class="card-body d-block w-100 pt-0">
                                <a href="{{ route('user.profile.photos') }}"
                                    class="p-2 lh-28 w-100 d-block bg-grey text-grey-800 text-center font-xssss fw-700 rounded-xl"><i
                                        class="feather-external-link font-xss me-2"></i> More</a>
                            </div>
                        </div>

                        <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3">
                            <div class="card-body d-flex align-items-center  p-4">
                                <h4 class="fw-700 mb-0 font-xssss text-grey-900">Event</h4>
                                <a href="#" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                            </div>
                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-3 overflow-hidden">
                                <div class="bg-success me-2 p-3 rounded-xxl">
                                    <h4 class="fw-700 font-lg ls-3 lh-1 text-white mb-0"><span
                                            class="ls-1 d-block font-xsss text-white fw-600">FEB</span>22</h4>
                                </div>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">Meeting with clients <span
                                        class="d-block font-xsssss fw-500 mt-1 lh-4 text-grey-500">41 madison ave, floor 24
                                        new work, NY 10010</span> </h4>
                            </div>

                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-3 overflow-hidden">
                                <div class="bg-warning me-2 p-3 rounded-xxl">
                                    <h4 class="fw-700 font-lg ls-3 lh-1 text-white mb-0"><span
                                            class="ls-1 d-block font-xsss text-white fw-600">APR</span>30</h4>
                                </div>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">Developer Programe <span
                                        class="d-block font-xsssss fw-500 mt-1 lh-4 text-grey-500">41 madison ave, floor 24
                                        new work, NY 10010</span> </h4>
                            </div>

                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-3 overflow-hidden">
                                <div class="bg-primary me-2 p-3 rounded-xxl">
                                    <h4 class="fw-700 font-lg ls-3 lh-1 text-white mb-0"><span
                                            class="ls-1 d-block font-xsss text-white fw-600">APR</span>23</h4>
                                </div>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">Aniversary Event <span
                                        class="d-block font-xsssss fw-500 mt-1 lh-4 text-grey-500">41 madison ave, floor 24
                                        new work, NY 10010</span> </h4>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-8 col-xxl-9 col-lg-8">
                        {{-- user can start a post --}}
                        @include('components.create-post')

                        {{-- user posts --}}
                        @foreach ($user->posts as $post)
                            <div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mb-3 mt-3"
                                id="post-{{ $post->id }}">
                                <div class="card-body p-0 d-flex">

                                    @if ($user->profile && $user->profile->profile_photo)
                                        <figure class="avatar me-3">
                                            <img src="{{ asset('storage/profile_photos/' . $user->profile->profile_photo) }}"
                                                alt="Profile"
                                                class="w-12 h-12 rounded-full object-cover object-top border shadow">
                                        </figure>
                                    @else
                                        <figure class="avatar me-3">
                                            <img src="{{ asset('assets/images/user-7.png') }}" alt="Default Profile"
                                                class="shadow-sm rounded-circle w45">
                                        </figure>
                                    @endif

                                    <div class="flex-grow-1">
                                        <h4 class="fw-700 text-grey-900 font-xssss mt-1 mb-0">
                                            {{ $user->name }}
                                        </h4>
                                        <span class="d-block font-xssss fw-500 lh-3 text-grey-500">
                                            {{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    {{-- Dropdown --}}
                                    <a href="#" class="ms-auto" id="dropdownMenu{{ $post->id }}"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-more-alt text-grey-900 btn-round-md bg-greylight font-xss"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end p-3 rounded-xxl border-0 shadow-lg"
                                        aria-labelledby="dropdownMenu{{ $post->id }}">
                                        @if ($user->id === auth_user()->id)
                                            <div class="post-card" id="post-{{ $post->id }}">
                                                <form action="{{ route('user.delete.post', $post->id) }}" method="POST"
                                                    class="delete-post-form" data-id="{{ $post->id }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="delete-btn d-flex align-items-center border-0 bg-transparent p-0">
                                                        <i class="feather-trash text-grey-500 me-3 font-lg"></i>
                                                        <h4 class="fw-600 text-grey-900 font-xssss mt-0">Delete This
                                                            Post</h4>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="feather-bookmark text-grey-500 me-2 font-lg"></i>
                                            <div>
                                                <h6 class="fw-600 text-grey-900 font-xssss mb-0">Save Post</h6>
                                                <small class="text-grey-500">Add this to your saved items</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="feather-alert-circle text-grey-500 me-2 font-lg"></i>
                                            <div>
                                                <h6 class="fw-600 text-grey-900 font-xssss mb-0">Hide Post</h6>
                                                <small class="text-grey-500">Remove from your feed</small>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-start mb-2">
                                            <i class="feather-lock text-grey-500 me-2 font-lg"></i>
                                            <div>
                                                <h6 class="fw-600 text-grey-900 font-xssss mb-0">Unfollow User</h6>
                                                <small class="text-grey-500">Stop seeing their posts</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Post Content --}}
                                <div class="card-body p-0 me-lg-5">
                                    <p class="fw-500 text-grey-500 lh-26 font-xssss w-100 mb-2">
                                        {{ $post->content }}
                                    </p>
                                </div>

                                {{-- Post Media --}}
                                @if (is_array($post->media) && count($post->media))
                                    <div class="card-body d-block p-0">
                                        @if (count($post->media) === 1)
                                            {{-- Single Media -> Full width --}}
                                            @php $file = $post->media[0]; @endphp
                                            @if ($file['media_type'] === 'image')
                                                <a href="{{ $file['file_path'] }}"
                                                    data-lightbox="post-{{ $post->id }}">
                                                    <img src="{{ $file['file_path'] }}"
                                                        class="rounded-3 w-100 h-auto object-cover shadow-sm"
                                                        alt="Post image">
                                                </a>
                                            @elseif($file['media_type'] === 'video')
                                                <video controls class="rounded-3 w-100 shadow-sm">
                                                    <source src="{{ $file['file_path'] }}" type="video/mp4">
                                                </video>
                                            @endif
                                        @else
                                            {{-- Multiple Media -> Grid collage --}}
                                            <div class="row g-2 ps-2 pe-2">
                                                @foreach ($post->media as $file)
                                                    <div class="col-6 col-md-4">
                                                        @if ($file['media_type'] === 'image')
                                                            <a href="{{ $file['file_path'] }}"
                                                                data-lightbox="post-{{ $post->id }}">
                                                                <img src="{{ $file['file_path'] }}"
                                                                    class="rounded-3 w-100 h-48 object-cover shadow-sm"
                                                                    alt="Post image">
                                                            </a>
                                                        @elseif($file['media_type'] === 'video')
                                                            <video controls class="rounded-3 w-100 shadow-sm">
                                                                <source src="{{ $file['file_path'] }}" type="video/mp4">
                                                            </video>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif


                                {{-- Footer --}}
                                <div class="card-body d-flex p-0 mt-3 justify-content-between align-items-center">
                                    <!-- Like -->
                                    @php
                                        $liked = $post->likes->contains('user_id', auth()->id());
                                        $likeCount = $post->likes_count ?? 0;
                                    @endphp

                                    <a href="javascript:void(0);"
                                        class="d-flex align-items-center fw-600 text-grey-900 text-dark lh-26 font-xssss like-btn"
                                        data-id="{{ $post->id }}">
                                        <i
                                            class="feather-thumbs-up me-1 btn-round-xs font-xss
            {{ $liked ? 'bg-primary-gradiant text-white' : 'bg-white text-grey-900 border' }}"></i>
                                        <span class="like-text">{{ $liked ? 'Liked' : 'Like' }}</span>
                                        @if ($likeCount > 0)
                                            <span class="like-count ms-1">{{ $likeCount }}</span>
                                        @endif
                                    </a>

                                    <!-- Comment (centered) -->

                                    <a href="javascript:void(0)" onclick="toggleComments(true)"
                                        class="d-flex align-items-center fw-600 text-grey-900 text-dark lh-26 font-xssss">
                                        <i
                                            class="feather-message-circle text-dark text-grey-900 btn-round-sm font-lg me-1"></i>
                                        Comment ({{ $post->comments_count }})
                                    </a>


                                    <!-- Comments Popup -->
                                    <div id="commentsPopup"
                                        class="d-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 d-flex justify-content-center align-items-center"
                                        style="z-index:1050;">

                                        <!-- Card -->
                                        <div class="bg-white rounded-3 shadow p-3 w-100"
                                            style="max-width:600px; height:80vh; display:flex; flex-direction:column;">

                                            <!-- Header -->
                                            <div
                                                class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                                <h5 class="m-0 fw-bold">Comments</h5>
                                                <button onclick="toggleComments(false)"
                                                    class="btn btn-sm btn-light">✕</button>
                                            </div>

                                            <!-- Comments List (scrollable area) -->
                                            <div id="commentsList" class="flex-grow-1 mb-3 overflow-auto">
                                                @foreach ($post->comments as $comment)
                                                    <div class="d-flex mb-3" id="comment-{{ $comment->id }}">
                                                        <img src="{{ $comment->user->profile->profile_photo
                                                            ? asset('storage/profile_photos/' . $comment->user->profile->profile_photo)
                                                            : asset('assets/images/user-7.png') }}"
                                                            class="rounded-circle me-2"
                                                            style="width:40px; height:40px; object-fit:cover; object-position:top;"
                                                            alt="user">

                                                        <div>
                                                            <div class="bg-light p-2 rounded">
                                                                <strong>{{ $comment->user->name }}</strong><br>
                                                                {{ $comment->content }}
                                                                @if ($comment->user_id == auth_user()->id)
                                                                    <form
                                                                        action="{{ route('user.delete.comment', $comment->id) }}"
                                                                        method="POST"
                                                                        class="delete-comment-form d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-link p-0 text-danger">
                                                                            <img src="{{ asset('assets/images/delete-icon.svg') }}"
                                                                                alt="delete"
                                                                                style="width:20px; height:20px;"
                                                                                class="mx-3">
                                                                        </button>
                                                                    </form>
                                                                @endif

                                                            </div>

                                                            <small
                                                                class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Add Comment -->
                                            <form id="commentForm" action="{{ route('user.add.comment', $post->id) }}"
                                                method="POST" class="border-top pt-2">
                                                @csrf
                                                <div class="d-flex align-items-center">
                                                    <!-- Current User Image -->
                                                    <img src="{{ auth_user()->profile->profile_photo
                                                        ? asset('storage/profile_photos/' . auth_user()->profile->profile_photo)
                                                        : asset('assets/images/user-7.png') }}"
                                                        class="rounded-circle me-2"
                                                        style="width:40px; height:40px; object-fit:cover; object-position:top;"
                                                        alt="you">

                                                    <!-- Input -->
                                                    <input type="text" id="newComment" name="content"
                                                        class="form-control me-2" placeholder="Write a comment...">

                                                    <!-- Button -->
                                                    <button type="submit" class="btn btn-primary text-white"
                                                        style="padding: 0.6rem 1.2rem; font-size: 1rem;">Post</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Share -->
                                    <a href="#"
                                        class="d-flex align-items-center fw-600 text-grey-900 text-dark lh-26 font-xssss">
                                        <i class="feather-share-2 text-grey-900 text-dark btn-round-sm font-lg me-1"></i>
                                        Share
                                    </a>
                                </div>
                        @endforeach




                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- main content -->
    @include('js.profile')
@endsection
