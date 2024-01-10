
@extends('layouts/app')
@section('page-content')

<section class="hero-wrap" id="home" style="background-image:url(site/images/xbg_1.jpg.pagespeed.ic.sc5qLQi6UW.jpg)">
<div class="overlay"></div>
<div class="container">
<div class="row no-gutters slider-text align-items-center">
<div class="col-lg-7">
<div class="text mt-5" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">

@if (session()->has('success'))
    <span class="subheading" style="background-color:yellow;padding:5px; color:black">Félicitation!, enregistrement reussi  ,nous allons vous contacter pour la suite.</span> <br>
@endif

<span class="subheading">AIEBU</span>
<h2 class="mb-10">ALL IN EVENTS BURUNDI <br>
<span class="typewrite" data-period="2000" data-type='[ "Pour votre Formation", "Pour votre encouragement", "Pour votre education"]'>
<span class="wrap"></span>
</span>
</h2>
<div class="w-md-75 w-100">
<p class="mb-4">ALL IN ENVENTS BURUNDI en collaboration avec IMPACT-JOB organise des sessions de mentorat  (Mentorship program) et d'insertion professionnelle après la formation dans un domaine choisie .</p>

<p>
  <!--  <a href="#" class="btn btn-primary p-4 py-3">Hire Me <span class="ion-ios-arrow-round-forward"></span></a> 
    <a href="#" class="btn btn-white p-4 py-3 ms-lg-2">Enregistrez-vous maintenant <span class="ion-ios-arrow-round-forward"></span></a></p>
