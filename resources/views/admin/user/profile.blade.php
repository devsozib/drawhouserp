@extends('layout.app')
@section('title', 'Employee | Profile')
@section('content')
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }
    html {
    height: 100%;
    }

    body {
    min-height: 100%;
    background: #eee;
    font-family: 'Lato', sans-serif;
    font-weight: 400;
    color: #222;
    font-size: 14px;
    line-height: 26px;
    }


    .header {
    margin-bottom: 30px;

    .full-name {
        font-size: 40px;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .first-name {
        font-weight: 700;
    }

    .last-name {
        font-weight: 300;
    }

    .contact-info {
        margin-bottom: 20px;
    }

    .email ,
    .phone {
        color: #999;
        font-weight: 300;
    }

    .separator {
        height: 10px;
        display: inline-block;
        border-left: 2px solid #999;
        margin: 0px 10px;
    }

    .position {
        font-weight: bold;
        display: inline-block;
        margin-right: 10px;
        text-decoration: underline;
    }
    }


    .details {
    line-height: 20px;

    .section {
        margin-bottom: 40px;
    }

    .section:last-of-type {
        margin-bottom: 0px;
    }

    .section__title {
        letter-spacing: 2px;
        color: #54AFE4;
        font-weight: bold;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .section__list-item {
        margin-bottom: 40px;
    }

    .section__list-item:last-of-type {
        margin-bottom: 0;
    }

    .left ,
    .right {
        vertical-align: top;
        display: inline-block;
    }

    .left {
        width: 60%;
    }

    .right {
        tex-align: right;
        width: 39%;
    }

    .name {
        font-weight: bold;
    }

    a {
        text-decoration: none;
        color: #000;
        font-style: italic;
    }

    a:hover {
        text-decoration: underline;
        color: #000;
    }

    .skills {

    }

    .skills__item {
        margin-bottom: 10px;
    }

    .skills__item .right {
        input {
        display: none;
        }

        label {
        display: inline-block;
        width: 20px;
        height: 20px;
        background: #C3DEF3;
        border-radius: 20px;
        margin-right: 3px;
        }

        input:checked + label {
        background: #79A9CE;
        }
    }
    }

    /* Custom styles */

        .profile-picture-container {
        position: relative;
        display: inline-block;
        }

        .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
        cursor: pointer;
        }

        .profile-picture-container:hover .profile-picture {
            transform: scale(1.05);
        }

        .camera-icon {
        height: 35px;
        width: 35px;
        position: absolute;
        bottom: 8px;
        right: 2px;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px;
        border-radius: 50%;
        cursor: pointer;
    }

    .clickable-image {
    cursor: pointer;
    max-width: 100%;
    max-height: 100%;
    }

    .image-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    align-items: center;
    justify-content: center;
    z-index: 999999;
    }

    .expanded-image {
    max-width: 90%;
    max-height: 90%;

    }

    .close {
    color: white;
    font-size: 30px;
    position: absolute;
    top: 20px;
    right: 30px;
    cursor: pointer;
    }

    @media (max-width: 768px) {
        & .full-name {
        font-size: 29px!important;
        text-transform: uppercase;
        margin-bottom: 5px;
    }
    }

    .duration {
    font-weight: 700;
    font-size: 15px;
    margin-bottom: 6px;
    }

