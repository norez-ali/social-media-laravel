<div class="col-12">
    {{-- User Photos --}}
    <div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mb-3 bg-white">
        <h2 class="font-bold mb-3">Friends</h2>

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
                                    class="rounded-3 w-100 h-60 object-cover object-top shadow-sm" alt="User photo">
                            </a>

                            {{-- Dropdown for delete --}}
                            @if ($user->id === auth_user()->id)
                                <div class="dropdown position-absolute top-0 end-0 m-2">
                                    <a href="#" id="dropdownMenu{{ $post->id }}" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="ti-more-alt text-grey-900 btn-round-md bg-greylight font-xss"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end p-2 rounded-xxl border-0 shadow-lg"
                                        aria-labelledby="dropdownMenu{{ $post->id }}">
                                        <form action="{{ route('user.delete.post', $post->id) }}" method="POST"
                                            class="delete-post-form" data-id="{{ $post->id }}">
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
