    const profileImage = document.getElementById('profileImage');
    const dropdownMenu = document.getElementById('dropdownMenu');

    // Toggle the visibility of the dropdown menu
    profileImage.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    // Optional: Close the dropdown menu when clicking outside of it
    document.addEventListener('click', function (e) {
        if (!profileImage.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });