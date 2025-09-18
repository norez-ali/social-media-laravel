@extends('layout.main')
@section('content')
    @push('title')
        <title>Sociala. friend-requests</title>
    @endpush
    @push('styles')
    @endpush

    <!-- main content -->
    <div class="main-content right-chat-active">

        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                            <div class="card-body d-flex align-items-center p-0">
                                <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900">Friend Requests</h2>

                            </div>
                        </div>

                        <div class="row g-3 ps-2 pe-2">
                            @forelse ($requests as $request)
                                <!-- Friend Card -->
                                <div class="col-md-3 col-sm-6">
                                    <div class="card border-0 shadow-xss rounded-3 overflow-hidden h-100">

                                        <!-- Image Cover -->
                                        <div class="card-img-top position-relative" style="height:180px; overflow:hidden;">
                                            <img src="{{ $request->sender->profile && $request->sender->profile->profile_photo
                                                ? asset('storage/profile_photos/' . $request->sender->profile->profile_photo)
                                                : asset('assets/images/user-12.png') }}"
                                                class="w-100 h-100 object-fit object-cover object-top" alt="profile-photo">
                                        </div>



                                        <!-- Body -->
                                        <div class="card-body text-center">
                                            <!-- Name -->
                                            <h4 class="fw-700 font-xsss mt-3 mb-1">{{ $request->sender->name }}</h4>
                                            <!-- Followers -->
                                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">Followed by 5.2K</p>

                                            <!-- Buttons -->
                                            <div class="d-flex justify-content-between">
                                                <a href="javascript:void(0);"
                                                    data-url="{{ route('user.friend.accept', $request->sender->id) }}"
                                                    class="confirm-request text-center p-2 flex-fill me-1 d-inline-block rounded-xl bg-primary font-xsssss fw-700 text-white">
                                                    Accept
                                                </a>
                                                <a href="javascript:void(0);"
                                                    data-url="{{ route('user.delete.request', $request->sender->id) }}"
                                                    class="delete-request text-center p-2 flex-fill ms-1 d-inline-block rounded-xl bg-light text-dark font-xsssss fw-700">
                                                    Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div>
                                    <h2> No Requests to show</h2>
                                </div>
                            @endforelse



                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- main content -->
    @push('scripts')
        <script>
            $(document).on("click", ".confirm-request", function(e) {
                e.preventDefault();

                let btn = $(this);
                let url = btn.data("url");

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        if (response.success) {
                            // ✅ Remove the card or replace with "Friends"
                            btn.closest(".col-md-3").fadeOut(300, function() {
                                $(this).remove();
                            });

                            // Optional: show success alert
                            alert(response.message);
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("Something went wrong!");
                    }
                });
            });
            $(document).on("click", ".delete-request", function(e) {
                e.preventDefault();

                let btn = $(this);
                let url = btn.data("url");

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        if (response.success) {
                            // ✅ Remove the card from the DOM
                            btn.closest(".col-md-3").fadeOut(300, function() {
                                $(this).remove();
                            });

                            // Optional success message
                            alert(response.message);
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert("Something went wrong while deleting request!");
                    }
                });
            });
        </script>
    @endpush
@endsection
