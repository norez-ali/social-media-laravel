@extends('layout.main')

@section('content')
    <div class="content">
        @include('user.groups.index')

    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                // Catch ALL <a> inside .nav-wrap with class .left-nav
                $(document).on("click", ".nav-wrap .left-side", function(e) {
                    e.preventDefault(); // stop browser from reloading
                    e.stopPropagation(); // avoid bubbling

                    let url = $(this).attr("href"); // take href dynamically
                    let $this = $(this);

                    $.ajax({
                        url: url,
                        type: "GET",
                        beforeSend: function() {
                            $(".content").html('<div class="p-5 text-center">Loading...</div>');
                        },
                        success: function(data) {
                            // Inject view into .content
                            $(".content").html(data);

                            // Update browser URL without reload
                            window.history.pushState(null, "", url);


                        },
                        error: function() {
                            $(".content").html(
                                '<div class="p-5 text-center text-danger">Error loading page.</div>'
                            );
                        },
                    });
                });
            });
        </script>
    @endpush
@endsection