<p class="social-media mt-5"><a href="#"><span class="ion-ios-add"></span> Facebook</a> <a href="#"><span class="ion-ios-add"></span> Twitter</a> <a href="#"><span class="ion-ios-add"></span> Linkedin</a></p> -->
</div>
</div>
</div>
</div>
</div>
</section>


            <section class="ftco-section" id="about">
            <div class="container-xl">
            <div class="row g-xl-5">
            <div class="col-md-6 d-flex align-items-center" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <div class="img img-about" style="background-image:url(site/images/xabout.jpg.pagespeed.ic.3XzwTlBUg1.jpg)">
            </div>
            </div>
            <div class="col-md-6 heading-section" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
            <div class="my-5">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
            <a class="nav-link active" id="aboutme-tab" data-bs-toggle="tab" href="#aboutme" role="tab" aria-controls="aboutme" aria-selected="true">Competence</a>
            </li>
          <!--  <li class="nav-item" role="presentation">
            <a class="nav-link" id="skills-tab" data-bs-toggle="tab" href="#skills" role="tab" aria-controls="skills" aria-selected="false">Skills</a>
            </li>
            <li class="nav-item" role="presentation">
            <a class="nav-link" id="experience-tab" data-bs-toggle="tab" href="#experience" role="tab" aria-controls="experience" aria-selected="false">Experience</a>
            </li> -->
            </ul>
            <div class="tab-content py-4" id="myTabContent">
            <div class="tab-pane fade show active" id="aboutme" role="tabpanel" aria-labelledby="aboutme-tab">
           
            <h3 class="mb-4">Les Competence à développer selon ton choix sont :</h3>
            <p> 
                <li>Anglais </li>
                <li>Français </li>
                <li>Swahili </li>
                <li>Public speaking </li>
                <li>Time management </li>
                <li>Entrepreneuriat </li>
                <li>Ventes et Marketing </li>
                <li>Education Financière</li>
                <li>Hôtellerie et tourisme </li>
                <li>Informatique de base </li>
                <li>Ets ...</li>
        </p>
            </div>

            <!--
    <div class="tab-pane fade" id="skills" role="tabpanel" aria-labelledby="skills-tab">
            <h2 class="mb-4">Skills</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <div class="row mt-5">
            <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="progress-wrap">
            <h3>Adobe Photoshop</h3>
            <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:80%">
            <span>80%</span>
            </div>
            </div>
            </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="progress-wrap">
            <h3>HTML / CSS</h3>
            <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100" style="width:95%">
            <span>95%</span>
            </div>
            </div>
            </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="progress-wrap">
            <h3>Javascript</h3>
            <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width:88%">
            <span>88%</span>
            </div>
            </div>
            </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="progress-wrap">
            <h3>WordPress</h3>
            <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width:89%">
            <span>89%</span>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            <div class="tab-pane fade" id="experience" role="tabpanel" aria-labelledby="experience-tab">
            <div class="row">
            <div class="col-md-12">
            <div class="resume-wrap d-flex align-item-stretch" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
            <div class="w-100">
            <h2>Art &amp; Creative Director</h2>
            <span class="date">2014-2015</span> <span class="position"><i class="ion-ios-pin me-2"></i>Google Inc.</span>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            <div class="resume-wrap d-flex align-item-stretch" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500">
            <div class="w-100">
            <h2>Wordpress Developer</h2>
            <span class="date">2015-2017</span> <span class="position"><i class="ion-ios-pin me-2"></i>Google Inc.</span>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            <div class="resume-wrap d-flex align-item-stretch" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
            <div class="w-100">
            <h2>UI/UX Designer</h2>
            <span class="date">2018-2020</span> <span class="position"><i class="ion-ios-pin me-2"></i>Google Inc.</span>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </section>
            <section class="ftco-section" id="services">
            <div class="container-xl">
            <div class="row justify-content-center">
            <div class="col-md-7 heading-section text-center mb-5" data-aos="fade-up" data-aos-duration="1000">
            <span class="subheading">Services</span>
            <h2 class="mb-4">This is My Expertise, The Services I'll Provide My Clients</h2>
            </div>
            </div>
            <div class="row justify-content-center">
            <div class="col-md-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <div class="services-2">
            <div class="icon"><span class="flaticon-code"></span></div>
            <div class="text">
            <h2>UI &amp; UX Design</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            <p><a href="#" class="">Read more <span class="fa fa-long-arrow-right"></span></a></p>
            </div>
            </div>
            </div>
            <div class="col-md-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <div class="services-2">
            <div class="icon"><span class="flaticon-web-programming"></span></div>
            <div class="text">
            <h2>Web Development</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            <p><a href="#" class="">Read more <span class="fa fa-long-arrow-right"></span></a></p>
            </div>
            </div>
            </div>
            <div class="col-md-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <div class="services-2">
            <div class="icon"><span class="flaticon-vector"></span></div>
            <div class="text">
            <h2>Graphic Design</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            <p><a href="#" class="">Read more <span class="fa fa-long-arrow-right"></span></a></p>
            </div>
            </div>
            </div>
            </div>
            <div class="row mt-5 justify-content-center">
            <div class="col-md-8">
            <p><strong>Have any works you want to done by me? <a href="#">Contact Me</a></strong></p>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            </div>
            </div>
            </section>
            <section class="ftco-section-counter img" style="background-image:url(images/xbg_3.jpg.pagespeed.ic.z_ltqRZXRc.jpg)">
            <div class="overlay"></div>
            <div class="container">
            <div class="row section-counter">
            <div class="col-sm-6 col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="counter-wrap-2 d-flex" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <div class="icon">
            <span class="flaticon-customer-review"></span>
            </div>
            <div class="text">
            <h2 class="number"><span class="countup">3000</span></h2>
            <span class="caption">Happy Customer</span>
            </div>
            </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="counter-wrap-2 d-flex" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
            <div class="icon">
            <span class="flaticon-complete"></span>
            </div>
            <div class="text">
            <h2 class="number"><span class="countup">320</span></h2>
            <span class="caption">Project Completed</span>
            </div>
            </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-4 d-flex align-items-stretch">
            <div class="counter-wrap-2 d-flex" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
            <div class="icon">
            <span class="flaticon-coffee"></span>
            </div>
            <div class="text">
            <h2 class="number"><span class="countup">1000</span></h2>
            <span class="caption">Cups of Coffee</span>
            </div>
            </div>
            </div>
            </div>
            </div>
            </section>
            <section class="ftco-section ftco-project" id="portfolio">
            <div class="container">
            <div class="row justify-content-center mb-5">
            <div class="col-md-7 heading-section text-center" data-aos="fade-up" data-aos-duration="1000">
            <span class="subheading">Portfolio</span>
            <h2>My Latest Work</h2>
            </div>
            </div>
            <div class="row">
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="100" data-aos-duration="1000">
            <div class="project img ftco-animate d-flex justify-content-center align-items-center" style="background-image:url(images/xproject-1.jpg.pagespeed.ic.qy3tUEpwWq.jpg)">
            <div class="overlay"></div>
            <div class="text text-center p-4">
            <h3><a href="#">Branding &amp; Illustration Design</a></h3>
            <span>Web Design</span>
            </div>
            </div>
            </div>
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="100" data-aos-duration="1000">
            <div class="project img ftco-animate d-flex justify-content-center align-items-center" style="background-image:url(images/xproject-2.jpg.pagespeed.ic.S7VN-qnm5z.jpg)">
            <div class="overlay"></div>
            <div class="text text-center p-4">
            <h3><a href="#">Branding &amp; Illustration Design</a></h3>
            <span>Web Design</span>
            </div>
            </div>
            </div>
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="100" data-aos-duration="1000">
            <div class="project img ftco-animate d-flex justify-content-center align-items-center" style="background-image:url(images/xproject-3.jpg.pagespeed.ic.F_zwiH0stO.jpg)">
            <div class="overlay"></div>
            <div class="text text-center p-4">
            <h3><a href="#">Branding &amp; Illustration Design</a></h3>
            <span>Web Design</span>
            </div>
            </div>
            </div>
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="100" data-aos-duration="1000">
            <div class="project img ftco-animate d-flex justify-content-center align-items-center" style="background-image:url(images/xproject-4.jpg.pagespeed.ic.GscbfoNHvq.jpg)">
            <div class="overlay"></div>
            <div class="text text-center p-4">
            <h3><a href="#">Branding &amp; Illustration Design</a></h3>
            <span>Web Design</span>
            </div>
            </div>
            </div>
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="100" data-aos-duration="1000">
            <div class="project img ftco-animate d-flex justify-content-center align-items-center" style="background-image:url(images/xproject-5.jpg.pagespeed.ic.WwQEjmOv-r.jpg)">
            <div class="overlay"></div>
            <div class="text text-center p-4">
            <h3><a href="#">Branding &amp; Illustration Design</a></h3>
            <span>Web Design</span>
            </div>
            </div>
            </div>
            <div class="col-md-6" data-aos="flip-left" data-aos-delay="100" data-aos-duration="1000">
            <div class="project img ftco-animate d-flex justify-content-center align-items-center" style="background-image:url(images/xproject-6.jpg.pagespeed.ic.oJeeO27vYz.jpg)">
            <div class="overlay"></div>
            <div class="text text-center p-4">
            <h3><a href="#">Branding &amp; Illustration Design</a></h3>
            <span>Web Design</span>
            </div>
            </div>
            </div>
            </div>
            </section>
            <section class="ftco-section testimony-section bg-light">
            <div class="container-xl">
            <div class="row justify-content-center pb-4">
            <div class="col-md-7 text-center heading-section" data-aos="fade-up" data-aos-duration="1000">
            <span class="subheading">Testimonial</span>
            <h2 class="mb-5">Our Successful Students</h2>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="carousel-testimony">
            <div class="item">
            <div class="testimony-wrap">
            <div class="text">
            <div class="d-flex align-items-center mb-4">
            <div class="user-img" style="background-image:url(images/xperson_1.jpg.pagespeed.ic.P4pHl6glbj.jpg)">
            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
            </div>
            <div class="ps-3 tx">
            <p class="name">Roger Scott</p>
            <span class="position">Marketing Manager</span>
            </div>
            </div>
            <p class="mb-4 msg">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            </div>
            </div>
            <div class="item">
            <div class="testimony-wrap">
            <div class="text">
            <div class="d-flex align-items-center mb-4">
            <div class="user-img" style="background-image:url(images/xperson_2.jpg.pagespeed.ic.yyrmjBH91b.jpg)">
            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
            </div>
            <div class="ps-3 tx">
            <p class="name">Roger Scott</p>
            <span class="position">Marketing Manager</span>
            </div>
            </div>
            <p class="mb-4 msg">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            </div>
            </div>
            <div class="item">
            <div class="testimony-wrap">
            <div class="text">
            <div class="d-flex align-items-center mb-4">
            <div class="user-img" style="background-image:url(images/person_3.jpg)">
            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
            </div>
            <div class="ps-3 tx">
            <p class="name">Roger Scott</p>
            <span class="position">Marketing Manager</span>
            </div>
            </div>
            <p class="mb-4 msg">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            </div>
            </div>
            <div class="item">
            <div class="testimony-wrap">
            <div class="text">
            <div class="d-flex align-items-center mb-4">
            <div class="user-img" style="background-image:url(images/xperson_1.jpg.pagespeed.ic.P4pHl6glbj.jpg)">
            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
            </div>
            <div class="ps-3 tx">
            <p class="name">Roger Scott</p>
            <span class="position">Marketing Manager</span>
            </div>
            </div>
            <p class="mb-4 msg">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            </div>
            </div>
            <div class="item">
            <div class="testimony-wrap">
            <div class="text">
            <div class="d-flex align-items-center mb-4">
            <div class="user-img" style="background-image:url(images/xperson_2.jpg.pagespeed.ic.yyrmjBH91b.jpg)">
            <div class="icon d-flex align-items-center justify-content-center"><span class="fa fa-quote-left"></div>
            </div>
            <div class="ps-3 tx">
            <p class="name">Roger Scott</p>
            <span class="position">Marketing Manager</span>
            </div>
            </div>
            <p class="mb-4 msg">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </div>
            </section>
            <section class="ftco-section bg-light" id="blog">
            <div class="container-xl">
            <div class="row justify-content-center mb-5">
            <div class="col-md-7 heading-section text-center" data-aos="fade-up" data-aos-duration="1000">
            <span class="subheading">Our Blog</span>
            <h2>Recent From Blog</h2>
            </div>
            </div>
            <div class="row justify-content-center">
            <div class="col-md-6 d-flex">
            <div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <a href="blog-single.html" class="block-20 img" style="background-image:url(images/ximage_1.jpg.pagespeed.ic.sYEsLcUyj_.jpg)">
            </a>
            <div class="text">
            <p class="meta"><span><i class="fa fa-calendar me-1"></i>Jan. 18, 2021</span> <span><a href="#"><i class="fa fa-comment me-1"></i> 3 Comments</a></span></p>
            <h3 class="heading mb-3"><a href="#">Tips About Creating A New Web Design</a></h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            </div>
            <div class="col-md-6 d-flex">
            <div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <a href="blog-single.html" class="block-20 img" style="background-image:url(images/ximage_2.jpg.pagespeed.ic.cSUVyMwItV.jpg)">
            </a>
            <div class="text">
            <p class="meta"><span><i class="fa fa-calendar me-1"></i>Jan. 18, 2021</span> <span><a href="#"><i class="fa fa-comment me-1"></i> 3 Comments</a></span></p>
            <h3 class="heading mb-3"><a href="#">Tips About Creating A New Web Design</a></h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            </div>
            <div class="col-md-6 d-flex">
            <div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <a href="blog-single.html" class="block-20 img" style="background-image:url(images/ximage_3.jpg.pagespeed.ic.5zztMSovUH.jpg)">
            </a>
            <div class="text">
            <p class="meta"><span><i class="fa fa-calendar me-1"></i>Jan. 18, 2021</span> <span><a href="#"><i class="fa fa-comment me-1"></i> 3 Comments</a></span></p>
            <h3 class="heading mb-3"><a href="#">Tips About Creating A New Web Design</a></h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            </div>
            <div class="col-md-6 d-flex">
            <div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <a href="blog-single.html" class="block-20 img" style="background-image:url(images/ximage_4.jpg.pagespeed.ic.0mxmKkOd81.jpg)">
            </a>
            <div class="text">
            <p class="meta"><span><i class="fa fa-calendar me-1"></i>Jan. 18, 2021</span> <span><a href="#"><i class="fa fa-comment me-1"></i> 3 Comments</a></span></p>
            <h3 class="heading mb-3"><a href="#">Tips About Creating A New Web Design</a></h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            </div>
            <div class="col-md-6 d-flex">
            <div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <a href="blog-single.html" class="block-20 img" style="background-image:url(images/ximage_5.jpg.pagespeed.ic.uC7KZcyuOx.jpg)">
            </a>
            <div class="text">
            <p class="meta"><span><i class="fa fa-calendar me-1"></i>Jan. 18, 2021</span> <span><a href="#"><i class="fa fa-comment me-1"></i> 3 Comments</a></span></p>
            <h3 class="heading mb-3"><a href="#">Tips About Creating A New Web Design</a></h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            </div>
            <div class="col-md-6 d-flex">
            <div class="blog-entry justify-content-end" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <a href="blog-single.html" class="block-20 img" style="background-image:url(images/image_6.jpg)">
            </a>
            <div class="text">
            <p class="meta"><span><i class="fa fa-calendar me-1"></i>Jan. 18, 2021</span> <span><a href="#"><i class="fa fa-comment me-1"></i> 3 Comments</a></span></p>
            <h3 class="heading mb-3"><a href="#">Tips About Creating A New Web Design</a></h3>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
            </div>
            </div>
            </div>
            </div>
            </section>
            <section class="ftco-section" id="pricing">
            <div class="container">
            <div class="row justify-content-center pb-5">
            <div class="col-md-7 text-center heading-section" data-aos="fade-up" data-aos-duration="1000">
            <span class="subheading">My Pricing</span>
            <h2 class="mb-3">Pricing &amp; <span>Packages</span></h2>
            </div>
            </div>
            <div class="row">
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">
            <div class="block-7">
            <div class="text-center">
            <span class="excerpt d-block">Basic Plan</span>
            <span class="price"><sup>$</sup> <span class="number">49K</span></span>
            <div class="p-4 px-lg-5">
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
            </div>
            </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="block-7">
            <div class="text-center">
            <span class="excerpt d-block">Beginner Plan</span>
            <span class="price"><sup>$</sup> <span class="number">79K</span></span>
            <div class="p-4 px-lg-5">
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
            </div>
            </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="300">
            <div class="block-7">
            <div class="text-center">
            <span class="excerpt d-block">Premium Plan</span>
            <span class="price"><sup>$</sup> <span class="number">109K</span></span>
            <div class="p-4 px-lg-5">
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
            <a href="#" class="btn btn-primary btn-outline-primary d-block px-2 py-3">Get Started</a>
            </div>
            </div>
            </div>
            </div>
            </div>  -->




            </section> 

            <section class="ftco-intro py-5 bg-primary">
