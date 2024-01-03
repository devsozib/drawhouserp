<div class="cart-items table-responsive">
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
    </style>
    <main>
        <div class="box-flex ai-center jc-center mb-md">
            <div class="box-flex account-block ai-center pl-sm pr-sm sm:pt-sm pt-lg" data-testid="contact-form">
              <div class="box-flex w-100 ai-center fd-column">
                <div class="box-flex as-end p-relative t-md pl-sm">
                  <!-- Add the Edit Profile button here -->
                  <button class="edit-profile-button">Edit Profile</button>
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