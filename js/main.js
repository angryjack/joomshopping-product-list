jQuery(function ($) {
    $("button.load-more").on("click", function () {
        let t = $(this);
        t.hide();
        $.ajax({
            url: t.attr("data-link") +
                "&limit=" + +t.attr("data-limit") +
                "&start=" + +t.attr("data-start"),
            success: function (response) {
                let listProducts = $(response).find(".jshop.list_product");
                t.parent().find(".list-product").append(listProducts[0].innerHTML);
                t.attr("data-start", +t.attr("data-start") + +t.attr("data-limit"));

                if (t.attr("data-start") < t.attr("data-count")) {
                    t.show();
                }
            }
        });
    });
});
