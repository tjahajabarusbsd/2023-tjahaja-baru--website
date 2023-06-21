$(document).ready(function () {
    // Get the current URL path
    const currentPath = window.location.pathname;

    // Get all menu links
    const menuLinks = document.querySelectorAll('.nav-link');

    // Add 'active' class to the menu item matching the current URL
    menuLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active-nav');
        }
    });

});
