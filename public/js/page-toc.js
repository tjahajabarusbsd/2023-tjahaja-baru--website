(function () {
    const sections = document.querySelectorAll("[data-toc-section]");
    if (!sections.length) return;

    const links = document.querySelectorAll("[data-toc-link]");
    const ticks = document.querySelectorAll("[data-toc-tick]");

    function setActive(id) {
        links.forEach((l) =>
            l.classList.toggle("active", l.dataset.tocLink === id)
        );
        ticks.forEach((t) =>
            t.classList.toggle("active", t.dataset.tocTick === id)
        );
    }

    // "garis deteksi" tipis di sekitar 35% dari atas viewport
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) setActive(entry.target.id);
            });
        },
        { rootMargin: "-35% 0px -60% 0px" }
    );

    sections.forEach((s) => observer.observe(s));
})();
