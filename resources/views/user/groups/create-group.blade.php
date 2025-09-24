<div class="main-content right-chat-active">
    <div class="middle-sidebar-bottom">
        <div class="d-flex w-100 h-100">

            <!-- Full Width Create Group Form -->
            <div class="flex-grow-1 bg-white shadow-sm rounded-0 w-100" style="min-height: 100vh;">
                <div class="p-5">

                    <!-- Top Header -->
                    <div class="d-flex align-items-center mb-5 border-bottom pb-3">
                        <!-- Profile -->
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/profile_photos/' . (auth_profile()->profile_photo ?? 'assets/images/user-12.png')) }}"
                                class="rounded-circle me-3 object-cover object-top"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            <div>
                                <h5 class="fw-bold mb-0">{{ auth()->user()->name }}</h5>
                                <small class="text-muted">Create a new group</small>
                            </div>
                        </div>

                        <!-- Title aligned right -->
                        <div class="ms-auto">
                            <h3 class="fw-bold mb-0 text-dark">Create Group</h3>
                        </div>
                    </div>

                    <!-- Form -->
                    <form id="createGroupForm" action="{{ route('user.store.group') }}" method="POST" class="w-100"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Group Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">Group Name</label>
                            <input type="text"
                                class="form-control form-control-lg @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Enter group name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control form-control-lg @error('description') is-invalid @enderror" id="description"
                                name="description" rows="6" placeholder="What’s the group about?">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Privacy -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Privacy</label>
                            <div class="d-flex gap-5 flex-wrap mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="privacy" id="privacyPublic"
                                        value="public" {{ old('privacy', 'public') == 'public' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="privacyPublic">
                                        Public
                                        <div class="text-muted small">Anyone can see the group and members</div>
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="privacy" id="privacyPrivate"
                                        value="private" {{ old('privacy') == 'private' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="privacyPrivate">
                                        Private
                                        <div class="text-muted small">Only members can see the group and posts</div>
                                    </label>
                                </div>
                            </div>
                            @error('privacy')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cover Photo -->
                        <div class="mb-4">
                            <label for="cover_photo" class="form-label fw-bold">Cover Photo</label>
                            <input type="file"
                                class="form-control form-control-lg @error('cover_photo') is-invalid @enderror"
                                id="cover_photo" name="cover_photo" accept="image/*">
                            @error('cover_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="text-end mt-5">
                            <button type="submit" class="btn btn-primary text-white btn-lg px-5 fw-bold rounded-pill">
                                Create Group
                            </button>
                        </div>
                    </form>


                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).on("submit", "#createGroupForm", function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr("action");
            let formData = new FormData(this); // use FormData for files

            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                processData: false, // important for file upload
                contentType: false, // important for file upload
                success: function(response) {
                    if (response.success) {
                        // Inject the HTML into the .content div
                        $(".content").html(response.html);

                        // Optional: update URL without reload
                        let newUrl = "{{ route('user.popular.group') }}";
                        window.history.pushState({
                            path: newUrl
                        }, "", newUrl);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $(".invalid-feedback").remove();
                        $(".is-invalid").removeClass("is-invalid");

                        $.each(errors, function(key, value) {
                            let input = $('[name="' + key + '"]');
                            input.addClass("is-invalid");
                            input.after('<div class="invalid-feedback">' + value[0] + '</div>');
                        });
                    } else {
                        console.error("Error:", xhr.responseText);
                    }
                }
            });
        });
    </script>
@endpush
