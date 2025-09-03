@extends('layout.main')
@section('content')
    <!-- main content -->
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

                                <h4 class="fw-700 font-sm mt-2 mb-lg-5 mb-4 pl-15">{{ auth_user()->name }} <span
                                        class="fw-500 font-xssss text-grey-500 mt-1 mb-3 d-block">{{ auth_user()->email }}</span>
                                </h4>
                                <div
                                    class="d-flex align-items-center justify-content-center position-absolute-md right-15 top-0 me-2">


                                    @if (auth()->id() === auth_user()->id)
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
                                            href="#navtabs7" data-toggle="tab">Media</a></li>
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
                                    <button onclick="toggleBioEdit(true)"
                                        class="w-full bg-gray-300 rounded-lg hover:bg-gray-400">
                                        Edit Bio
                                    </button>
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
                                <div id="detailsDisplay" class="mb-2">

                                    <button onclick="toggleDetailsEdit(true)"
                                        class="w-full bg-gray-300 rounded-lg hover:bg-gray-400 mt-2">
                                        Edit Details
                                    </button>
                                </div>

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
                                <a href="#" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                            </div>
                            <div class="card-body d-block pt-0 pb-2">
                                <div class="row">
                                    <div class="col-6 mb-2 pe-1"><a href="images/e-2.jpg" data-lightbox="roadtrip"><img
                                                src="images/e-2.jpg" alt="image"
                                                class="img-fluid rounded-3 w-100"></a></div>
                                    <div class="col-6 mb-2 ps-1"><a href="images/e-3.jpg" data-lightbox="roadtrip"><img
                                                src="images/e-3.jpg" alt="image"
                                                class="img-fluid rounded-3 w-100"></a></div>
                                    <div class="col-6 mb-2 pe-1"><a href="images/e-4.jpg" data-lightbox="roadtrip"><img
                                                src="images/e-4.jpg" alt="image"
                                                class="img-fluid rounded-3 w-100"></a></div>
                                    <div class="col-6 mb-2 ps-1"><a href="images/e-5.jpg" data-lightbox="roadtrip"><img
                                                src="images/e-5.jpg" alt="image"
                                                class="img-fluid rounded-3 w-100"></a></div>
                                    <div class="col-6 mb-2 pe-1"><a href="images/e-2.jpg" data-lightbox="roadtrip"><img
                                                src="images/e-2.jpg" alt="image"
                                                class="img-fluid rounded-3 w-100"></a></div>
                                    <div class="col-6 mb-2 ps-1"><a href="images/e-1.jpg" data-lightbox="roadtrip"><img
                                                src="images/e-1.jpg" alt="image"
                                                class="img-fluid rounded-3 w-100"></a></div>
                                </div>
                            </div>
                            <div class="card-body d-block w-100 pt-0">
                                <a href="#"
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

                        @include('components.create-post')


                        @foreach ($user->posts as $post)
                            <div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mb-3">
                                <div class="card-body p-0 d-flex">
                                    {{-- User Profile Photo --}}
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
                                <div class="card-body d-flex p-0 mt-3">
                                    <a href="#"
                                        class="d-flex align-items-center fw-600 text-grey-900 text-dark lh-26 font-xssss me-3">
                                        <i
                                            class="feather-thumbs-up text-white bg-primary-gradiant me-1 btn-round-xs font-xss"></i>
                                        <i class="feather-heart text-white bg-red-gradiant me-2 btn-round-xs font-xss"></i>
                                        2.8K Like
                                    </a>
                                    <a href="#"
                                        class="d-flex align-items-center fw-600 text-grey-900 text-dark lh-26 font-xssss">
                                        <i class="feather-message-circle text-dark text-grey-900 btn-round-sm font-lg"></i>
                                        22 Comment
                                    </a>
                                    <a href="#"
                                        class="ms-auto d-flex align-items-center fw-600 text-grey-900 text-dark lh-26 font-xssss">
                                        <i class="feather-share-2 text-grey-900 text-dark btn-round-sm font-lg"></i>
                                        <span class="d-none-xs">Share</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach




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
        </script>
    @endpush
@endsection
