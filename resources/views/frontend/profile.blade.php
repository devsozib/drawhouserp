@extends('frontend.layouts.master') @section('content')
<style>
    .edit-profile-button {
        background-color: #FFA259; /* Blue background color */
        color: #000000; /* White text color */
        padding: 7px 10px; /* Padding around the button text */
        border: none; /* Remove border */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Cursor on hover */
        font-size: 16px; /* Font size */
        transition: background-color 0.3s ease; /* Smooth background color transition on hover */
        }

        /* Style for the Edit Profile button on hover */
        .edit-profile-button:hover {
        background-color: #b28929;
        color: #fffdfd; /* Darker blue on hover */
        }

        /* Optional: Add margin or positioning to align the button as needed */
        .edit-profile-button {
        margin-top: 10px; /* Add margin to adjust vertical position */
        float: right; /* Float the button to the right */
        }
        .mod-address-book .mod-address-book-card-box {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
            padding: 20px;
        }
        .mod-address-book .mod-address-book-card-bigger {
            width: 422px;
        }
        .mod-address-book .mod-address-book-card {
            width: 360px;
            font-size: 12px;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            padding: 20px;
            line-height: 16px;
            margin-bottom: 20px;
            cursor: pointer;
        }
        .mod-address-book .mod-address-book-card-name {
            font-weight: 500;
            position: relative;
            margin-bottom: 8px;
        }
        .mod-address-book .mod-address-book-card-phone, .mod-address-book .mod-address-book-card-time {
            margin-bottom: 8px;
        }
        .mod-address-book .mod-address-book-card-address {
            margin-bottom: 20px;
        }
        .mod-address-book .mod-address-book-card-tags {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }
        .mod-address-book .mod-address-book-card-tag {
            padding: 2px 6px;
            line-height: 14px;
            background: rgba(0,119,135,.08);
            border-radius: 2px;
            margin-right: 8px;
            color: #007787;
        }
        .mod-address-book .next-btn-text.next-btn-medium {
            height: auto;
            word-break: keep-all;
        }
        .mod-address-book .mod-address-book-card-edit {
            font-size: 12px;
            font-weight: 400;
            color: #165fcf;
            cursor: pointer;
            position: absolute;
            right: 0;
            top: 0;
        }
        .next-btn-text.next-btn-medium {
            margin: 0;
            height: 20px;
            padding: 0;
            font-size: 14px;
            line-height: 20px;
            border-width: 0;
        }
        .next-btn-text.next-btn-primary, .next-btn-text.next-btn-primary.visited, .next-btn-text.next-btn-primary:link, .next-btn-text.next-btn-primary:visited {
            color: #1a9cb7;
        }
        .next-btn-text.next-btn-primary {
            background-color: transparent;
            border-color: transparent;
        }
        [type=reset], [type=submit], button, html [type=button] {
            -webkit-appearance: button;
        }
        .next-btn-text {
            box-shadow: none;
        }
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #FFA259;
        }
    </style>
    <style>
        .custom-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 300px;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        animation: slide-in 0.5s ease-in-out, fade-out 0.5s 2.5s ease-in-out forwards;
        }

        .alert-content {
            padding: 0px 15px;
            color: #fff;
            font-size: 11px;
        }

        .custom-toast.alert-success {
            background-color: #5cb85c;
        }

        /* Animation keyframes */
        @keyframes slide-in {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        @keyframes fade-out {
            from {
                opacity: 1;
            }
            to {
                opacity: 0;
            }
        }
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999999;
            display: none;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
        }
        .custom-control-label::before {
            border-radius: 0.25rem;
        }

        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #007bff; /* Change this to your desired color */
            border-color: #007bff; /* Change this to your desired color */
        }

        /* Flexbox layout for checkboxes */
        .checkbox-flex-group {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping to the next line if needed */
            gap: 10px; /* Adjust spacing between checkboxes */
        }
        .custom-control-label::before {
            border-radius: 0.25rem;
        }

        .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #007bff; /* Change this to your desired color */
            border-color: #007bff; /* Change this to your desired color */
        }

/* Apply custom design to checkboxes */
      .custom-checkbox .custom-control-label {
          color: #1a428a;
          padding-left: 0;
          margin-bottom: 0;
          margin-left: 2.5rem;
          display: block;
      }
    </style>
<!--Custom Banner-->
<div class="custom-banner leaf flower">
  <div class="container">
    <div class="row"></div>
  </div>
