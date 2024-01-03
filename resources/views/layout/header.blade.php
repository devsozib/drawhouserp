 @php
     $host = request()->getHost();
    //  $host = "b_com";
    //  $host = str_replace('_','.',$host);
    //  _print($host);
 @endphp
    @if ($host == 'hris.drawhousedesign.com')
        <style>
            .bg-cyan {
                background-color: #2d2d2d !important;
            }

            .navbar-light .navbar-nav .nav-link {
                color: rgb(255 255 255 / 50%);
            }
            @media (max-width: 576px) {
                .brand-link .brand-image {
                    width: 102px !important;
                }
        }
        </style>
    @elseif ($host == 'hris.lakeshorebakery.com')
        <style>
            .bg-cyan {
                background-color: #2d2d2d !important;
            }

            .navbar-light .navbar-nav .nav-link {
                color: rgb(255 255 255 / 50%);
            }
            .brand-link .brand-image {
            float: left;
            line-height: .8;
            margin-left: 0.8rem;
            margin-right: 0.5rem;
            margin-top: -3px;
                max-height: 57px;
            width: auto;
            }
            @media (max-width: 576px) {
                .brand-link .brand-image {
                    width: 50px !important;
                }
            }
        </style>
    @elseif ($host == 'hris.konacafedhaka.com')
        <style>
            .bg-cyan {
                background-color: #2d2d2d !important;
            }

            .navbar-light .navbar-nav .nav-link {
                color: rgb(255 255 255 / 50%);
            }
            @media (max-width: 576px) {
            .brand-link .brand-image {
                width: 102px !important;
            }
        }
        .brand-link .brand-image {
            max-height: 65px!important;
        }
        </style>
    @elseif ($host == 'hris.pochegroup.com')
        <style>
            .bg-cyan {
                background-color: #2d2d2d !important;
            }

            .navbar-light .navbar-nav .nav-link {
                color: rgb(255 255 255 / 50%);
            }
            @media (max-width: 576px) {
                .brand-link .brand-image {
                    width: 102px !important;
                }
            }
        .brand-link .brand-image {
            max-height: 65px!important;
        }
        </style>
    @elseif ($host == 'hris.lakeshorebanani.com.bd')
        <style>
            .bg-cyan {
                background-color: #2dace2 !important;
            }

            .navbar-light .navbar-nav .nav-link {
                color: rgb(255 255 255 / 50%);
            }
            @media (max-width: 576px) {
                .brand-link .brand-image {
                    width: 66px !important;
                }
            }
        .brand-link .brand-image {
            max-height: 65px!important;
        }
        </style>
        @elseif ($host == 'hris.themidoridhaka.com')
        <style>
            .bg-cyan {
                background-color: #2dace2 !important;
            }

            .navbar-light .navbar-nav .nav-link {
                color: rgb(255 255 255 / 50%);
            }
            @media (max-width: 576px) {
                .brand-link .brand-image {
                    width: 66px !important;
                }
            }
            .brand-link .brand-image {
                max-height: 50px!important;
            }
            </style>
        @elseif ($host == 'hris.lakeshorebanani.com.bd')
            <style>
                .bg-cyan {
                    background-color: #2dace2 !important;
                }

                .navbar-light .navbar-nav .nav-link {
                    color: rgb(255 255 255 / 50%);
                }
                @media (max-width: 576px) {
                    .brand-link .brand-image {
                        width: 66px !important;
                    }
                }
            .brand-link .brand-image {
                max-height: 65px!important;
            }
            </style>

        @elseif ($host == 'hris.lakeshorebanani.com.bd')
            <style>
                .bg-cyan {
                    background-color: #2dace2 !important;
                }

                .navbar-light .navbar-nav .nav-link {
                    color: rgb(255 255 255 / 50%);
                }
                @media (max-width: 576px) {
                    .brand-link .brand-image {
                        width: 66px !important;
                    }
                }
            .brand-link .brand-image {
                max-height: 48px!important;
            }
            </style>        
        @elseif ($host == 'hrisheights.lakeshorehotels.com')
            <style>
                .bg-cyan {
                    background-color: #2dace2 !important;
                }

                .navbar-light .navbar-nav .nav-link {
                    color: rgb(255 255 255 / 50%);
                }
                @media (max-width: 576px) {
                    .brand-link .brand-image {
                        width: 66px !important;
                    }
                }
            .brand-link .brand-image {
                max-height: 65px!important;
            }
            </style>       
        @elseif ($host == 'hrisgrand.lakeshorehotels.com')
            <style>
                .bg-cyan {
                    background-color: #2dace2 !important;
                }

                .navbar-light .navbar-nav .nav-link {
                    color: rgb(255 255 255 / 50%);
                }
                @media (max-width: 576px) {
                    .brand-link .brand-image {
                        width: 66px !important;
                    }
                }
            .brand-link .brand-image {
                max-height: 65px!important;
            }
            </style>
        @else
            <style>
                .bg-cyan {
                    background-color: #2d2d2d !important;
                }

                .navbar-light .navbar-nav .nav-link {
                    color: rgb(255 255 255 / 50%);
                }
                @media (max-width: 576px) {
                    .brand-link .brand-image {
                        width: 102px !important;
                    }
            }
            </style>
        @endif

 <nav class="custom-header no-print navbar navbar-expand navbar-white navbar-light bg-cyan" style="padding: 0px;">
     <!-- Left navbar links -->
     <ul class="navbar-nav">
         <!-- <div class="d-flex align-items-center justify-content-between" style="width: 230px">
        <a href="{{ url('welcome') }}" class="logo d-flex align-items-center">
          <img src="{{ url('images/favicon-32x32.png') }}" class="img-circle elevation-2" alt="User Image">
          <span class="d-none d-lg-block">&nbsp;RM APPS</span>
        </a>
      </div> -->
        @php
            $host = str_replace('.','_',$host);
            $companyInfo = Config::get("rmconf.$host")??Config::get("rmconf.default");

            $companyName = $companyInfo['name'];
            $logo = $companyInfo['logo'];
            $logoWidth = $companyInfo['logo_width'];
            $location = $companyInfo['location'];

            //    if ($host == Config::get('rmconf.lakeshorebakerydomain')) {
            //     $companyName =  Config::get('rmconf.lakeshorebakery') ;
            //     $logo =  Config::get('rmconf.lakeshorebakerylogowhite') ;
            //     $logoWidth = '67';
            //     $location = 'Gulshan-2';
            // } elseif ($host == Config::get('rmconf.drawhousedesigndomain')) {
            //     $companyName =  Config::get('rmconf.drawhousedesign') ;
            //     $logo = Config::get('rmconf.drawhousedesignlogowhite') ;
            //     $logoWidth = '250';
            //     $location = 'Gulshan-2';
            // } elseif ($host == Config::get('rmconf.konacafedhakadomain')) {
            //     $companyName =  Config::get('rmconf.konacafedhaka') ;
            //     $logo = Config::get('rmconf.konacafedhakalogowhite');
            //     $logoWidth = '108';
            //     $location = 'Gulshan-2';
            // } elseif ($host == Config::get('rmconf.pochegroupdomain')) {
            //     $companyName = Config::get('rmconf.pochegroup');
            //     $logo = Config::get('rmconf.pochelogowhite') ;
            //     $logoWidth = '100';
            //     $location = 'Gulshan-2';
            // } elseif ($host == Config::get('rmconf.lakeshoresuitesdomain')) {
            //     $companyName = Config::get('rmconf.lakeshoresuites');
            //     $logo = Config::get('rmconf.lsslogowhite') ;
            //     $logoWidth = '100';
            //     $location = ' House # 81, Block D,Road # 13/A, Banani, Dhaka-1212, Bangladesh.';
            // } elseif ($host == Config::get('rmconf.midoridomain')) {
            //     $companyName =Config::get('rmconf.midori');
            //     $logo = Config::get('rmconf.midorilogo') ;
            //     $logoWidth = '100';
            //     $location = 'Gulshan-2';
            // }elseif($host == Config::get('rmconf.drawhousedesigndomain')) {
            //     $companyName =  Config::get('rmconf.drawhousedesign') ;
            //     $logo = Config::get('rmconf.drawhousedesignlogowhite') ;
            //     $logoWidth = '250';
            //     $location = 'Gulshan-2';
            // }
            // elseif($host == Config::get('rmconf.lsheightsdomain')) {
            //     $companyName =  Config::get('rmconf.lsheights') ;
            //     $logo = Config::get('rmconf.heightslogo') ;
            //     $logoWidth = '100';
            //     $location = 'Gulshan-2';
            // }
            // elseif($host == Config::get('rmconf.lsgranddomain')) {
            //     $companyName =  Config::get('rmconf.lsgrand') ;
            //     $logo = Config::get('rmconf.grandlogo') ;
            //     $logoWidth = '100';
            //     $location = 'Gulshan-2';
            // }
        @endphp
         <div class="d-flex align-items-center justify-content-between">
             <a href="{{ url('welcome') }}" class="brand-link logo d-flex appsname" style="padding: 0px;">
                 <img style="width:{{ $logoWidth }}px; " src="{{ url('images/',$logo) }}" alt="Logo"
                     class="brand-image">
                 {{-- <span class="brand-text">&nbsp;{{ Config::get('rmconf.apps_name') }}</span> --}}
             </a>
         </div>
         @if (Request::is('welcome'))
             <script>
                 //$('body').removeClass();
                 //$('body').addClass('sidebar-collapse');
             </script>
         @endif
         @if (!Request::is('welcome'))
             <li class="nav-item">
                 <a class="nav-link" data-widget="pushmenu" href="javascript:void(0);" role="button"><i
                         class="fas fa-bars"></i></a>
             </li>
         @endif
         <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="{!! url('admin/user') !!}" class="nav-link">User</a>
      </li> -->
     </ul>
     <!-- Right navbar links -->
     <ul class="navbar-nav ml-auto">
         <!-- Messages Dropdown Menu -->
         <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0);">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">4</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="javascript:void(0);" class="dropdown-item">
            <div class="media">
              <img src="{{ url('theme/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:void(0);" class="dropdown-item">
            <div class="media">
              <img src="{{ url('theme/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:void(0);" class="dropdown-item">
            <div class="media">
              <img src="{{ url('theme/dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a href="javascript:void(0);" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> -->
         <!-- Notifications Dropdown Menu -->
         @php
            $today = \Carbon\Carbon::now()->toDateString();
            $userid = Sentinel::getUser()->empid;
            $notices = \App\Models\HRIS\Setup\Notice::leftJoin('hr_setup_notice_participants as par', 'par.notice_id', '=', 'hr_setup_notices.id')
                ->where('par.emp_id', '=', $userid)
                ->where('par.seen', '=', '0')->where('hr_setup_notices.showing_date', '<=', $today)->where('hr_setup_notices.company_id', getHostInfo()['id'])->orderBy('hr_setup_notices.created_at', 'desc')->count();
            $noticeLast =\App\Models\HRIS\Setup\Notice::leftJoin('hr_setup_notice_participants as par', 'par.notice_id', '=', 'hr_setup_notices.id')
                ->where('par.emp_id', '=', $userid)
                ->where('par.seen', '=', '0')->where('hr_setup_notices.showing_date', '<=', $today)->where('hr_setup_notices.company_id', getHostInfo()['id'])->orderByDesc('hr_setup_notices.id')->latest()->select('hr_setup_notices.*', 'par.created_at as notice_created_at')->first();
            $trainings = \App\Models\HRIS\Setup\Training::leftJoin('hr_setup_training_participants as par', 'par.training_id', '=', 'hr_setup_trainings.id')
                ->where('par.participant_id', '=', $userid)
                ->where('par.seen', '=', '0')
                ->where('hr_setup_trainings.company_id', getHostInfo()['id'])
                ->orderByDesc('hr_setup_trainings.id')
                ->count();
            $lasttraining = \App\Models\HRIS\Setup\Training::leftJoin('hr_setup_training_participants as par', 'par.training_id', '=', 'hr_setup_trainings.id')
            ->where('par.participant_id', '=', $userid)
            ->where('hr_setup_trainings.company_id', getHostInfo()['id'])
            ->orderByDesc('hr_setup_trainings.id')
            ->latest()
            ->select('hr_setup_trainings.*', 'par.created_at as training_created_at')
            ->first();
            $meetings = \App\Models\HRIS\Setup\Meeting::leftJoin('hr_setup_meeting_participants as par', 'par.meeting_id', '=', 'hr_setup_meeting.id')
                ->where('par.participant_id', '=', $userid)
                ->where('par.seen', '=', '0')
                ->where('hr_setup_meeting.company_id', getHostInfo()['id'])
                ->orderByDesc('hr_setup_meeting.id')
                ->count();
            $lastMeeting = \App\Models\HRIS\Setup\Meeting::leftJoin('hr_setup_meeting_participants as par', 'par.meeting_id', '=', 'hr_setup_meeting.id')
            ->where('par.participant_id', '=', $userid)
            ->where('hr_setup_meeting.company_id', getHostInfo()['id'])
            ->orderByDesc('hr_setup_meeting.id')        
            ->latest()
            ->select('hr_setup_meeting.*', 'par.created_at as meeting_created_at')
            ->first();
            $tasks = \App\Models\HRIS\Setup\Task::leftJoin('hr_setup_task_assigns', 'hr_setup_task_assigns.task_id', '=', 'hr_setup_tasks.id')
            ->select('hr_setup_tasks.*')
            ->where('hr_setup_task_assigns.emp_id', '=', $userid)
            ->where('hr_setup_task_assigns.seen', '=', '0')
            ->where('hr_setup_tasks.company_id', getHostInfo()['id'])
            ->count();
            $lastTasks = \App\Models\HRIS\Setup\Task::leftJoin('hr_setup_task_assigns', 'hr_setup_task_assigns.task_id', '=', 'hr_setup_tasks.id')
            ->select('hr_setup_tasks.*')
            ->where('hr_setup_task_assigns.emp_id', '=', $userid)
            ->where('hr_setup_tasks.company_id', getHostInfo()['id'])
            ->latest()
            ->select('hr_setup_task_assigns.*', 'hr_setup_task_assigns.created_at as created_at')
            ->first();
            $totalNoti =  $notices + $meetings + $tasks + $trainings;
         @endphp
          <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0);">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">{{ $totalNoti }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">{{ $totalNoti }} Notifications</span>
          <div class="dropdown-divider"></div>
          @if ($trainings)
          <a href="{{ route('training_calling.index') }}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> {{ $trainings }} new training
            <span class="float-right text-muted text-sm">{{ \Carbon\Carbon::parse($lasttraining->training_created_at)->diffForHumans() }}</span>
          </a>
          @endif
          @if ($notices)
          <a href="{{ url('employee/resource_hub/announcement') }}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> {{ $notices }} new announcement
            <span class="float-right text-muted text-sm">{{ \Carbon\Carbon::parse($noticeLast->notice_created_at)->diffForHumans() }}</span>
          </a>
          @endif
          <div class="dropdown-divider"></div>
          @if ($meetings)
          <a href="{{ url('employee/resource_hub/empmeeting') }}" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> {{ $meetings }} new meeting calling
            <span class="float-right text-muted text-sm">{{ \Carbon\Carbon::parse($lastMeeting->meeting_created_at)->diffForHumans() }}</span>
          </a>
          @endif
          <div class="dropdown-divider"></div>
          @if ($tasks)
          <a href="{{ url('employee/resource_hub/emptask') }}" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> {{ $tasks }}new tasks
            <span class="float-right text-muted text-sm">{{ \Carbon\Carbon::parse($lastTasks->created_at)->diffForHumans() }}</span>
          </a>
          @endif
          <div class="dropdown-divider"></div>
          {{-- <a href="javascript:void(0);" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
        </div>
      </li>

         <!-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="javascript:void(0);" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="javascript:void(0);" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->

         <!-- Profile Dropdown Menu -->
         <li class="nav-item dropdown">
             @if (Sentinel::getUser())
                 <a class="nav-link" data-toggle="dropdown" href="javascript:void(0);">
                     <div class="media">
                        <style>
                                .profile-picturee {
                                    width: 40px;
                                    height: 40px;
                                    border-radius: 50%;
                                    object-fit: cover;
                                    border: 2px solid #fff;
                                    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
                                    transition: transform 0.3s;
                                    }
                        </style>
                          @if (Sentinel::getUser()->profile_image == null)
                                <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="User Image"
                                class="profile-picturee ">
                                @else
                                {{-- {{ asset('profiles/' . $user->profile_image) }} --}}
                                <img src="{{ asset('profiles/' . Sentinel::getUser()->profile_image) }}" alt="Profile Picture"  class="profile-picturee" id="profile-image">
                                @endif
                         <div class="media-body d-none d-lg-block">
                             <h3 class="dropdown-item-title pt-2">&nbsp;{{ Sentinel::getUser()->first_name . ' ' . Sentinel::getUser()->last_name }}</h3>
                         </div>
                     </div>
                 </a>
                 <div class="dropdown-menu dropdown-menu-xlg dropdown-menu-right" style="margin-top: 5px;">
                     <a href="javascript:void(0);" class="dropdown-item">
                         <div class="media">
                             @if (Sentinel::getUser()->profile_image == null)
                                <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="User Image"
                                class="profile-picturee">
                                @else
                                <img src="{{ asset('profiles/' . Sentinel::getUser()->profile_image) }}" alt="Profile Picture"  class="profile-picturee" id="profile-image">
                                @endif
                             <div class=" media-body">
                                 <h3 class="dropdown-item-title ">&nbsp;{{ Sentinel::getUser()->first_name . ' ' . Sentinel::getUser()->last_name }}</h3>
                                 <p>&nbsp;{{ Sentinel::getUser()->email }}<br>&nbsp;Login Time: {{ Sentinel::getUser()->last_login }}</p>
                             </div>
                         </div>
                     </a>
                     <div class="dropdown-divider"></div>
                     <div style="padding: 5px;">
                         <div class="float-left">
                             <a href="{{ url('/employee/profile') }}"
                                 class="btn btn-info">Profile</a>
                         </div>
                         <div class="float-right">
                             <a href="{{ url('logout') }}" class="btn btn-warning">Log Out</a>
                         </div>
                     </div>
                 </div>
             @endif
         </li>
     </ul>
 </nav>

<script>
    var audioContextInitialized = false;

    function initializeAudioContext() {
        // Create an AudioContext only once when the user interacts with the page
        if (!audioContextInitialized) {
            audioContextInitialized = true;
            var audioContext = new (window.AudioContext || window.webkitAudioContext)();
            var audio = document.getElementById('notificationSound');
            var source = audioContext.createMediaElementSource(audio);
            source.connect(audioContext.destination);
            audio.play();
        }
    }

    // Check notification count on page load
    window.onload = function () {
        var notificationCount = {{ $totalNoti }};
        if (notificationCount > 0) {
            // Initialize the AudioContext and play the audio when there are notifications
            initializeAudioContext();
        }
    };
</script>
