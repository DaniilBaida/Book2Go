$(document).ready(function () {
    // Function to set the active class on both sidebar and header links
    function setActiveLink() {
        let currentPath = window.location.pathname;

        // Sidebar links
        $(".ajax-link").each(function () {
            let linkPath = $(this).data("path");
            if (linkPath === currentPath) {
                $(this).closest("li").addClass("active");
            } else {
                $(this).closest("li").removeClass("active");
            }
        });

        // Header links
        $(".header-link").each(function () {
            let linkPath = $(this).data("path");
            if (linkPath === currentPath) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });
    }

    // Listen for clicks on sidebar and header links
    $(".ajax-link, .header-link").click(function (e) {
        e.preventDefault();

        let url = $(this).attr("href");

        $.ajax({
            url: url,
            method: "GET",
            success: function (response) {
                $("#main-content").html(
                    $(response).find("#main-content").html()
                );
                window.history.pushState(null, "", url);
                setActiveLink(); // Update active link for both sidebar and header
            },
            error: function () {
                console.error("Failed to load content.");
            },
        });
    });

    // Handle browser back/forward navigation
    window.onpopstate = function () {
        $.get(location.href, function (response) {
            $("#main-content").html($(response).find("#main-content").html());
            setActiveLink(); // Update active link for both sidebar and header
        });
    };

    // Initial call to set the active link on page load
    setActiveLink();
});
