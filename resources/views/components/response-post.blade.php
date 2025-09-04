<div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mt-3 mb-3">
    <div class="d-flex align-items-center mb-3">
        <img src="{{ $post->user->profile->profile_photo
            ? asset('storage/profile_photos/' . $post->user->profile->profile_photo)
            : asset('assets/images/user-12.png') }}"
            class="w-10 h-10 rounded-full object-cover border shadow me-2">
        <div>
            <h4 class="fw-600 mb-0">{{ $post->user->name }}</h4>
            <span class="text-grey-500 text-xs">Just now</span>
        </div>
    </div>

    @if ($post->content)
        <p class="text-sm text-gray-800">{{ $post->content }}</p>
    @endif

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
