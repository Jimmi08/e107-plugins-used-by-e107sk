<?php
/**
 * Testimonials plugin for e107 v2.
 *
 * @file
 * Templates for plugins displays.
 */

$TESTIMONIALS_TEMPLATE = array();

//default key override plugin js
  
$TESTIMONIALS_TEMPLATE['menu']['css']['default']  = array("testimonials", "css/testimonials.css"); 
$TESTIMONIALS_TEMPLATE['menu']['js']['default']  = array( "testimonials", "js/testimonials.js");
$TESTIMONIALS_TEMPLATE['menu']['js']['custom']  = array( "theme" , "js/testimonials.js");   
$TESTIMONIALS_TEMPLATE['menu']['tablerender']  =  "nocaption" ;  

$TESTIMONIALS_TEMPLATE['menu']['header'] = ' {SETIMAGE: w=100&h=100&crop=1}
   <!-- Testimonial Section -->
    <section class="testimonial-section-two">
        <div class="auto-container">
            <div class="sec-title text-center">
                <div class="devider"><span></span></div>
                <h2>What Our Client Says 1</h2>
                <div class="text">Find Your Dream House in Your City</div>
            </div>

            <div class="testimonial-carousel owl-carousel owl-theme">
             ';
				            
$TESTIMONIALS_TEMPLATE['menu']['body'] = '';
												  
$TESTIMONIALS_TEMPLATE['menu']['item'] = '
                <!-- Testimonial Block -->
                <div class="testimonial-block-two">
                    <div class="inner-box">
                        <div class="info-box">
                            <figure class="thumb">{TESTIMONIALS_IMAGE}</figure>
                            <h4 class="name">{TESTIMONIALS_AUTHOR: type=name}</h4>
                            <span class="designation">{TESTIMONIALS_POSITION}</span>
                            <div class="rating">{TESTIMONIALS_RATING}</div>                           
                        </div>
                        <div class="text">{TESTIMONIALS_MESSAGE}</div>
                        <span class="icon fa fa-quote-right"></span>
                    </div>
                </div> ';

$TESTIMONIALS_TEMPLATE['menu']['footer'] = '
                </div>
            </div>
        </div>
    </section>
';

$TESTIMONIALS_TEMPLATE['menu']['rate']  = '<span class="fa fa-star"></span>';

 
$TESTIMONIALS_TEMPLATE['user']['css']['default']  = array("testimonials", "css/testimonials.css"); 
$TESTIMONIALS_TEMPLATE['user']['js']['default']  = array("testimonials", "js/testimonials.js");
$TESTIMONIALS_TEMPLATE['user']['js']['custom']  = array( "theme" , "js/testimonials.js");   
$TESTIMONIALS_TEMPLATE['user']['tablerender']  =  "nocaption" ;  
 
$TESTIMONIALS_TEMPLATE['user']['header'] = ' {SETIMAGE: w=170&h=230&crop=1}
     <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="auto-container">
            <div class="sec-title text-center">
                <div class="devider"><span></span></div>
                <h2>What Our Client Says 2</h2>
                <div class="text">Find Your Dream House in Your City</div>
            </div>

            <div class="testimonial-carousel owl-carousel owl-theme">
             ';
$TESTIMONIALS_TEMPLATE['user']['body'] = '';

$TESTIMONIALS_TEMPLATE['user']['item'] = '   
<div class="testimonial-block">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image">{TESTIMONIALS_IMAGE: size=170x230}</figure>
                        </div>
                        <div class="content-box">
                            <span class="designation">{TESTIMONIALS_POSITION}</span>
                            <h4 class="name">{TESTIMONIALS_AUTHOR: type=name}</h4>
                            <div class="text">{TESTIMONIALS_MESSAGE}</div>
                            <div class="rating">{TESTIMONIALS_RATING}</div>
                        </div>
                    </div>
                </div>';

$TESTIMONIALS_TEMPLATE['user']['footer'] = '
                </div>
            </div>
        </div>
    </section>
';
$TESTIMONIALS_TEMPLATE['user']['rate']  = '<span class="fa fa-star"></span>';				 