$(document).ready(function () {
    // Function to load content via AJAX and replace main content
    function loadContent(url) {
        $.ajax({
            url: url,
            method: "GET",
            success: function (response) {
                $("#main-content").html(
                    $(response).find("#main-content").html()
                );
                window.history.pushState(null, "", url); // Update the URL without reloading
                $(document).trigger("content:loaded"); // Trigger custom event for active links or other scripts
            },
            error: function () {
                console.error("Failed to load content.");
            },
        });
    }

    // AJAX Search Handling
    $(document).on("click", ".ajax-search-button", function (e) {
        e.preventDefault();

        // Get the search query
        let searchQuery = $("#table-search-services").val();

        // Build the search URL with the query parameter
        let url =
            $("#search-form").attr("action") +
            "?search=" +
            encodeURIComponent(searchQuery);

        // Perform AJAX request to load search results dynamically
        loadContent(url);
    });

    // Handle clicks on the "Clear" button dynamically
    $(document).on("click", ".ajax-link", function (e) {
        e.preventDefault();

        let url = $(this).attr("href");

        // Perform AJAX request to reset the content
        loadContent(url);
    });

    // Handle browser back/forward navigation
    window.onpopstate = function () {
        loadContent(location.href);
    };
});
