<!-- Story Popup Overlay -->
<div id="storyPopup" class="hidden fixed inset-0 bg-black/50 backdrop-blur-md flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-1/2 max-w-5xl h-4/5 p-8 relative flex items-center justify-center">

        <!-- Close Button -->
        <button onclick="toggleStoryPopup(false)"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">
            &times;
        </button>

        <!-- Story Options -->
        <div id="storyOptions" class="flex items-center justify-center space-x-16 h-full">
            <!-- Photo/Video Story Card -->
            <div onclick="openPhotoStoryForm()"
                class="cursor-pointer rounded-xl p-6 h-80 w-56 flex flex-col items-center justify-center
                       bg-gradient-to-tr from-blue-400 to-blue-600 text-white shadow-lg hover:scale-105 transition">
                <div class="bg-white text-black rounded-full p-6 mb-6 text-3xl">📷</div>
                <h3 class="font-semibold text-xl text-center">Create a Photo/Video Story</h3>
            </div>

            <!-- Text Story Card -->
            <div onclick="openTextStoryForm()"
                class="cursor-pointer rounded-xl p-6 h-80 w-56 flex flex-col items-center justify-center
                       bg-gradient-to-tr from-pink-400 to-purple-600 text-white shadow-lg hover:scale-105 transition">
                <div class="bg-white text-black rounded-full p-6 mb-6 text-3xl">✍️</div>
                <h3 class="font-semibold text-xl text-center">Create a Text Story</h3>
            </div>
        </div>

        <!-- Photo/Video Story Form -->
        <form id="photoStoryForm" class="hidden w-full h-full flex flex-col items-center justify-center"
            enctype="multipart/form-data">
            <h2 class="text-2xl font-bold mb-6">Upload Photo/Video Story</h2>

            <!-- Hidden File Input -->
            <input type="file" id="mediaInput" name="media" accept="image/*,video/*" class="hidden">

            <!-- Card Trigger for File Input -->
            <div id="selectMediaCard"
                class="cursor-pointer mb-6 w-64 h-64 flex flex-col items-center justify-center rounded-2xl border-2 border-dashed border-gray-400
               hover:border-blue-500 hover:bg-blue-50 transition shadow-md">
                <div class="text-5xl mb-3">📁</div>
                <p class="text-gray-600 font-medium">Click to select Photo/Video</p>
                <p class="text-sm text-gray-400">JPG, PNG, MP4 supported</p>
            </div>


            <!-- Preview Container -->
            <div id="mediaPreview"
                class="mb-4 hidden relative w-3/4 h-96 flex items-center justify-center border-2 border-dashed rounded-lg overflow-hidden">
            </div>




            <button type="submit"
                class="bg-blue-500 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                Post Story
            </button>
        </form>



        <!-- Text Story Form -->
        <form id="textStoryForm" class="hidden w-full h-full flex flex-col items-center justify-center">
            <h2 class="text-2xl font-bold mb-4">Write Text Story</h2>
            <textarea name="content" rows="5" class="w-3/4 border rounded p-2 mb-4" required></textarea>

            <button type="submit" class="bg-pink-500 text-white px-6 py-2 rounded-lg hover:bg-pink-600 transition">
                Post Story
            </button>
        </form>
    </div>
</div>
