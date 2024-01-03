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
            <a href="{{ route('customer.profile') }}" class="nav-link active" id="v-pills-profile-tab"  aria-controls="v-pills-profile" aria-selected="true"> <i class="fa fa-angle-left"></i> Go Back </a>

          </div>
        </div>
        <div class="col-9">
          <div class="tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <div class="cart-items table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Prtoduct</th>
                            <th scope="col">Size</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Options</th>
                            <th scope="col">Addons</th>
                            <th scope="col">Sub Total</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $sizes = lib_size();
                                $products = lib_product();
                            @endphp
                            @foreach ($orderitems as $item)
                            
                                <tr>
                                    <td scope="row">{{ $products[$item->product_id] }}</td>
                                    <td>{{ $sizes[$item->product_size_id] }}</td>
                                    <td>{{ $item->product_quantity }}</td>
                                    <td>{{ getOptionsNameByIds($item->product_option_ids) }}</td>
                                    <td>{{ getAddonsNameByIds($item->product_addon_ids) }}</td>
                                    <td>{{ $item->product_total_price }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>

 @endsection
