<div class="col-12">
    {{-- User Photos --}}
    <div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mb-3 bg-white">
        <h2 class="font-bold mb-3">Members</h2>
        <div class="row g-3 ps-2 pe-2">
            @forelse ($members as $member)
                <!-- Friend Card -->
                <div class="col-md-3 col-sm-6">
                    <div class="card border-0 shadow-xss rounded-3 overflow-hidden h-100">

                        <!-- Image Cover -->
                        <div class="card-img-top position-relative" style="height:180px; overflow:hidden;">
                            <a href="{{ route('user.profile', $member->id) }}">
                                <img src="{{ $member->profile && $member->profile->profile_photo
                                    ? asset('storage/profile_photos/' . $member->profile->profile_photo)
                                    : asset('assets/images/user-12.png') }}"
                                    class="w-100 h-100 object-fit object-cover object-top" alt="profile-photo">
                            </a>
                        </div>



                        <!-- Body -->
                        <div class="card-body text-center">
                            <!-- Name -->
                            <a href="{{ route('user.profile', $member->id) }}">
                                <h4 class="fw-700 font-xsss mt-3 mb-1">
                                    {{ $member->name }}
                                </h4>
                            </a>
                            <!-- Followers -->
                            <p class="fw-500 font-xsssss text-grey-500 mt-0 mb-3">
                                {{ $member->profile->username ?? 'username' }}</p>
                            <!-- Buttons -->
                            <div class="d-flex justify-content-between">
                                @if ($currentUser && $currentUser->pivot->role === 'admin')
                                    <a href="javascript:void(0);" data-group-id="{{ $group->id }}"
                                        data-user-id="{{ $member->id }}"
                                        class="reject-request text-center p-2 flex-fill me-1 d-inline-block rounded-xl bg-primary font-xsssss fw-700 text-white">
                                        Remove
                                    </a>
                                @else
                                    <a href="{{ route('user.profile', $member->id) }}"
                                        class="text-center p-2 flex-fill me-1 d-inline-block rounded-xl bg-primary font-xsssss fw-700 text-white">
                                        View Profile
                                    </a>
                                @endif


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
