<script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/jquery-1.12.4.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/owl-carousel/owl.carousel.min.js"></script>

    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/bootstrap4/js/bootstrap.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/imagesloaded.pkgd.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/masonry.pkgd.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/isotope.pkgd.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/jquery.matchHeight-min.js"></script>

    <!-- <script src="plugins/slick/slick/slick.min.js"></script> -->

    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
    <!-- <script src="plugins/slick-animation.min.js"></script> -->
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/lightGallery-master/dist/js/lightgallery-all.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/sticky-sidebar/dist/sticky-sidebar.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/select2/dist/js/select2.full.min.js"></script>
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/plugins/gmap3.min.js"></script>
    <!-- Custom scripts-->
    <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/js/main.js"></script>
    <script type="text/javascript" src="{{ asset('lakeshore_bakery') }}/frontend/assets/cdn.jsdelivr.net/npm/slick-carousel%401.8.1/slick/slick.min.js"></script>

    {{-- <script src="{{ asset('lakeshore_bakery') }}/frontend/assets/unpkg.com/sweetalert%402.1.2/dist/sweetalert.min.js"></script> --}}

    <script type="text/javascript">
        $(document).ready(function () {

            $('#homePage1stSlider').slick({
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 3,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: false,
                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }

                ]
            });

            $('#mainSliderHome').slick({
                dots: false,
                infinite: true,
                speed: 300,
                slidesToShow: 1,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 5000,
                arrows: false
            });

            var itemType = "0";

            if (itemType == null || itemType == '0' || itemType == '' || itemType == undefined) {
                return false;
            } else {
                var itemId = "#itemType" + itemType;
                $('#allItem').removeClass("active");
                $(itemId).addClass('active');
            }

        });



        function customerLogin() {
            $('#loginDiv').attr("class", "ps-popup active");
        }

        function authenticate() {

            var mobile = $('#mobile').val();
            var password = $('#password').val();

            var intRegex = /(^(\+8801|8801|01|008801))[1|3-9]{1}(\d){8}$/;
            if (!mobile.match(intRegex)) {
                swal('Enter a Valid Mobile Number', '', 'warning');
                return false;
            }

            if (mobile != "" && password != "") {
                $.ajax({
                    method: "post",
                    url: 'erp/login.php',
                    data: {
                        function: "felogin",
                        mobileNumber: mobile,
                        password: password,
                    }
                })
                    .done(function (response) {

                        //console.log(response);

                        // $('.loader-holder').hide(200);

                        if (parseInt(response) != 0) {

                            swal("Login Successful !", {
                                icon: "success",
                            });

                            location.reload(true);
                            console.log(response);
                        } else {
                            swal("Incorrect Mobile Number or Password !", {
                                icon: "error",
                            });
                        }
                    });
            }

        }

        function addToCart(productId) {
            console.log(productId);
            if (productId != "" && productId != null && productId != undefined) {
                $.ajax({
                    method: "post",
                    url: 'erp/addtocartdirect.php',
                    data: {
                        productId: productId,
                        deviceType: ''

                    }
                })
                    .done(function (response) {


                        if (response != null && response.trim() != 'false' && response != undefined) {


                            $('#miniCartDiv').html(response);
                            // $('#navigation').load("includes/navigation.php");
                            // ajax call for mobile



                            $('#miniCartContent').css({
                                "visibility": "visible",
                                "opacity": "1",
                                "animation-duration": "300ms"
                            });

                            $.ajax({
                                method: "post",
                                url: 'erp/reloadMiniCart.php',
                                data: {
                                    deviceType: 'mobileDevice'

                                }
                            })
                                .done(function (response) {


                                    if (response != null && response.trim() != 'false' && response != undefined) {


                                        $('#miniCartContentMobile').html(response);
                                        getTotalProductOnCartMobile();

                                        // swal({
                                        //     position: 'top-end',
                                        //     icon: 'success',
                                        //     title: 'Product Added To Cart',
                                        //     showConfirmButton: false,
                                        //     timer: 500
                                        // })

                                    }

                                });


                        } else if (response.trim() == 'false') {


                            $('#productOptionDiv ').html("No Options in This Product Size Yet");



                        } else {
                            console.log(response);
                            swal("Request Can't Be Processed !", {
                                icon: "error",
                            });
                        }


                    });
            } else {
                swal("Request Can't Be Processed !", {
                    icon: "error",
                });
            }

        }

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
                    subCategoryAddonIds: subCategoryAddonIds,
                    deviceType: 'mobileDevice'
                }
            })
                .done(function (response) {
                    getTotalProductOnCart();
                    $('#miniCartContentMobile').html(response);
                    getTotalProductOnCartMobile();
                });


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
                .done(function (response) {
                    getTotalProductOnCart();
                    $('#miniCartDiv').html(response);
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
                .done(function (response) {
                    $('#totalCartProductsView').html(response);
                });
        }

        function getTotalProductOnCartMobile() {
            $.ajax({
                method: "post",
                url: 'erp/ajaxfunctions.php',
                data: {
                    funName: "getTotalProductOnCart"
                }
            })
                .done(function (response) {
                    $('#totalCartProductsViewForMobile ').html(response);
                });
        }
    </script>