        @if($ppsize==1)
            <script type="text/php">
                if ( isset($pdf) ) {
                    $font = $fontMetrics->get_font("Arial","regular");
                    $pdf->page_text(530, 20, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0,0,0));
                }
            </script>
        @elseif($ppsize==2)
            <script type="text/php">
                if ( isset($pdf) ) {
                    $font = $fontMetrics->get_font("Arial","regular");
                    $pdf->page_text(780, 20, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0,0,0));
                }
            </script>
        @elseif($ppsize==3)
            <script type="text/php">
                if (isset($pdf)) {
                    $font = $fontMetrics->get_font("Arial","regular");
                    $pdf->page_text(940, 20, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0,0,0));
                    $pdf->page_text(870, 50, "Payment Date: {{date('d-m-Y', strtotime($date)) }}", $font, 9, array(0,0,0));
                }
            </script>
        @endif
            @php
                $companyName = "";
                $logo = "";
                $logoWidth = "";
                $host = request()->getHost();

                if ($host == 'hris.lakeshorebakery.com') {
                    $companyName =  Config::get('rmconf.lakeshorebakery') ;
                    $logo = Config::get('rmconf.lakeshorebakerylogoblack') ;
                    $logoWidth = '70';
                    $location = 'Gulshan-2';
                } elseif ($host == 'hris.drawhousedesign.com') {
                    $companyName =  Config::get('rmconf.drawhousedesign') ;
                    $logo = Config::get('rmconf.drawhousedesignlogoblack');
                    $logoWidth = '250';
                    $location = 'Gulshan-2';
                } elseif ($host == 'hris.konacafedhaka.com') {
                    $companyName =  Config::get('rmconf.konacafedhaka') ;
                    $logo =  Config::get('rmconf.konacafedhakalogoblack') ;
                    $logoWidth = '70';
                    $location = 'Gulshan-2';
                } elseif ($host == 'hris.pochegroup.com') {
                    $companyName = Config::get('rmconf.pochegroup') ;
                    $logo = Config::get('rmconf.pochelogoblack') ;
                    $logoWidth = '100';
                    $location = 'Gulshan-2';
                } elseif ($host == 'hris.lakeshorebanani.com.bd') {
                    $companyName = Config::get('rmconf.lakeshoresuites') ;
                    $logo = Config::get('rmconf.lsslogowhite') ;
                    $logoWidth = '100';
                    $location = ' House # 81, Block D,Road # 13/A, Banani, Dhaka-1212, Bangladesh.';
                } elseif ($host == 'hris.themidoridhaka.com') {
                    $companyName = Config::get('rmconf.midory') ;
                    $logo = Config::get('rmconf.midorilogoblack') ;
                    $logoWidth = '100';
                    $location = 'Gulshan-2';
                } else {
                    $companyName =  Config::get('rmconf.drawhousedesign') ;
                    $logo = Config::get('rmconf.drawhousedesignlogoblack');
                    $logoWidth = '250';
                    $location = 'Gulshan-2';
                }
            @endphp
        <img src="{{ url('images/' . $logo) }}" height="25px" width="{{ $logoWidth }}">
        <p>{{ $location }}<br>