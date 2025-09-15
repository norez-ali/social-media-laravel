@extends('layout.main')

@section('content')
    @push('title')
        <title>Sociala - Social Network App HTML Template</title>
    @endpush
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css') }}">
    @endpush
    <!-- main content -->
    <div class="main-content right-chat-active">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left">
                <!-- loader wrapper -->
                <div class="preloader-wrap p-3">
                    <div class="box shimmer">
                        <div class="lines">
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                        </div>
                    </div>
                    <div class="box shimmer mb-3">
                        <div class="lines">
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                        </div>
                    </div>
                    <div class="box shimmer">
                        <div class="lines">
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                            <div class="line s_shimmer"></div>
                        </div>
                    </div>
                </div>
                {{-- story popup is includede here --}}
                @include('components.story-component')

                <!-- loader wrapper -->
                <div class="row feed-body ">
                    <div class="col-xl-8 col-xxl-9 col-lg-8">
                        <div class="card w-100 shadow-none bg-transparent bg-transparent-card border-0 p-0 mb-0 ">
                            <div class="owl-carousel category-card owl-theme overflow-hidden nav-none ">
                                <div class="item ">
                                    <div
                                        class="card w125 h200 d-block border-0 shadow-none rounded-xxxl bg-dark overflow-hidden mb-3 mt-3">
                                        <div class="card-body d-block p-3 w-100 position-absolute bottom-0 text-center">
                                            <button onclick="toggleStoryPopup(true)">
                                                <span class="btn-round-lg bg-white"><i
                                                        class="feather-plus font-lg"></i></span>
                                                <div class="clearfix"></div>
                                                <h4
                                                    class="fw-700 position-relative z-index-1 ls-1 font-xssss text-white mt-2 mb-1">
                                                    Add Story
                                                </h4>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                {{-- User story cards --}}
                                @foreach ($users as $user)
                                    @if ($user->stories->count() > 0)
                                        <div class="item">
                                            <div data-bs-toggle="modal" data-bs-target="#Modalstory"
                                                data-id="{{ $user->id }}"
                                                class="card w125 h200 d-block border-0 shadow-xss rounded-xxxl bg-gradiant-bottom overflow-hidden cursor-pointer mb-3 mt-3"
                                                style="background-image: url('{{ asset('storage/' . $user->stories->first()->media) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;">
                                                <div
                                                    class="card-body d-block p-3 w-100 position-absolute bottom-0 text-center">
                                                    <a href="" class="load-story">
                                                        <figure
                                                            class="avatar ms-auto me-auto mb-0 position-relative w50 z-index-1">
                                                            <img src="{{ $user->profile && $user->profile->profile_photo
                                                                ? asset('storage/profile_photos/' . $user->profile->profile_photo)
                                                                : asset('assets/images/user-12.png') }}"
                                                                alt="image" style="width: 50px; height:50px; "
                                                                class="float-right p-0 bg-white rounded-circle w-100 shadow-xss object-cover object-top" />
                                                        </figure>
                                                        <div class="clearfix"></div>
                                                        <h4
                                                            class="fw-600 position-relative z-index-1 ls-1 font-xssss text-white mt-2 mb-1">
                                                            {{ $user->name }}
                                                        </h4>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach



                            </div>
                        </div>

                        @include('components.create-post', ['user' => auth_user()])

                        @foreach ($users as $user)
                            @foreach ($user->posts as $post)
                                <div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mb-3"
                                    id="post-{{ $post->id }}">
                                    <div class="card-body p-0 d-flex">
                                        {{-- Profile photo --}}
                                        <a href="{{ route('user.profile', $user->id) }}">
                                            <figure class="avatar me-3">
                                                <img src="{{ $user->profile && $user->profile->profile_photo
                                                    ? asset('storage/profile_photos/' . $user->profile->profile_photo)
                                                    : asset('assets/images/user-7.png') }}"
                                                    alt="Profile photo"
                                                    class="w-12 h-12 rounded-full object-cover object-top border shadow" />
                                            </figure>
                                        </a>
                                        <h4 class="fw-700 text-grey-900 font-xssss mt-1">
                                            {{ $user->name }}
                                            <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">
                                                {{ $post->created_at->diffForHumans() }}
                                            </span>
                                        </h4>

                                        {{-- Dropdown --}}
                                        <a href="#" class="ms-auto" id="dropdownMenu-{{ $post->id }}"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ti-more-alt text-grey-900 btn-round-md bg-greylight font-xss"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end p-4 rounded-xxl border-0 shadow-lg"
                                            aria-labelledby="dropdownMenu-{{ $post->id }}">
                                            @if ($user->id === auth_user()->id)
                                                <div class="post-card" id="post-{{ $post->id }}">
                                                    <form action="{{ route('user.delete.post', $post->id) }}"
                                                        method="POST" class="delete-post-form"
                                                        data-id="{{ $post->id }}">
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
                                            <div class="card-body p-0 d-flex">
                                                <i class="feather-bookmark text-grey-500 me-3 font-lg"></i>
                                                <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">
                                                    Save Post
                                                    <span class="d-block font-xsssss fw-500 mt-1 lh-3 text-grey-500">Add to
                                                        your saved items</span>
                                                </h4>
                                            </div>
                                            <div class="card-body p-0 d-flex mt-2">
                                                <i class="feather-alert-circle text-grey-500 me-3 font-lg"></i>
                                                <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">Hide Post</h4>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Post Content --}}
                                    <div class="card-body p-0 me-lg-5">
                                        <p class="fw-500 text-grey-500 lh-26 font-xssss w-100">
                                            {{ $post->content }}
                                        </p>
                                    </div>

                                    {{-- Post Media --}}
                                    @if (is_array($post->media) && count($post->media))
                                        <div class="card-body d-block p-0">
                                            @if (count($post->media) === 1)
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
                                                                    <source src="{{ $file['file_path'] }}"
                                                                        type="video/mp4">
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
                                            Comment
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
                                                                </div>

                                                                <small
                                                                    class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Add Comment -->
                                                <form id="commentForm"
                                                    action="{{ route('user.add.comment', $post->id) }}" method="POST"
                                                    class="border-top pt-2">
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
                                            <i
                                                class="feather-share-2 text-grey-900 text-dark btn-round-sm font-lg me-1"></i>
                                            Share
                                        </a>
                                    </div>


                                </div>
                            @endforeach
                        @endforeach




                        <div class="card w-100 shadow-none bg-transparent bg-transparent-card border-0 p-0 mb-0">
                            <div class="owl-carousel category-card owl-theme overflow-hidden nav-none">
                                <div class="item">
                                    <div
                                        class="card w200 d-block border-0 shadow-xss rounded-xxl overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body position-relative h100 bg-image-cover bg-image-center"
                                            style="background-image: url(images/u-bg.jpg)"></div>
                                        <div class="card-body d-block w-100 ps-4 pe-4 pb-4 text-center">
                                            <figure
                                                class="avatar ms-auto me-auto mb-0 mt--6 position-relative w75 z-index-1">
                                                <img src="images/user-11.png" alt="image"
                                                    class="float-right p-1 bg-white rounded-circle w-100" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xsss mt-2 mb-1">
                                                Aliqa Macale
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-2">
                                                support@gmail.com
                                            </p>
                                            <span
                                                class="live-tag mt-2 mb-0 bg-danger p-2 z-index-1 rounded-3 text-white font-xsssss text-uppersace fw-700 ls-3">LIVE</span>
                                            <div class="clearfix mb-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div
                                        class="card w200 d-block border-0 shadow-xss rounded-xxl overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body position-relative h100 bg-image-cover bg-image-center"
                                            style="background-image: url(images/s-2.jpg)"></div>
                                        <div class="card-body d-block w-100 ps-4 pe-4 pb-4 text-center">
                                            <figure
                                                class="avatar ms-auto me-auto mb-0 mt--6 position-relative w75 z-index-1">
                                                <img src="images/user-2.png" alt="image"
                                                    class="float-right p-1 bg-white rounded-circle w-100" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xsss mt-2 mb-1">
                                                Seary Victor
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-2">
                                                support@gmail.com
                                            </p>
                                            <span
                                                class="live-tag mt-2 mb-0 bg-danger p-2 z-index-1 rounded-3 text-white font-xsssss text-uppersace fw-700 ls-3">LIVE</span>
                                            <div class="clearfix mb-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div
                                        class="card w200 d-block border-0 shadow-xss rounded-xxl overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body position-relative h100 bg-image-cover bg-image-center"
                                            style="background-image: url(images/s-6.jpg)"></div>
                                        <div class="card-body d-block w-100 ps-4 pe-4 pb-4 text-center">
                                            <figure
                                                class="avatar ms-auto me-auto mb-0 mt--6 position-relative w75 z-index-1">
                                                <img src="images/user-3.png" alt="image"
                                                    class="float-right p-1 bg-white rounded-circle w-100" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xsss mt-2 mb-1">
                                                John Steere
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-2">
                                                support@gmail.com
                                            </p>
                                            <span
                                                class="live-tag mt-2 mb-0 bg-danger p-2 z-index-1 rounded-3 text-white font-xsssss text-uppersace fw-700 ls-3">LIVE</span>
                                            <div class="clearfix mb-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div
                                        class="card w200 d-block border-0 shadow-xss rounded-xxl overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body position-relative h100 bg-image-cover bg-image-center"
                                            style="background-image: url(images/bb-16.png)"></div>
                                        <div class="card-body d-block w-100 ps-4 pe-4 pb-4 text-center">
                                            <figure
                                                class="avatar ms-auto me-auto mb-0 mt--6 position-relative w75 z-index-1">
                                                <img src="images/user-4.png" alt="image"
                                                    class="float-right p-1 bg-white rounded-circle w-100" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xsss mt-2 mb-1">
                                                Mohannad Zitoun
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-2">
                                                support@gmail.com
                                            </p>
                                            <span
                                                class="live-tag mt-2 mb-0 bg-danger p-2 z-index-1 rounded-3 text-white font-xsssss text-uppersace fw-700 ls-3">LIVE</span>
                                            <div class="clearfix mb-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div
                                        class="card w200 d-block border-0 shadow-xss rounded-xxl overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body position-relative h100 bg-image-cover bg-image-center"
                                            style="background-image: url(images/e-4.jpg)"></div>
                                        <div class="card-body d-block w-100 ps-4 pe-4 pb-4 text-center">
                                            <figure
                                                class="avatar ms-auto me-auto mb-0 mt--6 position-relative w75 z-index-1">
                                                <img src="images/user-7.png" alt="image"
                                                    class="float-right p-1 bg-white rounded-circle w-100" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xsss mt-2 mb-1">
                                                Studio Express
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-2">
                                                support@gmail.com
                                            </p>
                                            <span
                                                class="live-tag mt-2 mb-0 bg-danger p-2 z-index-1 rounded-3 text-white font-xsssss text-uppersace fw-700 ls-3">LIVE</span>
                                            <div class="clearfix mb-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div
                                        class="card w200 d-block border-0 shadow-xss rounded-xxl overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body position-relative h100 bg-image-cover bg-image-center"
                                            style="background-image: url(images/coming-soon.png)"></div>
                                        <div class="card-body d-block w-100 ps-4 pe-4 pb-4 text-center">
                                            <figure
                                                class="avatar ms-auto me-auto mb-0 mt--6 position-relative w75 z-index-1">
                                                <img src="images/user-5.png" alt="image"
                                                    class="float-right p-1 bg-white rounded-circle w-100" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xsss mt-2 mb-1">
                                                Hendrix Stamp
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-2">
                                                support@gmail.com
                                            </p>
                                            <span
                                                class="live-tag mt-2 mb-0 bg-danger p-2 z-index-1 rounded-3 text-white font-xsssss text-uppersace fw-700 ls-3">LIVE</span>
                                            <div class="clearfix mb-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div
                                        class="card w200 d-block border-0 shadow-xss rounded-xxl overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body position-relative h100 bg-image-cover bg-image-center"
                                            style="background-image: url(images/bb-9.jpg)"></div>
                                        <div class="card-body d-block w-100 ps-4 pe-4 pb-4 text-center">
                                            <figure
                                                class="avatar ms-auto me-auto mb-0 mt--6 position-relative w75 z-index-1">
                                                <img src="images/user-6.png" alt="image"
                                                    class="float-right p-1 bg-white rounded-circle w-100" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xsss mt-2 mb-1">
                                                Mohannad Zitoun
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-2">
                                                support@gmail.com
                                            </p>
                                            <span
                                                class="live-tag mt-2 mb-0 bg-danger p-2 z-index-1 rounded-3 text-white font-xsssss text-uppersace fw-700 ls-3">LIVE</span>
                                            <div class="clearfix mb-2"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="card w-100 shadow-none bg-transparent bg-transparent-card border-0 p-0 mb-0">
                            <div class="owl-carousel category-card owl-theme overflow-hidden nav-none">
                                <div class="item">
                                    <div
                                        class="card w150 d-block border-0 shadow-xss rounded-3 overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body d-block w-100 ps-3 pe-3 pb-4 text-center">
                                            <figure class="avatar ms-auto me-auto mb-0 position-relative w65 z-index-1">
                                                <img src="images/user-11.png" alt="image"
                                                    class="float-right p-0 bg-white rounded-circle w-100 shadow-xss" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xssss mt-3 mb-1">
                                                Richard Bowers
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">
                                                @macale343
                                            </p>
                                            <a href="#"
                                                class="text-center p-2 lh-20 w100 ms-1 ls-3 d-inline-block rounded-xl bg-success font-xsssss fw-700 ls-lg text-white">FOLLOW</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div
                                        class="card w150 d-block border-0 shadow-xss rounded-3 overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body d-block w-100 ps-3 pe-3 pb-4 text-center">
                                            <figure class="avatar ms-auto me-auto mb-0 position-relative w65 z-index-1">
                                                <img src="images/user-9.png" alt="image"
                                                    class="float-right p-0 bg-white rounded-circle w-100 shadow-xss" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xssss mt-3 mb-1">
                                                David Goria
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">
                                                @macale343
                                            </p>
                                            <a href="#"
                                                class="text-center p-2 lh-20 w100 ms-1 ls-3 d-inline-block rounded-xl bg-success font-xsssss fw-700 ls-lg text-white">FOLLOW</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div
                                        class="card w150 d-block border-0 shadow-xss rounded-3 overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body d-block w-100 ps-3 pe-3 pb-4 text-center">
                                            <figure class="avatar ms-auto me-auto mb-0 position-relative w65 z-index-1">
                                                <img src="images/user-12.png" alt="image"
                                                    class="float-right p-0 bg-white rounded-circle w-100 shadow-xss" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xssss mt-3 mb-1">
                                                Vincent Parks
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">
                                                @macale343
                                            </p>
                                            <a href="#"
                                                class="text-center p-2 lh-20 w100 ms-1 ls-3 d-inline-block rounded-xl bg-success font-xsssss fw-700 ls-lg text-white">FOLLOW</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div
                                        class="card w150 d-block border-0 shadow-xss rounded-3 overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body d-block w-100 ps-3 pe-3 pb-4 text-center">
                                            <figure class="avatar ms-auto me-auto mb-0 position-relative w65 z-index-1">
                                                <img src="images/user-8.png" alt="image"
                                                    class="float-right p-0 bg-white rounded-circle w-100 shadow-xss" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xssss mt-3 mb-1">
                                                Studio Express
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">
                                                @macale343
                                            </p>
                                            <a href="#"
                                                class="text-center p-2 lh-20 w100 ms-1 ls-3 d-inline-block rounded-xl bg-success font-xsssss fw-700 ls-lg text-white">FOLLOW</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div
                                        class="card w150 d-block border-0 shadow-xss rounded-3 overflow-hidden mb-3 me-2 mt-3">
                                        <div class="card-body d-block w-100 ps-3 pe-3 pb-4 text-center">
                                            <figure class="avatar ms-auto me-auto mb-0 position-relative w65 z-index-1">
                                                <img src="images/user-7.png" alt="image"
                                                    class="float-right p-0 bg-white rounded-circle w-100 shadow-xss" />
                                            </figure>
                                            <div class="clearfix"></div>
                                            <h4 class="fw-700 font-xssss mt-3 mb-1">
                                                Aliqa Macale
                                            </h4>
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">
                                                @macale343
                                            </p>
                                            <a href="#"
                                                class="text-center p-2 lh-20 w100 ms-1 ls-3 d-inline-block rounded-xl bg-success font-xsssss fw-700 ls-lg text-white">FOLLOW</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="card w-100 text-center shadow-xss rounded-xxl border-0 p-4 mb-3 mt-3">
                            <div class="snippet mt-2 ms-auto me-auto" data-title=".dot-typing">
                                <div class="stage">
                                    <div class="dot-typing"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- right side content --}}
                    <div class="col-xl-4 col-xxl-3 col-lg-4 ps-lg-0">
                        <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3">
                            <div class="card-body d-flex align-items-center p-4">
                                <h4 class="fw-700 mb-0 font-xssss text-grey-900">
                                    Friend Request
                                </h4>
                                <a href="default-member.html" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                            </div>
                            <div class="card-body d-flex pt-4 ps-4 pe-4 pb-0 border-top-xs bor-0">
                                <figure class="avatar me-3">
                                    <img src="images/user-7.png" alt="image" class="shadow-sm rounded-circle w45" />
                                </figure>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-1">
                                    Anthony Daugloi
                                    <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">12 mutual
                                        friends</span>
                                </h4>
                            </div>
                            <div class="card-body d-flex align-items-center pt-0 ps-4 pe-4 pb-4">
                                <a href="#"
                                    class="p-2 lh-20 w100 bg-primary-gradiant me-2 text-white text-center font-xssss fw-600 ls-1 rounded-xl">Confirm</a>
                                <a href="#"
                                    class="p-2 lh-20 w100 bg-grey text-grey-800 text-center font-xssss fw-600 ls-1 rounded-xl">Delete</a>
                            </div>

                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-0">
                                <figure class="avatar me-3">
                                    <img src="images/user-8.png" alt="image" class="shadow-sm rounded-circle w45" />
                                </figure>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-1">
                                    Mohannad Zitoun
                                    <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">12 mutual
                                        friends</span>
                                </h4>
                            </div>
                            <div class="card-body d-flex align-items-center pt-0 ps-4 pe-4 pb-4">
                                <a href="#"
                                    class="p-2 lh-20 w100 bg-primary-gradiant me-2 text-white text-center font-xssss fw-600 ls-1 rounded-xl">Confirm</a>
                                <a href="#"
                                    class="p-2 lh-20 w100 bg-grey text-grey-800 text-center font-xssss fw-600 ls-1 rounded-xl">Delete</a>
                            </div>

                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-0">
                                <figure class="avatar me-3">
                                    <img src="images/user-12.png" alt="image" class="shadow-sm rounded-circle w45" />
                                </figure>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-1">
                                    Mohannad Zitoun
                                    <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">12 mutual
                                        friends</span>
                                </h4>
                            </div>
                            <div class="card-body d-flex align-items-center pt-0 ps-4 pe-4 pb-4">
                                <a href="#"
                                    class="p-2 lh-20 w100 bg-primary-gradiant me-2 text-white text-center font-xssss fw-600 ls-1 rounded-xl">Confirm</a>
                                <a href="#"
                                    class="p-2 lh-20 w100 bg-grey text-grey-800 text-center font-xssss fw-600 ls-1 rounded-xl">Delete</a>
                            </div>
                        </div>

                        <div class="card w-100 shadow-xss rounded-xxl border-0 p-0">
                            <div class="card-body d-flex align-items-center p-4 mb-0">
                                <h4 class="fw-700 mb-0 font-xssss text-grey-900">
                                    Confirm Friend
                                </h4>
                                <a href="default-member.html" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                            </div>
                            <div class="card-body bg-transparent-card d-flex p-3 bg-greylight ms-3 me-3 rounded-3">
                                <figure class="avatar me-2 mb-0">
                                    <img src="images/user-7.png" alt="image" class="shadow-sm rounded-circle w45" />
                                </figure>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">
                                    Anthony Daugloi
                                    <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">12 mutual
                                        friends</span>
                                </h4>
                                <a href="#"
                                    class="btn-round-sm bg-white text-grey-900 feather-chevron-right font-xss ms-auto mt-2"></a>
                            </div>
                            <div class="card-body bg-transparent-card d-flex p-3 bg-greylight m-3 rounded-3"
                                style="margin-bottom: 0 !important">
                                <figure class="avatar me-2 mb-0">
                                    <img src="images/user-8.png" alt="image" class="shadow-sm rounded-circle w45" />
                                </figure>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">
                                    David Agfree
                                    <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">12 mutual
                                        friends</span>
                                </h4>
                                <a href="#"
                                    class="btn-round-sm bg-white text-grey-900 feather-plus font-xss ms-auto mt-2"></a>
                            </div>
                            <div class="card-body bg-transparent-card d-flex p-3 bg-greylight m-3 rounded-3">
                                <figure class="avatar me-2 mb-0">
                                    <img src="images/user-12.png" alt="image" class="shadow-sm rounded-circle w45" />
                                </figure>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">
                                    Hugury Daugloi
                                    <span class="d-block font-xssss fw-500 mt-1 lh-3 text-grey-500">12 mutual
                                        friends</span>
                                </h4>
                                <a href="#"
                                    class="btn-round-sm bg-white text-grey-900 feather-plus font-xss ms-auto mt-2"></a>
                            </div>
                        </div>

                        <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3 mt-3">
                            <div class="card-body d-flex align-items-center p-4">
                                <h4 class="fw-700 mb-0 font-xssss text-grey-900">
                                    Suggest Group
                                </h4>
                                <a href="default-group.html" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                            </div>
                            <div class="card-body d-flex pt-4 ps-4 pe-4 pb-0 overflow-hidden border-top-xs bor-0">
                                <img src="images/e-2.jpg" alt="img" class="img-fluid rounded-xxl mb-2" />
                            </div>
                            <div class="card-body dd-block pt-0 ps-4 pe-4 pb-4">
                                <ul class="memberlist mt-1 mb-2 ms-0 d-block">
                                    <li class="w20">
                                        <a href="#"><img src="images/user-6.png" alt="user"
                                                class="w35 d-inline-block" style="opacity: 1" /></a>
                                    </li>
                                    <li class="w20">
                                        <a href="#"><img src="images/user-7.png" alt="user"
                                                class="w35 d-inline-block" style="opacity: 1" /></a>
                                    </li>
                                    <li class="w20">
                                        <a href="#"><img src="images/user-8.png" alt="user"
                                                class="w35 d-inline-block" style="opacity: 1" /></a>
                                    </li>
                                    <li class="w20">
                                        <a href="#"><img src="images/user-3.png" alt="user"
                                                class="w35 d-inline-block" style="opacity: 1" /></a>
                                    </li>
                                    <li class="last-member">
                                        <a href="#"
                                            class="bg-greylight fw-600 text-grey-500 font-xssss w35 ls-3 text-center"
                                            style="height: 35px; line-height: 35px">+2</a>
                                    </li>
                                    <li class="ps-3 w-auto ms-1">
                                        <a href="#" class="fw-600 text-grey-500 font-xssss">Member apply</a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3">
                            <div class="card-body d-flex align-items-center p-4">
                                <h4 class="fw-700 mb-0 font-xssss text-grey-900">
                                    Suggest Pages
                                </h4>
                                <a href="default-group.html" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                            </div>
                            <div class="card-body d-flex pt-4 ps-4 pe-4 pb-0 overflow-hidden border-top-xs bor-0">
                                <img src="images/g-2.jpg" alt="img" class="img-fluid rounded-xxl mb-2" />
                            </div>
                            <div class="card-body d-flex align-items-center pt-0 ps-4 pe-4 pb-4">
                                <a href="#"
                                    class="p-2 lh-28 w-100 bg-grey text-grey-800 text-center font-xssss fw-700 rounded-xl"><i
                                        class="feather-external-link font-xss me-2"></i> Like
                                    Page</a>
                            </div>

                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-0 overflow-hidden">
                                <img src="images/g-3.jpg" alt="img"
                                    class="img-fluid rounded-xxl mb-2 bg-lightblue" />
                            </div>
                            <div class="card-body d-flex align-items-center pt-0 ps-4 pe-4 pb-4">
                                <a href="#"
                                    class="p-2 lh-28 w-100 bg-grey text-grey-800 text-center font-xssss fw-700 rounded-xl"><i
                                        class="feather-external-link font-xss me-2"></i> Like
                                    Page</a>
                            </div>
                        </div>

                        <div class="card w-100 shadow-xss rounded-xxl border-0 mb-3">
                            <div class="card-body d-flex align-items-center p-4">
                                <h4 class="fw-700 mb-0 font-xssss text-grey-900">Event</h4>
                                <a href="default-event.html" class="fw-600 ms-auto font-xssss text-primary">See all</a>
                            </div>
                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-3 overflow-hidden">
                                <div class="bg-success me-2 p-3 rounded-xxl">
                                    <h4 class="fw-700 font-lg ls-3 lh-1 text-white mb-0">
                                        <span class="ls-1 d-block font-xsss text-white fw-600">FEB</span>22
                                    </h4>
                                </div>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">
                                    Meeting with clients
                                    <span class="d-block font-xsssss fw-500 mt-1 lh-4 text-grey-500">41 madison ave, floor
                                        24 new work, NY 10010</span>
                                </h4>
                            </div>

                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-3 overflow-hidden">
                                <div class="bg-warning me-2 p-3 rounded-xxl">
                                    <h4 class="fw-700 font-lg ls-3 lh-1 text-white mb-0">
                                        <span class="ls-1 d-block font-xsss text-white fw-600">APR</span>30
                                    </h4>
                                </div>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">
                                    Developer Programe
                                    <span class="d-block font-xsssss fw-500 mt-1 lh-4 text-grey-500">41 madison ave, floor
                                        24 new work, NY 10010</span>
                                </h4>
                            </div>

                            <div class="card-body d-flex pt-0 ps-4 pe-4 pb-3 overflow-hidden">
                                <div class="bg-primary me-2 p-3 rounded-xxl">
                                    <h4 class="fw-700 font-lg ls-3 lh-1 text-white mb-0">
                                        <span class="ls-1 d-block font-xsss text-white fw-600">APR</span>23
                                    </h4>
                                </div>
                                <h4 class="fw-700 text-grey-900 font-xssss mt-2">
                                    Aniversary Event
                                    <span class="d-block font-xsssss fw-500 mt-1 lh-4 text-grey-500">41 madison ave, floor
                                        24 new work, NY 10010</span>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content -->




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
        </script>
    @endpush
@endsection
