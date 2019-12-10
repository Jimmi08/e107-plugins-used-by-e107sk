<?php

// Template File
// re_TEAMMEMBERS Template file

if (!defined('e107_INIT')) { exit; }

      // <img src="images/icons/empty.png" data-src="images/resource/agent-1.jpg" alt="">
$TEAMMEMBERS_TEMPLATE = array();

$TEAMMEMBERS_TEMPLATE['list']['start'] 	= '
 
';
//   <span class="designation">4 Properties</span>
$TEAMMEMBERS_TEMPLATE['list']['item'] 	= '{SETIMAGE: w=340&h=450&crop=1}
                <!-- Agent Block -->
                <div class="agent-block col-lg-4 col-md-4 col-sm-6 col-xs-12  fadeInUp">
                    <div class="inner-box">
                        <div class="image-box">
                            <figure class="image"><a href="{AGENT_DETAIL_url}">
                            {AGENT_IMAGE}
                           </a></figure>
                        </div>
                        <div class="info-box">
                            <h4 class="name"><a href="{AGENT_DETAIL_url}" title="{AGENT_TITLE}" >{AGENT_TITLE}</a></h4>
                             
                            <span class="position"> {AGENT_POSITION}</span> </br>

                            {AGENT_SOCIALLINKS: email=1}
                        </div>
                    </div>
                </div>

';

$TEAMMEMBERS_TEMPLATE['list']['end'] 	= '
 
';

$TEAMMEMBERS_TEMPLATE['view']['caption']  = '';
$TEAMMEMBERS_TEMPLATE['view']['tablerender']  = 'nocaption';  
$TEAMMEMBERS_TEMPLATE['view']['start']  	= '
    <!-- Agent Detail -->
    <section class="agent-detail">
        <div class="auto-container">
            <div class="upper-box">
               ';

//<span class="designation">4 Properties</span>
$TEAMMEMBERS_TEMPLATE['view']['item']  ='
 <div class="row">
  <div class="image-column col-lg-4 col-md-6 col-sm-6 ">
      <!-- Agent Block -->
      <div class="agent-block wow fadeIn">
          <div class="inner-box">
              <div class="image-box">
                  <figure class="image">{AGENT_IMAGE}</figure>
              </div>
              <div class="info-box">
                  <h4 class="name">{AGENT_TITLE}</h4>
                  {AGENT_SOCIALLINKS}
              </div>
          </div>
      </div>
  </div>
  
  <div class="info-column col-lg-8 col-md-6 col-sm-6">
      <div class="inner-columnx">
          <h3>About the Agent</h3>
          {AGENT_BIO} 
          {AGENT_FACTS}
      </div>
  </div>
</div>  
 
';
            
       
$TEAMMEMBERS_TEMPLATE['view']['end']  ='</div>
</div></div></section>';
 
$TEAMMEMBERS_TEMPLATE['social_links']['start']  ='<ul class="social-links social-icon-colored">';
$TEAMMEMBERS_TEMPLATE['social_links']['item']  ='<li><a href="{URL}">{ICON}</a></li>';
$TEAMMEMBERS_TEMPLATE['social_links']['end']  ='</ul>';


$TEAMMEMBERS_TEMPLATE['facts']['start']  =' <table class="agent-info">';
$TEAMMEMBERS_TEMPLATE['facts']['item']  ='<tr><td><strong>{LABEL}</strong></td><td> {TEXT}</td></tr>';

    
$TEAMMEMBERS_TEMPLATE['facts']['end']  ='</table> ';


$TEAMMEMBERS_TEMPLATE['pagination']['start']			= '<div class="styled-pagination text-center"><ul class="clearfix">';
$TEAMMEMBERS_TEMPLATE['pagination']['end'] 			= "</ul></div><!-- End of Next/Prev -->";
$TEAMMEMBERS_TEMPLATE['pagination']['nav_caption'] 	= '';

$TEAMMEMBERS_TEMPLATE['pagination']['nav_first'] 		= '<li><a class="first hidden-xs" href="{url}" title="{url_label}">{label}</a></li>';
$TEAMMEMBERS_TEMPLATE['pagination']['nav_prev'] 		= '<li class="prev-post"><a href="{url}" title="{url_label}"><span class="fa fa-angle-left"></span> {label}</a></li>';
$TEAMMEMBERS_TEMPLATE['pagination']['nav_last'] 		= '<li><a class="last hidden-xs" href="{url}" title="{url_label}">{label}</a></li>';
$TEAMMEMBERS_TEMPLATE['pagination']['nav_next'] 		= '<li class="next-post" ><a  href="{url}" title="{url_label}"> {label}</a></li>';

$TEAMMEMBERS_TEMPLATE['pagination']['items_start'] 	= '';
$TEAMMEMBERS_TEMPLATE['pagination']['item'] 			= '<li><a class="hidden-xs" href="{url}" title="{url_label}">{label}</a></li>';
$TEAMMEMBERS_TEMPLATE['pagination']['item_current'] 	= '<li class="active disabled"><a href="#" onclick="return false;" title="{url_label}">{label}</a></li>';
$TEAMMEMBERS_TEMPLATE['pagination']['items_end'] 		= '';

$TEAMMEMBERS_TEMPLATE['pagination']['separator'] 		= '';




