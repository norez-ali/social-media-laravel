<div class="main-content right-chat-active">

    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                        <div class="card-body d-flex align-items-center p-0">
                            <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">All Groups you've joined!</h2>



                        </div>
                    </div>
                </div>

                @forelse ($groups as $group)
                    <!-- Friend Card -->
                    <div class="col-md-3 col-sm-6">
                        <div class="card border-0 shadow-xss rounded-3 overflow-hidden h-100">

                            <!-- Image Cover -->
                            <div class="card-img-top position-relative" style="height:180px; overflow:hidden;">
                                <img src="{{ $group->cover_photo && $group->cover_photo
                                    ? asset('storage/' . $group->cover_photo)
                                    : asset('assets/images/user-12.png') }}"
                                    class="w-100 h-100 object-fit object-cover object-top" alt="profile-photo">
                            </div>



                            <!-- Body -->
                            <div class="card-body text-center">
                                <!-- Name -->
                                <h4 class="fw-700 font-xsss mt-3 mb-3">{{ $group->name }}</h4>



                                <!-- Buttons -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('user.view.group', $group->id) }}"
                                        class="open-group text-center p-2 flex-fill me-1 d-inline-flex align-items-center justify-content-center rounded-lg bg-primary font-xsssss fw-700 text-white">
                                        View Group
                                    </a>

                                    {{-- Dropdown --}}
                                    <a href="#" class="ms-auto" id="dropdownMenu-{{ $group->id }}"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti-more-alt text-grey-900 btn-round-md bg-greylight font-xss"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end p-4 rounded-xxl border-0 shadow-lg"
                                        aria-labelledby="dropdownMenu-{{ $group->id }}">



                                        <div class="card-body p-0 d-flex">
                                            <i class="feather-users text-grey-500 me-3 font-lg"></i>
                                            <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">
                                                <a href="{{ route('user.view.group', $group->id) }}" class="open-group">
                                                    view Group
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="card-body p-0 d-flex">
                                            <i class="feather-bookmark text-grey-500 me-3 font-lg"></i>
                                            <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">
                                                Save Post
                                            </h4>
                                        </div>
                                        <div class="card-body p-0 d-flex mt-2">
                                            @if ($group->pivot->role === 'admin')
                                                <i class="feather-trash text-grey-500 me-3 font-lg"></i>
                                                <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">Delete Group
                                                </h4>
                                            @else
                                                <i class="feather-alert-circle text-grey-500 me-3 font-lg"></i>
                                                <h4 class="fw-600 text-grey-900 font-xssss mt-0 me-4">Leave Group
                                                </h4>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div>
                        <h2> No Groups to show</h2>
                    </div>
                @endforelse






            </div>
        </div>
    </div>

</div>
</div>
@push('scripts')
    <script>
        $(document).on("click", ".open-group", function(e) {
            e.preventDefault();

            let url = $(this).attr("href");

            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    // Inject response
                    $(".content").html(response);

                    // Push URL to browser without reload
                    window.history.pushState({
                        path: url
                    }, "", url);
                },
                error: function(xhr) {
                    console.error("Error loading view:", xhr.responseText);
                }
            });
        });

        // Handle back/forward buttons
        $(window).on("popstate", function(e) {
            let url = window.location.href;
            $.ajax({
                url: url,
                type: "GET",
                success: function(response) {
                    $(".content").html(response);
                }
            });
        });
    </script>
@endpush
