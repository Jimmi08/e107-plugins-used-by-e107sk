<?php
/**
 * Testimonials plugin for e107 v2.
 *
 * @file
 * Templates for plugins displays.
 */

$TESTIMONIALS_TEMPLATE = array();

$TESTIMONIALS_TEMPLATE['menu']['css']['default']  = array("testimonials", "css/testimonials.css"); 
$TESTIMONIALS_TEMPLATE['menu']['js']['default']  = array( "testimonials", "js/testimonials.js");

$TESTIMONIALS_TEMPLATE['menu']['tablerender']  =  "testimonials-menu" ;

$TESTIMONIALS_TEMPLATE['menu']['header'] = '
	<div class="row">
		<div class="col-md-12" data-wow-delay="0.2s">

			<div class="carousel slide" data-ride="carousel" id="quote-carousel">
				<!-- Bottom Carousel Indicators -->
				{TESTIMONIALS_INDICATORS}

				<!-- Carousel Slides / Quotes -->
				<div class="carousel-inner text-center">';

$TESTIMONIALS_TEMPLATE['menu']['body'] = '
					<div class="carousel-item item{TESTIMONIALS_ACTIVE}">
						<blockquote class="blockquote-color-bg-primary">
				 
								{TESTIMONIALS_ITEMS=2}
						 
						</blockquote>
					</div>';

$TESTIMONIALS_TEMPLATE['menu']['item'] = '

<div class="col-sm-4 col-sm-offset-2">

                <p>{TESTIMONIALS_MESSAGE}</p>
                <footer>{TESTIMONIALS_AUTHOR}</footer>
           
								</div>';

$TESTIMONIALS_TEMPLATE['menu']['footer'] = '
				</div>

				<!-- Carousel Buttons Next/Prev -->
				<a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a>
				<a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a>
			</div>
		</div>
	</div>
';

//just saving time, not correct way
$TESTIMONIALS_TEMPLATE['user']  = $TESTIMONIALS_TEMPLATE['menu'];