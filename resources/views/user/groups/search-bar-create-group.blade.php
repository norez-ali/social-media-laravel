@extends('layout.main')

@section('content')
    <div class="content">
        @include('user.groups.create-group')

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
@endsection
