(function () {
    if (!window.usersStories || !Array.isArray(window.usersStories)) {
        console.warn("usersStories not found or invalid.");
        return;
    }

    const users = window.usersStories;
    const defaultAvatar = window.defaultStoryAvatar || "";

    // Flatten all stories with reference to user
    const flat = [];
    users.forEach((u, uIndex) => {
        (u.stories || []).forEach((s, sIndex) => {
            flat.push({
                userIndex: uIndex,
                storyIndex: sIndex,
                userName: u.name,
                profile: u.profile_photo || defaultAvatar,
                media: s.media,
            });
        });
    });

    if (!flat.length) {
        console.warn("No stories available.");
        return;
    }

    // DOM elements
    const modal = document.getElementById("storyModal");
    const avatarEl = document.getElementById("storyAvatar");
    const userNameEl = document.getElementById("storyUserName");
    const contentEl = document.getElementById("storyContent");
    const closeBtn = modal.querySelector(".story-close");
    const prevBtn = document.getElementById("storyPrev");
    const nextBtn = document.getElementById("storyNext");

    let currentIndex = 0;

    function render(index) {
        if (index < 0) index = flat.length - 1;
        if (index >= flat.length) index = 0;
        currentIndex = index;

        const story = flat[currentIndex];
        if (!story) {
            console.warn("Story not found at index:", currentIndex);
            return;
        }

        // Debugging logs
        console.log("Rendering story:", story);

        avatarEl.src = story.profile || defaultAvatar;
        userNameEl.textContent = story.userName || "";
        contentEl.innerHTML = "";

        if (!story.media) return;

        if (/\.(mp4|webm|ogg)$/i.test(story.media)) {
            const v = document.createElement("video");
            v.src = story.media;
            v.autoplay = true;
            v.playsInline = true;
            v.controls = true;
            v.style.maxWidth = "100%";
            v.style.maxHeight = "90vh";
            contentEl.appendChild(v);
        } else {
            const img = document.createElement("img");
            img.src = story.media;
            img.style.maxWidth = "100%";
            img.style.maxHeight = "90vh";
            img.alt = story.userName + " story";
            contentEl.appendChild(img);
        }
    }

    function openModalAtUser(userIndex) {
        const i = flat.findIndex((s) => s.userIndex === parseInt(userIndex));
        if (i === -1) {
            console.warn("No stories found for user index:", userIndex);
            return;
        }
        modal.classList.remove("d-none");
        render(i);
    }

    function closeModal() {
        modal.classList.add("d-none");
        contentEl.innerHTML = "";
    }

    // Event listeners
    document.querySelectorAll(".user-story").forEach((el) => {
        el.addEventListener("click", () => {
            const ui = el.getAttribute("data-user-index");
            openModalAtUser(ui);
        });
    });

    closeBtn.addEventListener("click", closeModal);
    nextBtn.addEventListener("click", () => render(currentIndex + 1));
    prevBtn.addEventListener("click", () => render(currentIndex - 1));

    document.addEventListener("keydown", (e) => {
        if (modal.classList.contains("d-none")) return;
        if (e.key === "ArrowRight") render(currentIndex + 1);
        if (e.key === "ArrowLeft") render(currentIndex - 1);
        if (e.key === "Escape") closeModal();
    });
})();
