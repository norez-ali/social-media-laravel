<div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mt-3 mb-3" id="post-{{ $post->id }}">
    <div class="d-flex align-items-center mb-3">
        <img src="{{ $post->user->profile && $post->user->profile->profile_photo
            ? asset('storage/profile_photos/' . $post->user->profile->profile_photo)
            : asset('assets/images/user-12.png') }}"
            class="w-10 h-10 rounded-full object-cover border shadow me-2">

        <div class="flex-grow-1">
            <h4 class="fw-600 mb-0">{{ $post->user->name }}</h4>
            <span class="text-grey-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
        </div>

        {{-- Dropdown --}}
        <a href="#" class="ms-auto" id="dropdownMenu{{ $post->id }}" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="ti-more-alt text-grey-900 btn-round-md bg-greylight font-xss"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end p-3 rounded-xxl border-0 shadow-lg"
            aria-labelledby="dropdownMenu{{ $post->id }}">
            @if ($post->user->id === auth_user()->id)
                <div class="post-card" id="post-{{ $post->id }}">
                    <form action="{{ route('user.delete.post', $post->id) }}" method="POST" class="delete-post-form"
                        data-id="{{ $post->id }}">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="delete-btn d-flex align-items-center border-0 bg-transparent p-0">
                            <i class="feather-trash text-grey-500 me-3 font-lg"></i>
                            <h4 class="fw-600 text-grey-900 font-xssss mt-0">Delete This Post</h4>
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
    @if ($post->content)
        <p class="text-sm text-gray-800">{{ $post->content }}</p>
    @endif

    {{-- Post Media --}}
    @if ($post->media)
        <div class="mt-2 space-y-2">
            @foreach ($post->media as $file)
                @if ($file['media_type'] === 'image')
                    <img src="{{ $file['file_path'] }}" class="w-full rounded-lg">
                @elseif ($file['media_type'] === 'video')
                    <video controls class="w-full rounded-lg">
                        <source src="{{ $file['file_path'] }}" type="video/mp4">
                    </video>
                @endif
            @endforeach
        </div>
    @endif
</div>
