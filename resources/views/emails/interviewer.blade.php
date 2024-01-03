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
                                                                $logoblack = $companyInfo['logo_black'];
                                                                $location = $companyInfo['location'];

                                                                // if ($host == 'hris.lakeshorebakery.com') {
                                                                //     $companyName = "Lakeshore Bakery";
                                                                //     $companyEmail = "hr@lakeshorebakery.com";
                                                                // } elseif ($host == 'hris.drawhousedesign.com') {
                                                                //     $companyName = "DrawHouse Ltd";
                                                                //     $companyEmail = "hr@drawhousedesign.com";
                                                                // } elseif ($host == 'hris.konacafedhaka.com') {
                                                                //     $companyName = "Kona Cafe Dhaka";
                                                                //     $companyEmail = "hr@konacafedhaka.com";
                                                                // } else {
                                                                //     $companyName = "DrawHouse Ltd";
                                                                //     $companyEmail = "hr@drawhousedesign.com";
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
                                                                                Subject: Interview Schedule<br><br>
                                                                                Dear <b>{{ $data['interviewerName'] }}</b>,<br><br>
                                                                                We are writing to inform you about your role as an interviewer for upcoming interviews at DrawHouse. Your expertise and insight will contribute significantly to the selection process.<br><br>
                                                                                Below are the details for the upcoming interviews:<br><br>
                                                                                <strong>Candidate Name:</strong> {{ $data['candidateName'] }}<br>
                                                                                <strong>Contact Number:</strong> {{ $data['candidatePhone'] }}<br>
                                                                                <strong>Position:</strong> {{ $data['job_designation'] != null ? $data['job_designation'] : $data['emp_designation']  }}<br>
                                                                                <strong>Date:</strong> {{ \Carbon\Carbon::parse($data['datetime'])->format('F j, Y') }}<br>
                                                                                <strong>Time:</strong> {{ \Carbon\Carbon::parse($data['datetime'])->format('h:i A') }}<br>
                                                                                <strong>Location:</strong> {{ $data['location'] }}<br><br>
                                                                                Your participation is highly valued and your feedback will play a crucial role in our decision-making process. Please review the candidate's details prior to the interview.<br><br>
                                                                                If you have any questions or need further information, please do not hesitate to contact us at <b>{{ $data['getCreatedUserName'] }}</b> or <b>{{ $data['getCreatedUserPhone']?$data['getCreatedUserPhone']:'+880189651028' }}</b>.<br><br>
                                                                                Thank you for your time and dedication to {{ $companyName }}. Your contributions are greatly appreciated.<br><br>
                                                                                Best regards,<br>
                                                                                {{ $data['getCreatedUserName'] }}<br>
                                                                                {{ $data['getCreatedUserDesg'] }}<br>
                                                                                {{ $companyName }}<br>
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
