import './stimulus_bootstrap.js';
import './styles/app.css';
import 'bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

    if (!darkModeToggle) {
        console.error('Dark mode button not found');
        return;
    }

    if (localStorage.getItem('darkMode') === 'enabled') {
        body.classList.add('dark');
        darkModeToggle.innerHTML = '<i class="bi bi-sun-fill me-1"></i><span class="dark-mode-text">Clair</span>';
    }

    darkModeToggle.addEventListener('click', function () {
        body.classList.toggle('dark');

        if (body.classList.contains('dark')) {
            localStorage.setItem('darkMode', 'enabled');
            darkModeToggle.innerHTML = '<i class="bi bi-sun-fill me-1"></i><span class="dark-mode-text">Clair</span>';
        } else {
            localStorage.setItem('darkMode', 'disabled');
            darkModeToggle.innerHTML = '<i class="bi bi-moon-stars-fill me-1"></i><span class="dark-mode-text">Sombre</span>';
        }
    });
});