<div class="container">
<div class="row d-flex justify-content-center">
<div class="col-lg-12">
<div class="row g-lg-5">
<div class="col-md-8 text-lg-right">
<h2 class="mb-0">Pour plus d'information contact le Coach Edmond</h2>
<p>+257 61 955 157</p>
</div>
<div class="col-md-4 border-left d-flex align-items-center">
<p class="w-100"><a href="mailto:allineventsburundi@gmail.com" class="btn btn-white btn-outline-white d-block py-3">Ecris moi </a></p>
</div>
</div>
</div>
</div>
</div>
</section>
<section class="ftco-section ftco-no-pb" id="contactme">
<div class="container-fluid-xl">
<div class="row no-gutters justify-content-center">
<div class="col-md-12">
<div class="wrapper">
<div class="row g-0">
<div class="col-lg-6 order-lg-last">
<div class="contact-wrap w-100 p-md-5 p-4">
<h3>S'inscrire </h3>
<p class="mb-4">Reserver une place de formation </p>
@if (session()->has('success'))
    <span class="subheading" style="background-color:yellow;padding:5px; color:black">Félicitation!, enregistrement reussi  ,nous allons vous contacter pour la suite.</span> <br>
@endif


<form id="contactForm" class="contactForm" action="{{ route('sendcontact') }}" method="POST">
@method('post')
 @csrf
