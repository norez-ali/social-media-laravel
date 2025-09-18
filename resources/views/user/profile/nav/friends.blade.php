<div class="col-12">
    {{-- User Photos --}}
    <div class="card w-100 shadow-xss rounded-xxl border-0 p-4 mb-3 bg-white">
        <h2 class="font-bold mb-3">Friends</h2>
        <div class="row">
            @forelse ($friends as $friend)
                <div class="col-12 col-md-6 mb-3"> <!-- 1 per row on mobile, 2 per row on md+ -->
                    <div
                        class="card-body d-flex align-items-center justify-content-between p-3 bg-greylight rounded-3 shadow-sm">

                        <!-- Friend Avatar (Square) -->
                        <figure class="avatar mb-0 me-3 flex-shrink-0">
                            <img src="{{ $friend->profile && $friend->profile->profile_photo
                                ? asset('storage/profile_photos/' . $friend->profile->profile_photo)
                                : asset('assets/images/user-12.png') }}"
                                alt="friend_photo" class="w-16 h-16 rounded object-cover border shadow-sm object-top" />
                        </figure>

                        <!-- Name + Username -->
                        <div class="flex-grow-1 me-3">
                            <h4 class="fw-700 text-grey-900 font-xssss mb-1">
                                {{ $friend->name }}
                            </h4>
                            <span class="d-block font-xssss fw-500 text-grey-500">
                                {{ $friend->profile->username ?? 'username' }}
                            </span>
                        </div>

                        <!-- Profile Button -->
                        <a href="{{ route('user.profile', $friend->id) }}"
                            class="send-request px-4 py-2 rounded-lg bg-success font-xss font-semibold text-white flex-shrink-0">
                            Profile
                        </a>

                    </div>
                </div>

            @empty
                {{-- or we will show the suggestions --}}
                @foreach ($suggested_users as $user)
                    <div class="col-12 col-md-6 mb-3"> <!-- 1 per row on mobile, 2 per row on md+ -->
                        <div
                            class="card-body d-flex align-items-center justify-content-between p-3 bg-greylight rounded-3 shadow-sm">

                            <!-- User Avatar (Square) -->
                            <figure class="avatar mb-0 me-3 flex-shrink-0">
                                <img src="{{ $user->profile && $user->profile->profile_photo
                                    ? asset('storage/profile_photos/' . $user->profile->profile_photo)
                                    : asset('assets/images/user-12.png') }}"
                                    alt="suggested_photo"
                                    class="w-16 h-16 rounded object-cover border shadow-sm object-top object-cover" />
                            </figure>

                            <!-- Name + Username -->
                            <div class="flex-grow-1 me-3">
                                <h4 class="fw-700 text-grey-900 font-xssss mb-1">
                                    {{ $user->name }}
                                </h4>
                                <span class="d-block font-xssss fw-500 text-grey-500">
                                    {{ $user->profile->username ?? 'username' }}
                                </span>
                            </div>

                            <!-- Profile Button -->
                            <a href="{{ route('user.profile', $user->id) }}"
                                class="send-request px-4 py-2 rounded-lg bg-success font-xss font-semibold text-white flex-shrink-0 object-cover object-top">
                                Profile
                            </a>


                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</div>
