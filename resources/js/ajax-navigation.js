$(document).ready(function () {
    function loadContent(url) {
        $.ajax({
            url: url,
            method: "GET",
            success: function (response) {
                $("#main-content").html(
                    $(response).find("#main-content").html()
                );
                window.history.pushState(null, "", url);
                $(document).trigger("content:loaded"); // Trigger custom event for other scripts
            },
            error: function () {
                console.error("Failed to load content.");
            },
        });
    }

    // Listen for clicks on AJAX links
    $(document).on("click", ".ajax-link", function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        loadContent(url);
    });

    // Handle browser back/forward navigation
    window.onpopstate = function () {
        loadContent(location.href);
    };
});
