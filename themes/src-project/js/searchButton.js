jQuery(function ($) {
    $(document).ready(function () {
        $('#searchIcon').click(function () {
            $('.search-form').toggle();
            console.log("Search Box");
        });
    });
});