</style>
@include('layout/datatable')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- <h1 class="m-0" style="text-align: left;">Employee Information</h1> --}}
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{!! url('employee/dashboard') !!}">Employee</a></li>
                    <li class="breadcrumb-item"><a href="javascript::void(0)">Profile</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<link href='https://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-body" style="overflow-x: scroll;">
                <div class="row">
                   <div class="col-md-8 m-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                </div>
                                <div>
                                </div>
                                <div>
                                    <a href="{{ route('edit.profile') }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i>Edit Profile</a>
                                </div>
                            </div>
                            <div class="header text-center">
                                <div class="container mt-5">
                                    <div class="profile-picture-container">
                                        @if ($user->profile_image == null)
                                            <img src="https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_960_720.png" alt="Profile Picture" class="profile-picture clickable-image" id="profile-imagee">
                                        @else
                                            <img src="{{ asset('profiles/' . $user->profile_image) }}" alt="Profile Picture" class="profile-picture clickable-image" id="profile-imagee">
                                        @endif
                                        <input type="file" id="new-profile-image" accept="image/*" style="display:none;">
                                        <label for="new-profile-image" class="camera-icon">
                                            <i class="fas fa-camera"></i>
                                        </label>
                                        <div class="image-overlay">
                                            <span class="close">&times;</span>
                                            <img src="{{ asset('profiles/' . $user->profile_image) }}" alt="Image" class="expanded-image">
                                        </div>
                                    </div>
                                </div>

                                <div class="full-name pt-2">
                                    <span class="first-name">{{ Str::upper($user->first_name) }}</span>
                                    <span class="last-name">{{ Str::upper($user->last_name) }}</span>
                                </div>
                                <div class="contact-info">
                                    <span class="email">Email: </span>
                                    <span class="email-val">{{ $user->email }}</span>
                                    <span class="separator"></span>
                                    <span class="phone">Phone: </span>
                                    @if ( $personal)
                                    <span class="phone-val">{{ $personal->MobileNo }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                      </div>
                            <div class="section__title" style="letter-spacing: 2px;
                            color: #54AFE4;
                            font-weight: bold;
                            margin-bottom: 10px;
                            text-transform: uppercase;">Personal Details</div>
                            <div class="details">
                                <div class="section">
                                    <div class="section__list">
                                        <div class="section__list-item">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @if ($user->Father !=null)
                                                        <div class="duration">Father: {{ $user->Father }}</div>
                                                        @endif
                                                        @if ($user->Mother)
                                                        <div class="duration">Mother: {{ $user->Mother }}</div>
                                                        @endif
                                                        @if ($user->Spouse)
                                                        <div class="duration">Spouse: {{ $user->Spouse }}</div>
                                                        @endif
                                                        @if ( $user->JoiningDate)
                                                        <div class="duration">JoiningDate: {{ \Carbon\Carbon::parse($user->JoiningDate)->format('F j, Y') }}</div>
                                                        @endif
                                                        @if ($user->ConfirmationDate)
                                                        <div class="duration">ConfirmationDate: {{ \Carbon\Carbon::parse($user->ConfirmationDate)->format('F j, Y') }}</div>
                                                        @endif
                                                        @if ($personal)
                                                            @if ($personal->NationalIDNo !=null)
                                                            <div class="duration">NationalIDNo: {{ $personal->NationalIDNo }}</div>
                                                            @endif
                                                            @if ($personal->Nominee !=null)
                                                            <div class="duration">Nominee: {{ $personal->Nominee }}</div>
                                                            @endif
                                                            @if ($personal->Relation !=null)
                                                            <div class="duration">Relation: {{ $personal->Relation }}</div>
                                                            @endif
                                                            @if ($personal->BirthDate !=null)
                                                            <div class="duration">BirthDate: {{ \Carbon\Carbon::parse($personal->BirthDate)->format('F j, Y') }} </div>
                                                            @endif
                                                            @if ($personal->MaritalStatusID !=null)
                                                            <div class="duration">MaritalStatus: {{ $personal->MaritalStatusID == 'M' ? 'Married' : ($personal->MaritalStatusID == 'U' ? 'Unmarried' : ($personal->MaritalStatusID == 'S' ? 'Separated' : ($personal->MaritalStatusID == 'D' ? 'Divorcee' : ($personal->MaritalStatusID == 'W' ? 'Widow' : ($personal->MaritalStatusID == 'R' ? 'Widower' : 'Unknown'))))) }}</div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6 m-auto">
                                                        @if ($personal)
                                                            @if ($personal->SexCode !=null)
                                                            <div class="duration">SexCode: {{ $personal->SexCode }}</div>
                                                            @endif
                                                            @if ($personal->Height !=null)
                                                            <div class="duration">Height: {{ $personal->Height }}</div>
                                                            @endif
                                                            @if ($personal->Weight !=null)
                                                            <div class="duration">Weight: {{ $personal->Weight }}</div>
                                                            @endif
                                                            @if ($personal->BloodGroup !=null)
                                                            <div class="duration">BloodGroup: {{ $personal->BloodGroup }}</div>
                                                            @endif
                                                            @if ($personal->ReligionID !=null)
                                                            <div class="duration">Religion:  {{ $personal->ReligionID == 'M' ? 'Muslims' : ($personal->ReligionID == 'H' ? 'Hindu' : ($personal->ReligionID == 'C' ? 'Christian' : ($personal->ReligionID == 'B' ? 'Buddhist' : ($personal->ReligionID == 'J' ? 'Jewish' : 'Unknown')))) }}</div>
                                                            @endif
                                                            @if ($personal->NationalityID !=null)
                                                            <div class="duration">Nationality: {{ $personal->NationalityID == 'B' ? 'Bangladeshi' : 'Non-Bangladeshi' }}</div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            {{-- <div class="right">
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>

                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration"></div>
                                                <div class="duration">

                                                </div>
                                                <div class="duration">

                                                </div>
                                                <div class="desc">

                                                </div>

                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="section">
                                    <div class="section__title">Present Address</div>
                                    <div class="section__list">
                                        <div class="section__list-item">
                                            <div class="left">
                                                <div class="duration">District:</div>
                                                <div class="duration">Thana:</div>
                                                <div class="addr">Post Office:</div>
                                                <div class="duration">Local Area:</div>
                                            </div>
                                            <div class="right">
                                                <div class="duration">{{ $user->prsntDis }}</div>
                                                <div class="duration">{{ $user->prnsThana }}</div>
                                                <div class="duration">{{ $user->MPOffice }}</div>
                                                <div class="duration">{{ $user->MVillage }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="section">
                                    <div class="section__title">Parmanent Address</div>
                                    <div class="section__list">
                                        <div class="section__list-item">
                                            <div class="left">
                                                <div class="duration">District:</div>
                                                <div class="duration">Thana:</div>
                                                <div class="addr">Post Office:</div>
                                                <div class="duration">Local Area:</div>
                                            </div>
                                            <div class="right">
                                                <div class="duration">{{ $user->parDis }}</div>
                                                <div class="duration">{{ $user->parThana }}</div>
                                                <div class="duration">{{ $user->PPOffice }}</div>
                                                <div class="duration">{{ $user->PVillage }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="section">
                                    <div class="section__title">Education</div>
                                    <div class="section__list">
                                        @foreach ($educations as $item)
                                            <div class="section__list-item">
                                                <div class="left">
                                                    <div class="name">Institute:</div>
                                                    <div class="name">InstituteB:</div>
                                                    <div class="addr">ClassObtained:</div>
                                                    <div class="duration">ResultType:</div>
                                                    <div class="duration">Passing Year:</div>
                                                    <div class="duration">Board:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="name">{{ $item->Institute }}</div>
                                                    <div class="name">{{ $item->InstituteB }}</div>
                                                    <div class="desc">
                                                        {{ $item->ResultType == 'D' ? 'Devision' : ($item->ResultType == 'G' ? 'GRADE' : 'C') }}
                                                    </div>
                                                    <div class="desc">{{ $item->ClassObtained }}</div>
                                                    <div class="year">{{ $item->year }}</div>
                                                    <div class="year">{{ $item->Name }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="section">
                                    <div class="section__title">Experience</div>
                                    <div class="section__list">
                                        @foreach ($experiences as $item)
                                            <div class="section__list-item">
                                                <div class="left">
                                                    <div class="name">Organization:</div>
                                                    <div class="addr">Designation:</div>
                                                    <div class="duration">Duration:</div>
                                                    <div class="duration">Description:</div>
                                                </div>
                                                <div class="right">
                                                    <div class="name">{{ $item->Organization }}</div>
                                                    <div class="desc">{{ $item->Designation }}</div>
                                                    <div class="desc">{{ $item->Duration }}</div>
                                                    <div class="desc">{{ $item->Description }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if ($trainings)
                                    <div class="section">
                                        <div class="section__title">Training</div>
                                        <div class="section__list">
                                            @foreach ($trainings as $item)
                                                <div class="section__list-item">
                                                    <div class="left">
                                                        <div class="name">Training Name:</div>
                                                        <div class="addr">Instructor:</div>
                                                        <div class="duration">Duration:</div>
                                                        <div class="duration">Grade:</div>
                                                    </div>
                                                    <div class="right">
                                                        <div class="name">Training Name here</div>
                                                        <div class="desc">{{ $item->Instructor }}</div>
                                                        <div class="desc">{{ $item->Duration }}</div>
                                                        <div class="desc">{{ $item->Grade }}</div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                {{-- <div class="section">
                                    <div class="section__title">Reference</div>
                                    <div class="section__list">
                                        @foreach ($trainings as $item)
                                        <div class="section__list-item">
                                            <div class="left">
                                                <div class="name">Name:</div>
                                                <div class="addr">Occupation:</div>
                                                <div class="addr">Organization:</div>
                                                <div class="addr">Org Address:</div>
                                                <div class="addr">Phone:</div>
                                                <div class="addr">Email:</div>
                                                <div class="addr">Relation:</div>
                                            </div>
                                            <div class="right">
                                                <div class="name">{{ $item->r_name }}</div>
                                                <div class="desc">{{ $item->r_occupation }}</div>
                                                <div class="desc">{{ $item->r_organization }}</div>
                                                <div class="desc">{{ $item->r_org_add }}</div>
                                                <div class="desc">{{ $item->r_phone }}</div>
                                                <div class="desc">{{ $item->r_email }}</div>
                                                <div class="desc">{{ $item->r_relation	 }}</div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                   </div>
                </div>
                <div class="row">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content profile-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel"
                                        aria-labelledby="home-tab" tabindex="0">

                                        <div class="container">


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            const profileImage = $("#profile-imagee");
            const newProfileImageInput = $("#new-profile-image");
    
            newProfileImageInput.change(function(event) {
                const newImageFile = event.target.files[0];
    
                if (newImageFile) {
                    // Check file type (allow only image files)
                    if (!/^image\/(jpeg|png|gif)$/i.test(newImageFile.type)) {
                        alert('Please select a valid image file (JPEG, PNG, GIF).');
                        // Clear the file input
                        newProfileImageInput.val('');
                        return;
                    }
    
                    // Check file size (2MB maximum)
                    if (newImageFile.size > 2 * 1024 * 1024) {
                        alert('File size exceeds the maximum limit of 2 MB.');
                        // Clear the file input
                        newProfileImageInput.val('');
                        return;
                    }
    
                    const formData = new FormData();
                    formData.append("profileImage", newImageFile);
    
                    $.ajax({
                        url: "upload-profile-image/",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                profileImage.attr("src", data.newImageUrl);
                            } else {
                                console.error("Image upload failed.");
                            }
                        },
                        error: function(error) {
                            console.error("An error occurred:", error);
                        }
                    });
                }
            });
        });
    
        const clickableImage = document.querySelector(".clickable-image");
        const imageOverlay = document.querySelector(".image-overlay");
        const expandedImage = document.querySelector(".expanded-image");
        const closeModalButton = document.querySelector(".close");
    
        clickableImage.addEventListener("click", () => {
            imageOverlay.style.display = "flex";
            expandedImage.src = clickableImage.src;
        });
    
        closeModalButton.addEventListener("click", () => {
            imageOverlay.style.display = "none";
        });
    
        window.addEventListener("click", (event) => {
            if (event.target === imageOverlay) {
                imageOverlay.style.display = "none";
            }
        });
    </script>
@stop
