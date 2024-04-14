$(document).ready(function() {
    var isSidebarOpen = false;

    $('.sidebar-small').click(function() {

        $('.sidebar-large').toggleClass('show');
        if ($('.sidebar-large').hasClass('show')) {
            $('.overlay').show();
            $('.sidebar-large').css('left', '0');
            isSidebarOpen = true; 
            $('#sidebarToggleButton').prop('disabled', true); 
        } else {
            $('.overlay').hide();
            $('.sidebar-large').css('left', '-200px');
            isSidebarOpen = false;
            $('#sidebarToggleButton').prop('disabled', false);
        }
    });

    // Close sidebar when click on cross
    $('.overlay-sidebar .close').click(function() {
        $('.sidebar-large').removeClass('show').css('left', '-200px');
        $('.overlay').hide();
        isSidebarOpen = false;
        $('#sidebarToggleButton').prop('disabled', false);
    });

    // Close the sidebar when click outside
    $(document).click(function(event) {
        if (isSidebarOpen && !$(event.target).closest('.sidebar-large, .sidebar-small').length) {
            $('.sidebar-large').removeClass('show').css('left', '-200px');
            $('.overlay').hide();
            isSidebarOpen = false;
            $('#sidebarToggleButton').prop('disabled', false);
        }
    });
});
