const darkModeButton = document.getElementById('darkModeButton');
darkModeButton.addEventListener('click', toggleDarkMode);

function toggleDarkMode() {
    const body = document.body;
    body.classList.toggle('dark-mode');
}