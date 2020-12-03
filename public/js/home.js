(function ($) {
    "use strict";
    $(document).on('ready', function () {

        $(function () {
            $.ajax({
                url: "http://localhost:8000/cart/ajax",
                type: 'GET',
                dataType: 'json'
            })
                .done(function (data) {
                    $('.shopping').html(data.display);
                })
                .fail(function (error) {
                    console.log(error);
                });
        });

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

        $('.remove').on('click', function (e) {
            e.preventDefault();

            if (confirm("Are you sure?")) {
                var url = $(this).data('url');
                var id = $(this).attr('data-id');
                var trCart = $('#tr-' + id);
                var liCart = $('#li-' + id);
                var subTotal = $('.subtotal');
                var total = $('.last .total');
                var totalAmount = $('.total .total-amount');

                $.ajax({
                    url: url,
                    type: 'DELETE'
                })
                    .done(function (data) {
                        //der lparent
                        trCart.remove();
                        liCart.remove();
                        subTotal.html(data);
                        total.html(subTotal.html());
                        totalAmount.html('$' + subTotal.html());
                        $('.shopping .total-count').html($('.shopping .total-count').html() - 1);
                    })
                    .fail(function (error) {
                        console.log(error);
                    });
            }

        });

        $('.cart_add').on('click', function (e) {

            e.preventDefault();

            var url = $(this).data('url');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json'
            })
                .done(function (data) {
                    $('.shopping').html(data.display);
                })
                .fail(function (error) {
                    console.log(error);
                });

        });

        //------------- DETAIL ADD - MINUS COUNT ORDER -------------//
        $('.btn-number').on('click', function (e) {
            e.preventDefault();

            var fieldName = $(this).attr('data-field');
            var type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            var id = $(this).attr('data-id');
            var unitPrice = $('#unit-' + id);
            var totalPrice = $('#total-' + id);
            var subTotal = $('.subtotal');
            var total = $('.last .total');
            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('data-min')) {
                        input.val(currentVal - 1).change();
                        totalPrice.html(unitPrice.data('unit') * input.val());
                        subTotal.html(parseInt(subTotal.html()) - unitPrice.data('unit'));
                        total.html(subTotal.html());
                    }
                    if (parseInt(input.val()) == input.attr('data-min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('data-max')) {
                        input.val(currentVal + 1).change();
                        totalPrice.html(unitPrice.data('unit') * input.val());
                        subTotal.html(parseInt(subTotal.html()) + unitPrice.data('unit'));
                        total.html(subTotal.html());
                    }
                    if (parseInt(input.val()) == input.attr('data-max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });
        $('.input-number').change(function () {

            var minValue = parseInt($(this).attr('data-min'));
            var maxValue = parseInt($(this).attr('data-max'));
            var valueCurrent = parseInt($(this).val());

            var name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            }
        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });


    });
})(jQuery);
