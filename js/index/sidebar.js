$(document).ready(function(){
    $('#sidebarCollapse').on('shown.bs.collapse', function () {
        $('.overlay').show();
    });

    $('#sidebarCollapse').on('hidden.bs.collapse', function () {
        $('.overlay').hide();
    });
});

$(document).ready(function(){
    $('.overlay-sidebar .close').click(function(){
        $('#sidebarCollapse').collapse('hide');
        $('.overlay').hide();
    });
});
$(document).ready(function(){
    $('.sidebar-small').click(function(){
        $('.sidebar-large').toggleClass('show');
        if ($('.sidebar-large').hasClass('show')) {
            $('.overlay').show();
            $('.sidebar-large').css('left', '0');
        } else {
            $('.overlay').hide();
            $('.sidebar-large').css('left', '-200px');
        }
    });
});