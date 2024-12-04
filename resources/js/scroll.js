document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll(".scroll-link");
    const sections = document.querySelectorAll("section");

    // Smooth scrolling
    links.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const targetId = link.getAttribute("href").substring(1);
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop - 80, // Navbar height adjustment
                    behavior: "smooth",
                });
            }
        });
    });

    // Highlight active link
    window.addEventListener("scroll", () => {
        let current = "";

        sections.forEach((section) => {
            const sectionTop = section.offsetTop - 100; // Adjust for navbar height
            const sectionHeight = section.offsetHeight;

            if (
                window.scrollY >= sectionTop &&
                window.scrollY < sectionTop + sectionHeight
            ) {
                current = section.getAttribute("id");
            }
        });

        links.forEach((link) => {
            link.classList.remove("scroll-active");
            if (link.getAttribute("href").substring(1) === current) {
                link.classList.add("scroll-active");
            }
        });
    });
});
