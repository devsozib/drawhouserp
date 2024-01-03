@extends('lakeshore_bakery.layouts.master')
@section('content')

<div class="ps-page--contact">
    <div class="ps-hero bg--cover" data-background="{{ asset('lakeshore_bakery') }}/frontend/assets/img/hero/shop-hero.png">
      <div class="ps-hero__container">
        <h1 class="ps-hero__heading">Our Pick Up Point</h1>
      </div>
    </div>
    <div class="ps-section ps-contact" style=' padding-bottom:0px !important;'>
      <div class="container">
        <div class="ps-section__header" style="padding: 20px !important;">
          <h3 style="font-size: 24px;">
            House No 46, Road No 41
            <!-- <br> -->
            Gulshan 2, Dhaka
          </h3>
        </div>
        <div class="ps-section__content text-center" style="padding-bottom: 20px;">
          <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
              <figure>
                <figcaption>Call us</figcaption>
                <p>+88 01313 414 436</p>
                <!-- <p>Brand: (032) 3454 342 222</p> -->
              </figure>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 ">
              <figure>
                <figcaption>Email</figcaption>
                <p>info@lakeshorebakery.com</p>
              </figure>
            </div>
          </div>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.79796047727!2d90.41015331543194!3d23.790207893170212!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c70a77eb7db5%3A0x2a9f827155d6cbb6!2sLakeshore%20Hotel%20Gulshan!5e0!3m2!1sen!2sbd!4v1629293548477!5m2!1sen!2sbd" width="100vw" height="500vh" style="border:0;" allowfullscreen="" loading="lazy" ></iframe>
        <form class="ps-form--contact" action="#" method="post" style="margin-top:50px;">
          <div class="ps-form__header">
            <p>Contact</p>
            <h3>Get In touch with us</h3>
          </div>
          <div class="ps-form__content" >
            <div class="row">
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Your Name">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Your Email">
                </div>
              </div>
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 ">
                <div class="form-group">
                  <input class="form-control" type="text" placeholder="Phone">
                </div>
              </div>
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                <div class="form-group">
                  <textarea class="form-control" placeholder="Your message here" rows="3"></textarea>
                </div>
              </div>
            </div>
            <div class="ps-form__submit">
              <button class="ps-btn">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  @endsection