window.onload = () => {
    $(".tricks-more").hide().slice(0, 5).css("display", "flex");

    $(".scroll-to-up").hide();

    $("#loadMore").click(function (e) {
        e.preventDefault();
        $(".tricks-more:hidden").slice(0, 5).css("display", "flex");
        if ($(".tricks-more:hidden").length === 5) {
            $(".scroll-to-up").show();
        }
        if ($(".tricks-more:hidden").length === 0) {
            $("#loadMore").attr("disabled", "disabled");
            alert("No more!");
        }
    });
};

    $(".media-none").hide();
    $(".bt-edit-poster").hide();
    $('.see').click(function () {
        $(".media-none").toggle();
        $(".bt-edit-poster").toggle();
        $(this).val($(this).val() == 'Not See Medias' ? 'See Medias' : 'Not See Medias');
    });


