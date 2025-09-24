 @push('title')
     <title>view-group</title>
 @endpush
 <div class="main-content right-chat-active">

     <div class="middle-sidebar-bottom">
         <div class="middle-sidebar-left">
             <div class="row">
                 <div class="col-lg-12">
                     <div class="card w-100 border-0 p-0 bg-white shadow-xss rounded-xxl">
                         <div class="card-body h250 p-0 rounded-xxl overflow-hidden m-3 relative">
                             <!-- Cover Image -->
                             @if ($group->cover_photo)
                                 <img src="{{ asset('storage/' . $group->cover_photo) }}" alt="Cover Photo"
                                     class="cover-photo w-full h-[250px] rounded-xl border object-cover">
                             @else
                                 <img src="{{ asset('assets/images/u-bg.jpg') }}" alt="Cover Photo"
                                     class="w-full h-[250px] rounded-xl border object-cover">
                             @endif

                             @if ($currentUser && $currentUser->pivot->role === 'admin')
                                 <!-- Edit Cover Button + Form -->
                                 <form action="{{ route('user.updateProfile') }}" method="POST"
                                     enctype="multipart/form-data" class="absolute bottom-3 right-3 ajax-form">
                                     @csrf
                                     @method('PUT')

                                     <!-- Hidden File Input -->
                                     <input type="file" name="cover_photo" id="cover_photo" class="hidden"
                                         onchange="$(this).closest('form').submit()">

                                     <!-- Custom Button -->
                                     <label for="cover_photo"
                                         class="flex items-center bg-gray-600 bg-opacity-50 text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-opacity-70">
                                         <i class="feather-camera me-2"></i>
                                         Edit Cover
                                     </label>
                                 </form>
                             @endif
                         </div>



                         <div class="card-body d-block w-100 shadow-none mb-0 p-0 border-top-xs">
                             <ul class="nav nav-tabs h55 d-flex product-info-tab border-bottom-0 ps-4" id="pills-tab"
                                 role="tablist">
                                 <li class="active list-inline-item me-5"><a
                                         class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block active"
                                         href="" id="about_section" data-toggle="tab">About</a>
                                 </li>
                                 <li class="list-inline-item me-5"><a
                                         class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="" data-toggle="tab">Friends</a></li>
                                 <li class="list-inline-item me-5"><a
                                         class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="#navtabs3" data-toggle="tab">Discussion</a></li>
                                 <li class="list-inline-item me-5"><a
                                         class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="#navtabs4" data-toggle="tab">Video</a></li>
                                 <li class="list-inline-item me-5"><a
                                         class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="#navtabs3" data-toggle="tab">Group</a></li>
                                 <li class="list-inline-item me-5"><a
                                         class="link fw-700 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="#navtabs1" data-toggle="tab">Events</a></li>
                                 <li class="list-inline-item me-5"><a id="tab-photos"
                                         class="link fw-700 me-sm-5 font-xssss text-grey-500 pt-3 pb-3 ls-1 d-inline-block"
                                         href="" data-toggle="tab">
                                         Photos
                                     </a></li>
                             </ul>
                         </div>
                     </div>
                 </div>
                 {{-- abbout nav tab below --}}
                 <div id="tabContent" class="mt-3">

                 </div>


             </div>
         </div>

     </div>
 </div>
