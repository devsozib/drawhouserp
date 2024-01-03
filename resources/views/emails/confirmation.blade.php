<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <?php $year = date('Y', time()); ?>
    <head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="format-detection" content="date=no" />
	<meta name="format-detection" content="address=no" />
	<meta name="format-detection" content="telephone=no" />
    <meta name="author" content="Ruhul Amin"/>
	<meta name="x-apple-disable-message-reformatting" />
	<link href="https://fonts.googleapis.com/css?family=Yantramanav:300,400,500,700" rel="stylesheet" />
	<title>RM APPS || Applicant Mail</title>

	<style type="text/css" media="screen">
        body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#fffefe; -webkit-text-size-adjust:none }
        a { color:#2f774a; text-decoration:none }
        p { padding:0 !important; margin:0 !important }
        img { -ms-interpolation-mode: bicubic; }
        .mcnPreviewText { display: none !important; }
        .fluid-img img { width: 120px !important; max-width: 120px !important; height: auto !important; }

        /* Mobile styles */
        @media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
            u + .body .gwfw { width:100% !important; width:100vw !important; }
            .m-shell { width: 100% !important; min-width: 100% !important; }
            .m-center { text-align: center !important; }
            .center { margin: 0 auto !important; }
            .nav { text-align: center !important; }
            .text-top { line-height: 22px !important; }
            .td { width: 100% !important; min-width: 100% !important; }
            .bg { height: auto !important; -webkit-background-size: cover !important; background-size: cover !important; }
            .m-br-15 { height: 15px !important; }
            .p30-15 { padding: 30px 15px !important; }
            .p0-15-30 { padding: 15px 15px 30px 15px !important; }
            .pb40 { padding-bottom: 40px !important; }
            .pb0 { padding-bottom: 0px !important; }
            .pb20 { padding-bottom: 20px !important; }
            .m-td,.m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }
            .m-height { height: auto !important; }
            .m-block { display: block !important; }
            .fluid-img img { width: 150px !important; max-width: 150px !important; height: auto !important; }
            .column,.column-top,.column-dir,.column-bottom,.column-dir-top,.column-dir-bottom { float: left !important; width: 100% !important; display: block !important; }
            .content-spacing { width: 15px !important; }
        }
	</style>
    </head>
    <body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#f4f4f4; -webkit-text-size-adjust:none;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#f4f4f4" class="gwfw">
        <tr>
            <td align="center" valign="top">
                <!-- Main -->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" style="padding-bottom: 20px; padding-top: 30px;" class="pb0">
                            <!-- Shell -->
                            <table width="650" border="0" cellspacing="0" cellpadding="0" class="m-shell">
                                <tr>
                                    <td class="td" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                        <!-- Header -->
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="border-radius: 10px 10px 0px 0px;">
                                            <tr>
                                                <td style="padding: 20px 15px 15px 30px; border-bottom: 2px solid #f4f4f4;">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            @php                                                                
                                                                $host = request()->getHost();
                                                                $host = str_replace('.','_',$host);
                                                                $companyInfo = Config::get("rmconf.$host")??Config::get("rmconf.default");

                                                                $companyName = $companyInfo['name'];
                                                                $companyEmail = $companyInfo['hr_mail'];
                                                                $companyPhone = $companyInfo['hr_phone'];
                                                                $hrName = $companyInfo['hr_name'];
                                                                $website = $companyInfo['website'];
                                                                $location = $companyInfo['location'];
                                                                // if ($host == 'hris.lakeshorebakery.com') {
                                                                //     $companyName = Config::get('rmconf.lakeshorebakery') ;
                                                                //     $companyEmail =  Config::get('rmconf.lakeshorebakeryemail') ;
                                                                //     $companyPhone = '+8801313414431';
                                                                //     $hrName =  Config::get('rmconf.lakeshorebakeryhr');
                                                                // } elseif ($host == 'hris.drawhousedesign.com') {
                                                                //     $companyName = Config::get('rmconf.drawhousedesign') ;
                                                                //     $companyEmail = Config::get('rmconf.drawhousedesignemail') ;
                                                                //     $companyPhone = '+8801313414431';
                                                                //     $hrName =  Config::get('rmconf.drawhousedesignhr');
                                                                // } elseif ($host == 'hris.konacafedhaka.com') {
                                                                //     $companyName = Config::get('rmconf.konacafedhaka') ;
                                                                //     $companyEmail =  Config::get('rmconf.konacafedhakaemail') ;
                                                                //     $companyPhone = '+8801313414431';
                                                                //     $hrName = Config::get('rmconf.konacafedhakahr');
                                                                // } elseif ($host == 'hris.pochegroup.com') {
                                                                //     $companyName =  Config::get('rmconf.pochegroup') ;
                                                                //     $companyEmail =  Config::get('rmconf.pochegroupemail');
                                                                //     $companyPhone = '+8801313414431';
                                                                //     $hrName = Config::get('rmconf.pochegrouphr');
                                                                // } else {
                                                                //     $companyName = Config::get('rmconf.drawhousedesign') ;
                                                                //     $companyEmail = Config::get('rmconf.drawhousedesignemail') ;
                                                                //     $companyPhone = '+8801313414431';
                                                                //     $hrName =  Config::get('rmconf.drawhousedesignhr');
                                                                // }
                                                            @endphp
                                                            <th style="padding-bottom:10px !important; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;" class="column" width="1"></th>
                                                            <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td align="center">
                                                                            <h2 class="m-center" style="font-family: 'Neuropol'; text-transform: uppercase; font-size: 23px; color: #181a15;">{{ $companyName }}</h2>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text" style="padding-bottom: 10px; color:#292828; font-family:Arial, sans-serif; font-size:14px; line-height:20px; text-align:center; min-width:auto !important;">{{ $location }}<br><b> {{ $companyEmail  }}<br><a href="https://www.{{ $website }}">{{ $website }}</a></td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- END Header -->

                                        <!-- Title -->
                                        <div mc:repeatable="Select" mc:variant="Title">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                <tr>
                                                    <td style="padding: 20px 20px 20px 30px;" class="p0-15-30">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                {{-- <td colspan="2" class="h3 m-center" style="padding-bottom: 10px; color:#444444; font-family:'Yantramanav', Arial, sans-serif; font-size:20px; line-height:24px; font-weight:400; text-align:center; text-decoration: underline;">Notification Of Absence List</td> --}}
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" class="h3 m-center" style="padding-bottom: 10px; color:#444444; font-family:'Yantramanav', Arial, sans-serif; font-size:14px; line-height:20px; text-align: justify; text-justify: inter-word;">
                                                                    <div class="container">
                                                                        <div class="content">
                                                                            <p>
                                                                                Dear {{ $data['candidateName'] }},<br><br>
                                                                                Thank you for applying for the {{ $data['job_designation'] != null ? $data['job_designation'] : $data['emp_designation']  }} position at {{ $companyName }}. We have received your application and appreciate your interest in joining our team.<br><br>
                                                                                Your application details:<br>
                                                                                <strong>Name:</strong> {{ $data['candidateName'] }}<br>
                                                                                <strong>Email:</strong> {{ $data['candidateEmail'] }}<br>
                                                                                <strong>Position:</strong> {{ $data['job_designation'] != null ? $data['job_designation'] : $data['emp_designation']  }}<br><br>
                                                                                We will review your application and get back to you as soon as possible regarding the next steps in the hiring process.<br><br>
                                                                                If you have any questions or need further information, please don't hesitate to contact us at <b><a href="mailto:{{ $companyEmail }}">{{  $companyEmail }}</a></b> or <b><a href="tel:{{ $companyPhone }}">{{ $companyPhone }}</a></b>.<br><br>
                                                                                Thank you once again for considering {{ $companyName }} for your career journey.
                                                                            </p>
                                                                        </div>
                                                                        <div class="signature">
                                                                            <p>
                                                                                Best regards,<br>
                                                                                {{ $hrName }}<br>
                                                                                Contact: <a href="mailto:{{  $companyEmail }}">{{  $companyEmail }}</a>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- END Title -->

                                        <!-- Content -->
                                        <div mc:repeatable="Select" mc:variant="Content">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                <tr>
                                                    <td style="padding:  15px 20px 20px 30px;" class="p0-15-30">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            {{-- <tr>
                                                                <td class="text" style="padding-bottom: 10px; color:#666666; font-family:Arial, sans-serif; font-size:14px; line-height:25px; min-width:auto !important; text-align:left;">Thanks for your understanding.<br /><i><b>N.B.: This is an automatic system generated email. So Please do not reply on this email.</b></i></td>
                                                            </tr> --}}
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <!-- END Content -->

                                        <!-- Footer -->
                                        {{-- <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                            <tr>
                                                <td style="padding: 10px 10px 10px 30px; border-top: 2px solid #f4f4f4;" class="p30-15">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td class="text-footer2 m-center" style="color:#999999; font-family:Arial, sans-serif; font-size:14px; line-height:25px; text-align:left; min-width:auto !important;">Copyright {{ $year }} &copy; <a href="https://www.{{ request()->getHost() }}"  target="blank">{{ $companyName }}</a></td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                            <th style="padding-bottom:10px !important; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;" class="column" width="20"></th>
                                                            <th class="column-bottom" width="150" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; vertical-align:bottom;">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td align="right">
                                                                            <table class="center" border="0" cellspacing="0" cellpadding="0" style="text-align:center;">
                                                                                <tr>
                                                                                    <td class="img" width="40" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://www.facebook.com/drawhouse" target="_blank"><img src="https://erp.texeuropbd.com/public/backend/img/social/facebook-icon.png" width="32" height="32" border="0" alt="Facebook" /></a></td>
                                                                                    <td class="img" width="40" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://www.linkedin.com/company/drawhouse" target="_blank"><img src="https://erp.texeuropbd.com/public/backend/img/social/linkedin-icon.png" width="32" height="32" border="0" alt="LinkedIn" /></a></td>
                                                                                    <td class="img" width="40" style="font-size:0pt; line-height:0pt; text-align:left;"><a href="https://twitter.com/drawhouse" target="_blank"><img src="https://erp.texeuropbd.com/public/backend/img/social/twitter-icon.png" width="32" height="32" border="0" alt="Twitter" /></a></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </th>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table> --}}
                                        <!-- END Footer -->
				                    </td>
                                </tr>
                            </table>
			                <!-- END Shell -->
                        </td>
                    </tr>
                </table>
                <!-- END Main -->
            </td>
        </tr>
	</table>
</body>
</html>
