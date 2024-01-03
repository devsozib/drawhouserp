
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ asset('frontend') }}/assets/js/jquery-3.2.1.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery-migrate.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery-ui.js"></script>

    <script src="{{ asset('frontend') }}/assets/js/popper.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/owl.carousel.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/scrollUp.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/cartsidebar.js"></script>

    <script src="{{ asset('frontend') }}/assets/js/script.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/slick.js" type="text/javascript" charset="utf-8"></script>
    <script>


      


        function removeSingleCartItem(productId, productSizeId, productOptionIds, productAddonIds, subCategoryAddonIds) {
            $.ajax({
                    method: "post",
                    url: 'erp/ajaxfunctions.php',
                    data: {
                        funName: "deleteSingleItemFromCart",
                        productId: productId,
                        productSizeId: productSizeId,
                        productOptionIds: productOptionIds,
                        productAddonIds: productAddonIds,
                        subCategoryAddonIds: subCategoryAddonIds
                    }
                })
                .done(function(response) {
                    getTotalProductOnCart();
                    $('#miniCartDetails').html(response);
                });
        }

        function getTotalProductOnCart() {
            $.ajax({
                    method: "post",
                    url: 'erp/ajaxfunctions.php',
                    data: {
                        funName: "getTotalProductOnCart"
                    }
                })
                .done(function(response) {
                    $('#totalCartProductsView').html(response);
                });
        }


        function reloadLocation() {
            location.reload();
        }
    </script>
    <script>
        $(".regular").slick({

        //     dots: false,
        //     infinite: true,
        //     speed: 300,
        //     slidesToShow: 5,
        //     centerMode: true,
        //     focusOnSelect: true,
        //     slidesToScroll: 1,
        //     autoplay: true,
        //     autoplaySpeed: 2000,
        //     arrows: false,
        //     responsive: [{
        //             breakpoint: 1024,
        //             settings: {
        //                 slidesToShow: 3,
        //                 slidesToScroll: 1,
        //                 infinite: true,
        //                 dots: false
        //             }
        //         },
        //         {
        //             breakpoint: 600,
        //             settings: {
        //                 slidesToShow: 1,
        //                 slidesToScroll: 1
        //             }
        //         },
        //         {
        //             breakpoint: 480,
        //             settings: {
        //                 slidesToShow: 1,
        //                 slidesToScroll: 1
        //             }
        //         }

        //     ]
        // });


            dots: false,
            arrows: false,
            infinite: true,
            speed: 300,
            slidesToShow: 5,
            fade: false,
            centerMode: true,
            focusOnSelect: true,
            slidesToScroll: 2,
            autoplay: true,
            responsive: [{
                    breakpoint: 768,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '10px',
                        slidesToShow: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        arrows: false,
                        centerMode: true,
                        centerPadding: '40px',
                        slidesToShow: 1
                    }
                }
            ]

        });

        function addToCart(productId) {
            $('#ppi').val(productId);
            $("#addToCartDirect").submit();
        }
        // function addToCartforFeatureProduct(productId) {
        //     $('#ppi').val(productId);
        //     $("#addToCartDirect").submit();
        // }
    </script>