<div class="row">
<div class="col-lg-6">
<div class="form-group">
<input type="text" class="form-control" name="name" id="name" placeholder="Nom & Prénom">
@error('name')
    <span class="text text-danger">
    {{ $message }}
    </span>
@enderror
</div>
</div>
<div class="col-lg-6">
<div class="form-group">
<input type="email" class="form-control" name="email" id="email" placeholder="Email">
@error('email')
    <span class="text text-danger">
    {{ $message }}
    </span>
@enderror
</div>
</div>

<div class="col-md-12">
<div class="form-group">
<input type="text" class="form-control" name="phone" id="phone" placeholder="Numéro de téléphone">
@error('phone')
    <span class="text text-danger">
    {{ $message }}
    </span>
@enderror
</div>
</div>


<div class="col-md-12">
<div class="form-group">
<textarea name="competence" class="form-control" id="message" cols="30" rows="4" 
placeholder="Quels sont les competence de votre choix "></textarea>
@error('competence')
    <span class="text text-danger">
    {{ $message }}
    </span>
@enderror
</div>
</div>
<div class="col-md-12">
<div class="form-group">
<input type="submit" value="Souscrire au formation" class="btn btn-primary">
<div class="submitting"></div>
</div>
</div>
</div>
</form>
<!--
<div class="w-100 social-media mt-5">
<h3>Follow me here</h3>
<p>
<a href="#">Facebook</a>
<a href="#">Twitter</a>
<a href="#">Instagram</a>
<a href="#">Dribbble</a>
</p>
</div>

-->


</div>
</div>
<div class="col-lg-6 d-flex align-items-stretch">
<div class="bg-white"> 
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2039213.4290439263!2d29.925253999999995!3d-3.3895294499999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19c144d33654f15b%3A0xb1234d0e5631ec8d!2sBurundi!5e0!3m2!1sfr!2sbi!4v1701359309353!5m2!1sfr!2sbi" width="620" height="570" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>

@endsection