(function ($) {
    "use strict";
    $(document).on('ready', function () {

        $.ajax({
            url: "http://localhost:8000/cart/ajax",
            type: 'GET',
            dataType: 'json'
        })
            .done(function (data) {
                let html = '';
                let count = 0;
                let total = 0;
                for (let i = 0; i < data.length; i++) {
                    let product = JSON.parse(data[i].product);
                    html += '<li><a class="remove" title="remove this item" href="javascript:void(0);"><i class="fa fa-remove"></i></a><a class="cart-img" href="#"><img src="https://via.placeholder.com/70x70" alt="#"></a><h4><a href="#">' + product.name + '</a></h4><p class="quantity">' + data[i].quantity + 'x -<span class="amount">' + product.price + '$</span></p></li>';
                    total += product.price * data[i].quantity;
                    count += data[i].quantity;
                }
                $('.shopping-list').html(html);
                $('.total .total-amount').html('$' + total);
                $('.shopping .total-count').html(count);

            })
            .fail(function () {
                console.log(data);
                $('.shopping-item').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            });

        // $('.opdia').on("show.bs.modal", function () {
        //     var editId = $(this).data('id');
        //     var res = "";
        //     var success = false;
        //     var url = "/productModal/"+editId;
        //     $.when(
        //         $.ajax({
        //             type: 'GET',
        //             url: url,
        //             success: function (response) {
        //                 res = response;
        //                 success = true;
        //             },
        //             error: function () {
        //                 //handle error
        //             },
        //         })).then(function () {
        //             $("#myModal").html(res).modal("show");
        //         });
        // });

        $(document).on('click', '.quick-shop', function (e) {

            e.preventDefault();

            var url = $(this).data('url');

            $('#dynamic-content').html(''); // leave it blank before ajax call

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html'
            })
                .done(function (data) {
                    console.log(data);
                    $('#dynamic-content').html('');
                    $('#dynamic-content').html(data); // load response  
                })
                .fail(function () {
                    console.log(data);
                    $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                });

        });

        // $('.cart_add').on('click',function(e){
        //     e.preventDefault();

        //     var url = this.href;

        //     $.ajax({
        //         url: url,
        //         type: 'GET',
        //     })
        //     .done(function(data){
        //         console.log($(this).href); 
        //     })
        //     .fail(function(error){
        //         console.log(error); 
        //     });
        // });

        $('.cart_add').on('click', function (e) {

            e.preventDefault();

            var url = $(this).data('url');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (data) {
                    let html = '';
                    let count = 0;
                    let total = 0;
                    for (let i = 0; i < data.length; i++) {
                        let product = JSON.parse(data[i].product);
                        html += '<li><a class="remove" title="remove this item" href="javascript:void(0);"><i class="fa fa-remove"></i></a><a class="cart-img" href="#"><img src="https://via.placeholder.com/70x70" alt="#"></a><h4><a href="#">' + product.name + '</a></h4><p class="quantity">' + data[i].quantity + 'x -<span class="amount">' + product.price + '$</span></p></li>';
                        $('.shopping-list').html(html);
                        total += product.price * data[i].quantity;
                        count++;
                    }
                    $('.total-amount').html('$' + total);
                    $('.total-count').html(count);

                })
                .fail(function () {
                    console.log(data);
                    $('.shopping-item').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                });

        });


    });
})(jQuery);