</div>
<!--/Custom Banner-->
<div class="container">

    <div class="row py-5">
        <div class="col-3">
          <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <button class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" data-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</button>
            <button class="nav-link" id="v-pills-address-tab" data-toggle="pill" data-target="#v-pills-address" type="button" role="tab" aria-controls="v-pills-address" aria-selected="false">Address Book</button>
            <button class="nav-link" id="v-pills-order-tab" data-toggle="pill" data-target="#v-pills-order" type="button" role="tab" aria-controls="v-pills-order" aria-selected="false">Orders</button>
            <button class="nav-link" id="v-pills-vouchar-tab" data-toggle="pill" data-target="#v-pills-vouchar" type="button" role="tab" aria-controls="v-pills-vouchar" aria-selected="false">Vouchar</button>
            <button class="nav-link" id="v-pills-rewards-tab" data-toggle="pill" data-target="#v-pills-rewards" type="button" role="tab" aria-controls="v-pills-rewards" aria-selected="false">Rewards</button>
            <button class="nav-link" id="v-pills-favitems-tab" data-toggle="pill" data-target="#v-pills-favitems" type="button" role="tab" aria-controls="v-pills-favitems" aria-selected="false">Favourite Items</button>
            <button class="nav-link" id="v-pills-pokebowl-tab" data-toggle="pill" data-target="#v-pills-pokebowl" type="button" role="tab" aria-controls="v-pills-pokebowl" aria-selected="false">My Poke Bowl</button>
            <button class="nav-link" id="v-pills-settings-tab" data-toggle="pill" data-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Help Center</button>
            <button class="nav-link" ><a href="{{ route('customer.logout') }}">Logout</a></button>
          </div>
        </div>
        <div class="col-9">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"><div class="cart-items table-responsive">
                <main>
                    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'update')
                        @include('layout/flash-message')
                    @endif
                    @if(session('success'))
                    <div class="custom-toast alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-content">
                            {{ session('success') }}
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if(session('psuccess'))
                    <div class="custom-toast alert alert-success alert-dismissible fade show" role="alert">
                        <div class="alert-content">
                            {{ session('psuccess') }}
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="box-flex ai-center jc-center mb-md">
                        <div class="box-flex account-block ai-center pl-sm pr-sm sm:pt-sm pt-lg" data-testid="contact-form">
                          <div class="box-flex w-100 ai-center fd-column">
                            <div class="box-flex as-end p-relative t-md pl-sm">
                              <!-- Add the Edit Profile button here -->
                              <button class="edit-profile-button" data-toggle="modal" data-target="#edit-modal">Edit Profile</button>
                              <!-- Modal -->
                                <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('cedit.profile') }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="Name">Full Name</label>
                                                            <input type="text" placeholder="Name" name="name"
                                                                class="form-control" value="{{ Auth::guard('customer')->user()->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="Name">Phone</label>
                                                            <input type="text" placeholder="Phone" name="phone"
                                                                class="form-control" value="{{ Auth::guard('customer')->user()->phone }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="Name">Email</label>
                                                            <input type="email" placeholder="email" name="email"
                                                                class="form-control" value="{{ Auth::guard('customer')->user()->email }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Update</button>
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                            @if (!empty(Session::get('error_code')) && Session::get('error_code') == 'update')
                                            <script>
                                                $(function() {
                                                        $('#edit-modal').modal('show');
                                                    });
                                                </script>
                                            @endif
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="cl-black f-label-medium-font-size fw-label-medium-font-weight lh-label-medium-line-height sm:pb-sm pb-lg">MY PROFILE</div>
                          </div>
                          <hr class="divider">
                          <div class="input-box">
                            <label for="mobile-number" id="mobile-number-label">Full Name:</label>
                            <strong>{{ Auth::guard('customer')->user()->name }}</strong>
                          </div>
                          <div class="input-box">
                            <label for="mobile-number" id="mobile-number-label">Mobile number:</label>
                            <strong>{{ Auth::guard('customer')->user()->phone }}</strong>
                          </div>
                          <div class="input-box">
                            <label for="mobile-number" id="mobile-number-label">Email:</label>
                            <strong>{{ Auth::guard('customer')->user()->email }}</strong>
                          </div>
                        </div>
                      </div>
                    <hr class="divider">
                  </main>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-address" role="tabpanel" aria-labelledby="v-pills-address-tab"><div id="container" class="container">
                <div class="book" data-spm="address">
                  <div>
                    <div class="mod-address-book">
                        <div class="box-flex w-100 ai-center fd-column">
                            <div class="box-flex as-end p-relative t-md pl-sm">
                              <!-- Add the Edit Profile button here -->
                              <button class="edit-profile-button">Add Address</button>
                            </div>
                            <div class="cl-black f-label-medium-font-size fw-label-medium-font-weight lh-label-medium-line-height sm:pb-sm pb-lg">MY ADDRESS BOOK</div>
                          </div>
                          <hr class="divider">

                      <div class="mod-address-book-content">
                        <div class="mod-address-book-card-box">
                          <div class="mod-address-book-card mod-address-book-card-bigger">
                            <div class="mod-address-book-card-name" data-spm-anchor-id="a2a0e.address_book.address.i0.71222829PxWIKk">Farabi Sajib <button type="button" class="next-btn next-btn-text next-btn-primary next-btn-medium mod-address-book-card-edit">EDIT</button>
                            </div>
                            <div class="mod-address-book-card-phone">(+880) 1789651028</div>
                            <div class="mod-address-book-card-address">Barishal,Barishal - Agailjhara,Agailjhara Bazar,Jhenaidah,Khulna,Bangladesh</div>
                            <div class="mod-address-book-card-tags">
                              <small class="mod-address-book-card-tag">Home</small>
                              <small class="mod-address-book-card-tag-default">DEFAULT DELIVERY ADDRESS</small>
                              <small class="mod-address-book-card-tag-default">DEFAULT BILLING ADDRESS</small>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div data-spm="add_address"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="v-pills-order" role="tabpanel" aria-labelledby="v-pills-order-tab">
                <main>
                  <div class="box-flex order-history-box-wrapper" data-testid="active-orders-box-wrapper">
                    <div class="box-flex w-100 ai-center fd-column">
                      <div class="box-flex as-end p-relative t-md pl-sm">
                        <!-- Add the Edit Profile button here -->
                        <a class="edit-profile-button" href="{{ route('frontend') }}">New Order</a>
                      </div>
                      <div class="cl-black f-label-medium-font-size fw-label-medium-font-weight lh-label-medium-line-height sm:pb-sm pb-lg">Active orders</div>
                    </div>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Order ID</th>
                            <th scope="col">Date</th>
                            <th scope="col">Total Item</th>
                            <th scope="col">Total Bill</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td scope="row">#{{ $order->unique_order_id }}</td>
                                    <td>{{ $order->order_time }}</td>
                                    <td>{{ $order->total_items }}</td>
                                    <td>{{ $order->paid_amount }}</td>
                                    <td><a href="{{ route('customer.order.details', $order->unique_order_id) }}" class="btn btn-sm btn-info">Details</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                      @if(count($orders)==0)
                        <div class="feedback-noorder">You have no active orders.</div>
                      @endif
                  </div>
                  <hr class="divider">
                  <div class="box-flex order-history-box-wrapper" data-testid="active-orders-box-wrapper">
                    <div class="box-flex w-100 ai-center fd-column">
                      <div class="cl-black f-label-medium-font-size fw-label-medium-font-weight lh-label-medium-line-height sm:pb-sm pb-lg">Past orders</div>
                    </div>
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                          </tr>
                        </tbody>
                      </table>
                    <div class="feedback-noorder">You have no active orders.</div>
                  </div>
                </main>
              </div>
            <div class="tab-pane fade" id="v-pills-vouchar" role="tabpanel" aria-labelledby="v-pills-vouchar-tab">Voucher</div>
            <div class="tab-pane fade" id="v-pills-rewards" role="tabpanel" aria-labelledby="v-pills-rewards-tab">Rewards</div>
            <div class="tab-pane fade" id="v-pills-favitems" role="tabpanel" aria-labelledby="v-pills-favitems-tab">Fav items</div>
            <div class="tab-pane fade" id="v-pills-pokebowl" role="tabpanel" aria-labelledby="v-pills-pokebowl-tab">  <div class="book" data-spm="address">
                <div>
                  <div class="mod-address-book">
                      <div class="box-flex w-100 ai-center fd-column">
                          <div class="box-flex as-end p-relative t-md pl-sm">
                            <!-- Add the Edit Profile button here -->
                            @if ($data)
                             <button class="edit-profile-button" data-toggle="modal" data-target="#edit-pokebowl">Edit Your won Poke Bowl</button>
                             @else
                             <button class="edit-profile-button" data-toggle="modal" data-target="#make-pokebowl">Make Your won Poke Bowl</button>
                            @endif

                            <!-- Modal -->
                              <div class="modal fade" id="make-pokebowl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-dialog-centered modal-lg">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                      </div>
                                      <div class="modal-body">
                                        <form action="{{ route('make.pokebowl') }}" method="post">
                                            @csrf
                                            <div class="container">
                                              <div class="row">
                                                <h6 class="text-center">Make your own Poke Bowl</h6><br>
                                              </div>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <form id="pokeBuilderForm">
                                                            <div class="form-group">
                                                                <label for="base">Poke Bowl:</label>
                                                                <select class="form-control" onchange="handleOwnPokeBowlMake(this.value)" id="pokebowl" name="pokebowl">
                                                                    <option value="hangry-one">Hangry(900TK)<br>1 Protin</option>
                                                                    <option value="hangry-two">Hangry(1050TK)<br>2 Protin</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Choose your Base (Pick 1):</label>
                                                                <div class="checkbox-group" id="base-checkbox-group">
                                                                    <div class="checkbox-flex-group">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input base-checkbox" id="base-white-rice" name="base" value="White Rice">
                                                                            <label class="custom-control-label" for="base-white-rice">
                                                                                <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/4.png" alt="White Rice" class="checkbox-image">
                                                                                White Rice
                                                                            </label>
                                                                        </div>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input base-checkbox" id="base-brown-rice" name="base" value="Brown Rice">
                                                                            <label class="custom-control-label" for="base-brown-rice">
                                                                                <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/3.png" alt="Brown Rice" class="checkbox-image">
                                                                                Brown Rice
                                                                            </label>
                                                                        </div>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input base-checkbox" id="base-soba-noodles" name="base" value="Soba Noodles">
                                                                            <label class="custom-control-label" for="base-soba-noodles">
                                                                                <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/2.png" alt="Soba Noodles" class="checkbox-image">
                                                                                Soba Noodles
                                                                            </label>
                                                                        </div>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input base-checkbox" id="base-mixed-greens" name="base" value="Mixed Greens">
                                                                            <label class="custom-control-label" for="base-mixed-greens">
                                                                                <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/1.png" alt="Mixed Greens" class="checkbox-image">
                                                                                Mixed Greens
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          <div class="form-group">
                                                            <label for="protein">Choose your Protein:<br>Lil(Pick1) & Hangry(Pick2) & (Extra Protein +200TK)</label>
                                                            <div class="checkbox-group">
                                                                <div class="checkbox-flex-group">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="salmon" name="protein[]" value="Salmon">
                                                                        <label class="custom-control-label" for="salmon">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/10.png" alt="Salmon" class="checkbox-image">
                                                                            Salmon
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="crab-stick" name="protein[]" value="Crab Stick">
                                                                        <label class="custom-control-label" for="crab-stick">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/9.png" alt="Salmon" class="checkbox-image">
                                                                            Crab Stick
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="tuna" name="protein[]" value="Tuna">
                                                                        <label class="custom-control-label" for="tuna">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/8.png" alt="Salmon" class="checkbox-image">
                                                                            Tuna
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="tofu" name="protein[]" value="Tofu">
                                                                        <label class="custom-control-label" for="tofu">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/7.png" alt="Salmon" class="checkbox-image">
                                                                            Tofu
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="shrimp" name="protein[]" value="Shrimp">
                                                                        <label class="custom-control-label" for="shrimp">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/6.png" alt="Salmon" class="checkbox-image">
                                                                            Shrimp
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="scallops" name="protein[]" value="Scallops">
                                                                        <label class="custom-control-label" for="scallops">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/5.png" alt="Salmon" class="checkbox-image">
                                                                            Scallops
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                          <hr>
                                                          <!-- Choose Regular Toppings -->
                                                          <div class="form-group">
                                                            <h6>Choose your topping <br><span>(As many as you like)</span></h6>
                                                            <label for="regular-toppings">Regular Toppings:</label>
                                                            <div class="checkbox-group">
                                                                <div class="checkbox-flex-group">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="avocado" name="rtoppings[]" value="White Onion">
                                                                        <label class="custom-control-label" for="avocado">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/11.png" alt="White Onion" class="topping-image">
                                                                            White Onion
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="Edamame" name="rtoppings[]" value="Edamame">
                                                                        <label class="custom-control-label" for="Edamame">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/15.png" alt="Edamame" class="topping-image">
                                                                            Edamame
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="Cucumber" name="rtoppings[]" value="Cucumber">
                                                                        <label class="custom-control-label" for="Cucumber">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/14.png" alt="Cucumber" class="topping-image">
                                                                            Cucumber
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="Jalapeno" name="rtoppings[]" value="Jalapeno">
                                                                        <label class="custom-control-label" for="Jalapeno">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/13.png" alt="Jalapeno" class="topping-image">
                                                                            Jalapeno
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="CrispyGarlic" name="rtoppings[]" value="Crispy Garlic">
                                                                        <label class="custom-control-label" for="CrispyGarlic">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/12.png"  alt="Crispy Garlic" class="topping-image">
                                                                            Crispy Garlic
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="Pineapple" name="rtoppings[]" value="Pineapple">
                                                                        <label class="custom-control-label" for="Pineapple">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/20.png"  alt="Pineapple" class="topping-image">
                                                                            Pineapple
                                                                        </label>
                                                                    </div>
                                                                    <!-- Add images and labels for other regular toppings here -->
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="SweetGinger" name="rtoppings[]" value="Sweet Ginger">
                                                                        <label class="custom-control-label" for="SweetGinger">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/19.png" alt="Sweet Ginger" class="topping-image">
                                                                            Sweet Ginger
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="CrispyOnion" name="rtoppings[]" value="Crispy Onion">
                                                                        <label class="custom-control-label" for="CrispyOnion">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/18.png" alt="Crispy Onion" class="topping-image">
                                                                            Crispy Onion
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="Furikake" name="rtoppings[]" value="Furikake">
                                                                        <label class="custom-control-label" for="Furikake">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/17.png" alt="Furikake" class="topping-image">
                                                                            Furikake
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="Togarashi" name="rtoppings[]" value="Togarashi">
                                                                        <label class="custom-control-label" for="Togarashi">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/25.png" alt="Togarashi" class="topping-image">
                                                                            Togarashi
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="GreenOnion" name="rtoppings[]" value="Green Onion">
                                                                        <label class="custom-control-label" for="GreenOnion">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/24.png" alt="Green Onion" class="topping-image">
                                                                            Green Onion
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="TempuraCrumbs" name="rtoppings[]" value="Tempura Crumbs">
                                                                        <label class="custom-control-label" for="TempuraCrumbs">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/21.png" alt="Tempura Crumbs" class="topping-image">
                                                                            Tempura Crumbs
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="CashewNut" name="rtoppings[]" value="Cashew Nut">
                                                                        <label class="custom-control-label" for="CashewNut">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/23.png" alt="Cashew Nut" class="topping-image">
                                                                            Cashew Nut
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input" id="Peanuts" name="rtoppings[]" value="Peanuts">
                                                                        <label class="custom-control-label" for="Peanuts">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/22.png" alt="Peanuts" class="topping-image">
                                                                            Peanuts
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                          <!-- Choose Premium Toppings -->
                                                       <!-- Premium Toppings -->
                                                      <div class="form-group">
                                                        <label for="premium-toppings">Premium Toppings:</label>
                                                        <div class="checkbox-group">
                                                            <div class="checkbox-flex-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="premium-mango" name="ptoppings[]" value="Mango80">
                                                                    <label class="custom-control-label" for="premium-mango">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/26.png" alt="Mango">Mango (+80 TK)
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="premium-avocado2" name="ptoppings[]" value="Avocado80">
                                                                    <label class="custom-control-label" for="premium-avocado2">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/27.png" alt="Avocado"> Avocado (+80 TK)
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="premium-cherry-tomato" name="ptoppings[]" value="Cherry Tomato80">
                                                                    <label class="custom-control-label" for="premium-cherry-tomato">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/30.png" alt="Cherry Tomato"> Cherry Tomato (+80 TK)
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="premium-kimchi" name="ptoppings[]" value="Kimchi50">
                                                                    <label class="custom-control-label" for="premium-kimchi">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/29.png" alt="Kimchi"> Kimchi (+50 TK)
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="premium-mushroom" name="ptoppings[]" value="Mushroom80">
                                                                    <label class="custom-control-label" for="premium-mushroom">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/28.png" alt="Mushroom"> Mushroom (+80 TK)
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="premium-green-seaweed" name="ptoppings[]" value="Green Seaweed50">
                                                                    <label class="custom-control-label" for="premium-green-seaweed">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/32.png" alt="Green Seaweed"> Green Seaweed (+50 TK)
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="premium-masago" name="ptoppings[]" value="Masago80">
                                                                    <label class="custom-control-label" for="premium-masago">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/31.png" alt="Masago"> Masago (+80 TK)
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                      </div>
                                                          <hr>
                                                          <!-- Choose Flavours -->
                                                          <div class="form-group">
                                                            <label for="flavours">Choose your Flavour(Pick 2):</label>
                                                            <div class="checkbox-group">
                                                                <div class="checkbox-flex-group">
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input flavor-checkbox" id="Aloha Sesame Honey" name="flavours[]" value="Aloha Sesame Honey">
                                                                        <label class="custom-control-label" for="Aloha Sesame Honey">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/37.png" alt="Aloha Sesame Honey"> Aloha Sesame Honey
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input flavor-checkbox" id="Mayo-Sabi,Creamy Wasabi" name="flavours[]" value="Mayo-Sabi,Creamy Wasabi">
                                                                        <label class="custom-control-label" for="Mayo-Sabi,Creamy Wasabi">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/36.png" alt="Mayo-Sabi,Creamy Wasabi"> Mayo-Sabi,Creamy Wasabi
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input flavor-checkbox" id="Island creamy pineapple" name="flavours[]" value="Island creamy pineapple">
                                                                        <label class="custom-control-label" for="Island creamy pineapple">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/35.png" alt="Island creamy pineapple"> Island creamy pineapple
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input flavor-checkbox" id="Supaishi Sriracha Cayenne Aioli" name="flavours[]" value="Supaishi Sriracha Cayenne Aioli">
                                                                        <label class="custom-control-label" for="Supaishi Sriracha Cayenne Aioli">
                                                                        </label>
                                                                    </div>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox" class="custom-control-input flavor-checkbox" id="Yuzu Citrus Hot Pepper" name="flavours[]" value="Yuzu Citrus Hot Pepper">
                                                                        <label class="custom-control-label" for="Yuzu Citrus Hot Pepper">
                                                                            <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/33.png" alt="Yuzu Citrus Hot Pepper"> Yuzu Citrus Hot Pepper
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                      <button type="submit" class="btn btn-primary">Build My Poke Bowl</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    </div>
                                  </form>
                                  </div>
                                  </div>
                              </div>
                              <!-- edit modal -->
                              <div class="modal fade" id="edit-pokebowl" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                     @if ($data)
                                     <form action="{{ route('update.pokebowl',$data['id']) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="container">
                                          <div class="row">
                                            <h6 class="text-center">Edit your own Poke Bowl</h6><br>
                                          </div>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <form id="pokeBuilderForm">
                                                        <div class="form-group">
                                                            <label for="base">Poke Bowl:</label>
                                                            <select class="form-control" onchange="handleOwnPokeBowlMake(this.value)" id="pokebowl" name="pokebowl">
                                                                <option {{ $data['name'] =='hangry-one'?'selected':'' }} value="hangry-one">Hangry(900TK)<br>1 Protin</option>
                                                                <option {{ $data['name'] =='hangry-two'?'selected':'' }} value="hangry-two">Hangry(1050TK)<br>2 Protin</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                          <label>Choose your Base (Pick 1):</label>
                                                          <div class="checkbox-group" id="base-checkbox-group">
                                                              <div class="checkbox-flex-group">
                                                                  <div class="custom-control custom-checkbox">
                                                                      <input {{ $data['base'] == 'White Rice' ? 'checked' : '' }} type="checkbox" class="custom-control-input ubase-checkbox" id="base-white-rice" name="base" value="White Rice">
                                                                      <label class="custom-control-label" for="base-white-rice">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/4.png" alt="White Rice" class="checkbox-image">
                                                                          White Rice
                                                                      </label>
                                                                  </div>
                                                                  <div class="custom-control custom-checkbox">
                                                                      <input {{ $data['base'] == 'Brown Rice' ? 'checked' : '' }} type="checkbox" class="custom-control-input ubase-checkbox" id="base-brown-rice" name="base" value="Brown Rice">
                                                                      <label class="custom-control-label" for="base-brown-rice">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/3.png" alt="Brown Rice" class="checkbox-image">
                                                                          Brown Rice
                                                                      </label>
                                                                  </div>
                                                                  <div class="custom-control custom-checkbox">
                                                                      <input {{ $data['base'] == 'Soba Noodles' ? 'checked' : '' }} type="checkbox" class="custom-control-input ubase-checkbox" id="base-soba-noodles" name="base" value="Soba Noodles">
                                                                      <label class="custom-control-label" for="base-soba-noodles">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/2.png" alt="Soba Noodles" class="checkbox-image">
                                                                          Soba Noodles
                                                                      </label>
                                                                  </div>
                                                                  <div class="custom-control custom-checkbox">
                                                                      <input {{ $data['base'] == 'Mixed Greens' ? 'checked' : '' }} type="checkbox" class="custom-control-input ubase-checkbox" id="base-mixed-greens" name="base" value="Mixed Greens">
                                                                      <label class="custom-control-label" for="base-mixed-greens">
                                                                          <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/1.png" alt="Mixed Greens" class="checkbox-image">
                                                                          Mixed Greens
                                                                      </label>
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="protein">Choose your Protein:<br>Lil(Pick1) & Hangry(Pick2) & (Extra Protein +200TK)</label>
                                                        <div class="checkbox-group">
                                                            <div class="checkbox-flex-group">

                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Salmon',$data['protein'])?'checked':'' }} type="checkbox" class="custom-control-input" id="salmon" name="protein[]" value="Salmon">
                                                                    <label class="custom-control-label" for="salmon">
                                                                      <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/10.png" alt="Salmon" class="checkbox-image">
                                                                        Salmon
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                  <input {{ in_array('Crab Stick',$data['protein'])?'checked':'' }} type="checkbox" class="custom-control-input" id="crab-stick" name="protein[]" value="Crab Stick">
                                                                  <label class="custom-control-label" for="crab-stick">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/9.png" alt="Salmon" class="checkbox-image">
                                                                      Crab Stick
                                                                  </label>
                                                              </div>
                                                              <div class="custom-control custom-checkbox">
                                                                  <input {{ in_array('Tuna',$data['protein'])?'checked':'' }} type="checkbox" class="custom-control-input" id="tuna" name="protein[]" value="Tuna">
                                                                  <label class="custom-control-label" for="tuna">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/8.png" alt="Salmon" class="checkbox-image">
                                                                      Tuna
                                                                  </label>
                                                              </div>
                                                              <div class="custom-control custom-checkbox">
                                                                  <input {{ in_array('Tofu',$data['protein'])?'checked':'' }} type="checkbox" class="custom-control-input" id="tofu" name="protein[]" value="Tofu">
                                                                  <label class="custom-control-label" for="tofu">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/7.png" alt="Salmon" class="checkbox-image">
                                                                      Tofu
                                                                  </label>
                                                              </div>
                                                              <div class="custom-control custom-checkbox">
                                                                  <input {{ in_array('Shrimp',$data['protein'])?'checked':'' }} type="checkbox" class="custom-control-input" id="shrimp" name="protein[]" value="Shrimp">
                                                                  <label class="custom-control-label" for="shrimp">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/6.png" alt="Salmon" class="checkbox-image">
                                                                      Shrimp
                                                                  </label>
                                                              </div>
                                                              <div class="custom-control custom-checkbox">
                                                                  <input {{ in_array('Scallops',$data['protein'])?'checked':'' }} type="checkbox" class="custom-control-input" id="scallops" name="protein[]" value="Scallops">
                                                                  <label class="custom-control-label" for="scallops">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/5.png" alt="Salmon" class="checkbox-image">
                                                                      Scallops
                                                                  </label>
                                                              </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                      <hr>
                                                      <!-- Choose Regular Toppings -->
                                                      <div class="form-group">
                                                        <h6>Choose your topping <br><span>(As many as you like)</span></h6>
                                                        <label for="regular-toppings">Regular Toppings:</label>
                                                        <div class="checkbox-group">
                                                            <div class="checkbox-flex-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('White Onion',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="avocado" name="rtoppings[]" value="White Onion">
                                                                    <label class="custom-control-label" for="avocado">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/11.png" alt="White Onion" class="topping-image">
                                                                        White Onion
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Edamame',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="Edamame" name="rtoppings[]" value="Edamame">
                                                                    <label class="custom-control-label" for="Edamame">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/15.png" alt="Edamame" class="topping-image">
                                                                        Edamame
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Cucumber',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="Cucumber" name="rtoppings[]" value="Cucumber">
                                                                    <label class="custom-control-label" for="Cucumber">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/14.png" alt="Cucumber" class="topping-image">
                                                                        Cucumber
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input  {{ in_array('Jalapeno',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="Jalapeno" name="rtoppings[]" value="Jalapeno">
                                                                    <label class="custom-control-label" for="Jalapeno">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/13.png" alt="Jalapeno" class="topping-image">
                                                                        Jalapeno
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Crispy Garlic',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="CrispyGarlic" name="rtoppings[]" value="Crispy Garlic">
                                                                    <label class="custom-control-label" for="CrispyGarlic">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/12.png"  alt="Crispy Garlic" class="topping-image">
                                                                        Crispy Garlic
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Pineapple',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="Pineapple" name="rtoppings[]" value="Pineapple">
                                                                    <label class="custom-control-label" for="Pineapple">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/20.png"  alt="Pineapple" class="topping-image">
                                                                        Pineapple
                                                                    </label>
                                                                </div>
                                                                <!-- Add images and labels for other regular toppings here -->
                                                                <div class="custom-control custom-checkbox">
                                                                    <input  {{ in_array('Sweet Ginger',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="SweetGinger" name="rtoppings[]" value="Sweet Ginger">
                                                                    <label class="custom-control-label" for="SweetGinger">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/19.png" alt="Sweet Ginger" class="topping-image">
                                                                        Sweet Ginger
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Crispy Onion',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="CrispyOnion" name="rtoppings[]" value="Crispy Onion">
                                                                    <label class="custom-control-label" for="CrispyOnion">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/18.png" alt="Crispy Onion" class="topping-image">
                                                                        Crispy Onion
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Furikake',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="Furikake" name="rtoppings[]" value="Furikake">
                                                                    <label class="custom-control-label" for="Furikake">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/17.png" alt="Furikake" class="topping-image">
                                                                        Furikake
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Togarashi',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="Togarashi" name="rtoppings[]" value="Togarashi">
                                                                    <label class="custom-control-label" for="Togarashi">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/25.png" alt="Togarashi" class="topping-image">
                                                                        Togarashi
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input  {{ in_array('Green Onion',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="GreenOnion" name="rtoppings[]" value="Green Onion">
                                                                    <label class="custom-control-label" for="GreenOnion">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/24.png" alt="Green Onion" class="topping-image">
                                                                        Green Onion
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Tempura Crumbs',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="TempuraCrumbs" name="rtoppings[]" value="Tempura Crumbs">
                                                                    <label class="custom-control-label" for="TempuraCrumbs">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/21.png" alt="Tempura Crumbs" class="topping-image">
                                                                        Tempura Crumbs
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Cashew Nut',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="CashewNut" name="rtoppings[]" value="Cashew Nut">
                                                                    <label class="custom-control-label" for="CashewNut">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/23.png" alt="Cashew Nut" class="topping-image">
                                                                        Cashew Nut
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Peanuts',$data['rtoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="Peanuts" name="rtoppings[]" value="Peanuts">
                                                                    <label class="custom-control-label" for="Peanuts">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/22.png" alt="Peanuts" class="topping-image">
                                                                        Peanuts
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                      <!-- Choose Premium Toppings -->
                                                   <!-- Premium Toppings -->
                                                  <div class="form-group">
                                                    <label for="premium-toppings">Premium Toppings:</label>
                                                    <div class="checkbox-group">
                                                        <div class="checkbox-flex-group">
                                                            <div class="custom-control custom-checkbox">
                                                                <input {{ in_array('Mango80',$data['ptoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="premium-mango" name="ptoppings[]" value="Mango80">
                                                                <label class="custom-control-label" for="premium-mango">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/26.png" alt="Mango">Mango (+80 TK)
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input {{ in_array('Avocado80',$data['ptoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="premium-avocado2" name="ptoppings[]" value="Avocado80">
                                                                <label class="custom-control-label" for="premium-avocado2">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/27.png" alt="Avocado"> Avocado (+80 TK)
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input {{ in_array('Cherry Tomato80',$data['ptoppings'])?'checked':'' }}  type="checkbox" class="custom-control-input" id="premium-cherry-tomato" name="ptoppings[]" value="Cherry Tomato80">
                                                                <label class="custom-control-label" for="premium-cherry-tomato">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/30.png" alt="Cherry Tomato"> Cherry Tomato (+80 TK)
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input {{ in_array('Kimchi50',$data['ptoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="premium-kimchi" name="ptoppings[]" value="Kimchi50">
                                                                <label class="custom-control-label" for="premium-kimchi">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/29.png" alt="Kimchi"> Kimchi (+50 TK)
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input {{ in_array('Mushroom80',$data['ptoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="premium-mushroom" name="ptoppings[]" value="Mushroom80">
                                                                <label class="custom-control-label" for="premium-mushroom">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/28.png" alt="Mushroom"> Mushroom (+80 TK)
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input {{ in_array('Green Seaweed50',$data['ptoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="premium-green-seaweed" name="ptoppings[]" value="Green Seaweed50">
                                                                <label class="custom-control-label" for="premium-green-seaweed">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/32.png" alt="Green Seaweed"> Green Seaweed (+50 TK)
                                                                </label>
                                                            </div>
                                                            <div class="custom-control custom-checkbox">
                                                                <input {{ in_array('Masago80',$data['ptoppings'])?'checked':'' }} type="checkbox" class="custom-control-input" id="premium-masago" name="ptoppings[]" value="Masago80">
                                                                <label class="custom-control-label" for="premium-masago">
                                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/31.png" alt="Masago"> Masago (+80 TK)
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                                      <hr>
                                                      <!-- Choose Flavours -->
                                                      <div class="form-group">
                                                        <label for="flavours">Choose your Flavour(Pick 2):</label>
                                                        <div class="checkbox-group">
                                                            <div class="checkbox-flex-group">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Aloha Sesame Honey',$data['flavours'])?'checked':'' }} type="checkbox" class="custom-control-input uflavor-checkbox" id="Aloha Sesame Honey" name="flavours[]" value="Aloha Sesame Honey">
                                                                    <label class="custom-control-label" for="Aloha Sesame Honey">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/37.png" alt="Aloha Sesame Honey"> Aloha Sesame Honey
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Mayo-Sabi,Creamy Wasabi',$data['flavours'])?'checked':'' }} type="checkbox" class="custom-control-input uflavor-checkbox" id="Mayo-Sabi,Creamy Wasabi" name="flavours[]" value="Mayo-Sabi,Creamy Wasabi">
                                                                    <label class="custom-control-label" for="Mayo-Sabi,Creamy Wasabi">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/36.png" alt="Mayo-Sabi,Creamy Wasabi"> Mayo-Sabi,Creamy Wasabi
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Island creamy pineapple',$data['flavours'])?'checked':'' }} type="checkbox" class="custom-control-input uflavor-checkbox" id="Island creamy pineapple" name="flavours[]" value="Island creamy pineapple">
                                                                    <label class="custom-control-label" for="Island creamy pineapple">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/35.png" alt="Island creamy pineapple"> Island creamy pineapple
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Supaishi Sriracha Cayenne Aioli',$data['flavours'])?'checked':'' }} type="checkbox" class="custom-control-input uflavor-checkbox" id="Supaishi Sriracha Cayenne Aioli" name="flavours[]" value="Supaishi Sriracha Cayenne Aioli">
                                                                    <label class="custom-control-label" for="Supaishi Sriracha Cayenne Aioli">
                                                                    </label>
                                                                </div>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input {{ in_array('Yuzu Citrus Hot Pepper',$data['flavours'])?'checked':'' }} type="checkbox" class="custom-control-input uflavor-checkbox" id="Yuzu Citrus Hot Pepper" name="flavours[]" value="Yuzu Citrus Hot Pepper">
                                                                    <label class="custom-control-label" for="Yuzu Citrus Hot Pepper">
                                                                        <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/33.png" alt="Yuzu Citrus Hot Pepper"> Yuzu Citrus Hot Pepper
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-primary">Build My Poke Bowl</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                </div>
                              </form>
                                     @endif

                                </div>
                                </div>
                            </div>
                          </div>
                          <div class="cl-black f-label-medium-font-size fw-label-medium-font-weight lh-label-medium-line-height sm:pb-sm pb-lg">MY WON POKE BOWL</div>
                        </div>
                        <hr class="divider">
                        <div class="row">
                            @if ($data)
                            <div class="col-md-10">
                                <div class="form-group">
                                    <label for="base">Poke Bowl:</label>
                                    <p><strong>
                                        {!! $data['name'] == 'hangry-one' ? 'Hangry (900TK)<br>(1 Protein)' : 'Hangry (1050TK)<br>(2 Proteins)' !!}
                                    </strong></p>
                                </div>

                                <div class="form-group">
                                    <label>Base:</label>
                                    <div class="checkbox-group" id="base-checkbox-group">
                                        <div class="checkbox-flex-group">
                                            @php
                                                $pimg = "";
                                                if($data['base'] == 'White Rice'){
                                                    $pimg='4.png';
                                                }elseif ($data['base'] == 'Brown Rice') {
                                                    $pimg='3.png';
                                                }elseif ($data['base'] == ' Soba Noodles') {
                                                    $pimg='2.png';
                                                }else{
                                                    $pimg='1.png';
                                                }

                                            @endphp
                                            <div class="custom-control custom-checkbox">
                                                <label class="custom-control-labe" for="base-white-rice">
                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/{{  $pimg }}" alt="White Rice" class="checkbox-image">
                                                        {{ $data['base'] }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($data['protein'])
                                <div class="form-group">
                                    <label for="protein">Protein:</label>
                                    <div class="checkbox-group">
                                        <div class="checkbox-flex-group">
                                            @foreach ($data['protein'] as $pro)
                                                @php
                                                    $proImg = "";
                                                    if($pro == 'Salmon'){
                                                        $proImg='10.png';
                                                    }elseif ($pro == 'Crab Stick') {
                                                        $proImg='9.png';
                                                    }elseif ($pro == 'Tuna') {
                                                        $proImg='8.png';
                                                    }elseif ($pro == 'Tofu') {
                                                        $proImg='7.png';
                                                    }elseif ($pro == 'Shrimp') {
                                                        $proImg='6.png';
                                                    }elseif ($pro == 'Scallops') {
                                                        $proImg='5.png';
                                                    }else{
                                                        $proImg='5.png';
                                                    }
                                                @endphp
                                            <div class="custom-control custom-checkbox">
                                                <label class="custom-control-labe" for="salmon">
                                                  <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/{{ $proImg }}" alt="{{ $pro }}" class="checkbox-image">
                                                  {{   $pro }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif

                              <hr>
                              @if ($data['rtoppings'])
                              <div class="form-group">
                                <label for="regular-toppings">Regular Toppings:</label>
                                <div class="checkbox-group">
                                    <div class="checkbox-flex-group">
                                        @foreach ($data['rtoppings'] as $rtop)
                                        @php
                                            $rTopImg = "";
                                            if($rtop == 'White Onion'){
                                                $rTopImg='11.png';
                                            }elseif ($rtop == 'Edamame') {
                                                $rTopImg='15.png';
                                            }elseif ($rtop == 'Cucumber') {
                                                $rTopImg='14.png';
                                            }elseif ($rtop == 'Jalapeno') {
                                                $rTopImg='13.png';
                                            }elseif ($rtop == 'Crispy Garlic') {
                                                $rTopImg='12.png';
                                            }elseif ($rtop == 'Pineapple') {
                                                $rTopImg='20.png';
                                            }elseif ($rtop == 'Sweet Ginger') {
                                                $rTopImg='19.png';
                                            }elseif ($rtop == 'Crispy Onion') {
                                                $rTopImg='18.png';
                                            }elseif ($rtop == 'Furikake') {
                                                $rTopImg='17.png';
                                            }elseif ($rtop == 'Togarashi') {
                                                $rTopImg='25.png';
                                            }elseif ($rtop == 'Green Onion') {
                                                $rTopImg='24.png';
                                            }elseif ($rtop == 'Tempura Crumbs') {
                                                $rTopImg='21.png';
                                            }elseif ($rtop == 'Cashew Nut') {
                                                $rTopImg='23.png';
                                            }elseif ($rtop == 'Peanuts') {
                                                $rTopImg='22.png';
                                            }else{
                                                $rTopImg='22.png';
                                            }
                                        @endphp
                                        <div class="custom-control custom-checkbox">
                                            <label class="custom-control-labe" for="avocado">
                                                <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/{{ $rTopImg }}" alt="{{ $rtop }}" class="topping-image">
                                               {{ $rtop }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                </div>
                                @endif
                              <!-- Choose Premium Toppings -->
                           <!-- Premium Toppings -->
                            @if ($data['ptoppings'])
                                <div class="form-group">
                                    <label for="premium-toppings">Premium Toppings:</label>
                                    <div class="checkbox-group">
                                        <div class="checkbox-flex-group">
                                            @foreach ($data['ptoppings'] as $ptop)
                                            @php
                                                $pTopImg = "";
                                                if($ptop == 'Mango80'){
                                                    $pTopImg='26.png';
                                                }elseif ($ptop == 'Avocado80') {
                                                    $pTopImg='27.png';
                                                }elseif ($ptop == 'Cherry Tomato80') {
                                                    $pTopImg='30.png';
                                                }elseif ($ptop == 'Kimchi80') {
                                                    $pTopImg='29.png';
                                                }elseif ($ptop == 'Mushroom80') {
                                                    $pTopImg='28.png';
                                                }elseif ($ptop == 'Green Seaweed50') {
                                                    $pTopImg='32.png';
                                                }elseif ($ptop == 'Masago80') {
                                                    $pTopImg='31.png';
                                                }else{
                                                    $pTopImg='31.png';
                                                }
                                            @endphp
                                            <div class="custom-control custom-checkbox">
                                                <label class="custom-control-labe" for="premium-mango">
                                                    <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/{{ $pTopImg }}" alt="{{ $ptop }}"> {{ $ptop }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                              <hr>
                              <!-- Choose Flavours -->
                              @if ($data['flavours'])
                              <div class="form-group">
                                <label for="flavours">Flavour:</label>
                                <div class="checkbox-group">
                                    <div class="checkbox-flex-group">
                                        @foreach ($data['flavours'] as $flv)
                                        @php
                                            $fImg = "";
                                            if($flv == 'Aloha Sesame Honey'){
                                                $fImg='37.png';
                                            }elseif ($flv == 'Mayo-Sabi,Creamy Wasabi') {
                                                $fImg='36.png';
                                            }elseif ($flv == 'Island creamy pineapple') {
                                                $fImg='35.png';
                                            }elseif ($flv == 'Yuzu Citrus Hot Pepper') {
                                                $fImg='33.png';
                                            }else{
                                                $fImg='31.png';
                                            }
                                        @endphp
                                        <div class="custom-control custom-checkbox">
                                            <label class="custom-control-labe" for="Aloha Sesame Honey">
                                                <img style="width:30px" src="{{ asset('frontend') }}/assets/pbimg/{{ $fImg }}" alt="{{ $flv }}"> {{ $flv }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                              @endif

                            <hr>
                            <p>Total Price:<strong> {{ $data['total_price'] }}TK</strong></p>
                        </div>
                            @endif

                        </div>
                  </div>
                </div>
              </div></div>
          </div>
          </div>
        </div>
      </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Get all the checkboxes with the "base-checkbox" class
    const checkboxes = document.querySelectorAll(".base-checkbox");

    // Add a click event listener to each checkbox
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("click", function () {
            // Uncheck all other checkboxes when one is checked
            checkboxes.forEach(function (otherCheckbox) {
                if (otherCheckbox !== checkbox) {
                    otherCheckbox.checked = false;
                }
            });
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    // Get all the checkboxes with the "flavor-checkbox" class
    const checkboxes = document.querySelectorAll(".flavor-checkbox");

    // Add a click event listener to each checkbox
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener("click", function () {
            // Count the number of checked checkboxes
            const checkedCheckboxes = document.querySelectorAll(".flavor-checkbox:checked");

            // If more than 2 checkboxes are checked, uncheck the last one clicked
            if (checkedCheckboxes.length > 2) {
                checkbox.checked = false;
            }
        });
    });
});
</script>

 @endsection
