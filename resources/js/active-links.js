$(document).ready(function () {
    function setActiveLink() {
        let currentPath = window.location.pathname;

        // Update sidebar links
        $(".ajax-link").each(function () {
            let linkPath = $(this).data("path");
            if (linkPath === currentPath) {
                $(this).closest("li").addClass("active");
            } else {
                $(this).closest("li").removeClass("active");
            }
        });

        // Update header links
        $(".header-link").each(function () {
            let linkPath = $(this).data("path");
            if (linkPath === currentPath) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });
    }

    // Call setActiveLink initially on page load
    setActiveLink();

    // Update active links after AJAX content loads
    $(document).on("content:loaded", function () {
        setActiveLink();
    });
});
