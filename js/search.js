$('.icon').click(function(){
    $('input#search').focus();
});

function search() {
    var query_value = $('input#search').val();
    $('b#search-string').html(query_value);
    if(query_value !== ''){
        $.ajax({
            type: "POST",
            url: "search.php",
            data: { query: query_value },
            cache: false,
            success: function(html){
                $("ul#results").html(html);
            }
        });
    }return false;
}

$("input#search").on("keyup", function(e) {
    //set timeout
    clearTimeout($.data(this, 'timer'));

    //set search string
    var search_string = $(this).val();

    //search
    if (search_string == '') {
        $("ul#results").fadeOut();
        $('h4#results-text').fadeOut();

    } else {
        $("ul#results").fadeIn();
        $('h4#results-text').fadeIn();
        $(this).data('timer', setTimeout(search, 10));
    }
});