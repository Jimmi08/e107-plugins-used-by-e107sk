<?php

// Template File
// re_TEAMMEMBERS Template file

if (!defined('e107_INIT')) { exit; }

      // <img src="images/icons/empty.png" data-src="images/resource/agent-1.jpg" alt="">
$TEAM_MEMBERS_TEMPLATE = array();

$TEAM_MEMBERS_TEMPLATE['list_']['start'] 	= '
 
';
//   <span class="designation">4 Properties</span>
$TEAM_MEMBERS_TEMPLATE['list_']['item'] 	= '{SETIMAGE: w=340&h=450&crop=1}
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

$TEAM_MEMBERS_TEMPLATE['list_']['end'] 	= '
 
';

$TEAM_MEMBERS_TEMPLATE['view_']['caption']  = '';
$TEAM_MEMBERS_TEMPLATE['view_']['tablerender']  = 'nocaption';  
$TEAM_MEMBERS_TEMPLATE['view_']['start']  	= '
    <!-- Agent Detail -->
    <div class="agent-detail">
 
               ';

//<span class="designation">4 Properties</span>
$TEAM_MEMBERS_TEMPLATE['view_']['item']  ='{SETIMAGE: w=600}
 <div class="row">
  <div class="image-column col-lg-4 col-md-6 col-sm-6 ">
      <!-- Agent Block -->
      <div class="agent-block wow fadeIn">
          <div class="inner-box">
              <div class="image-box">
                  <figure class="image ">{AGENT_IMAGE}</figure>
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
            
       
$TEAM_MEMBERS_TEMPLATE['view']['end']  ='</div>
</div> ';
 
$TEAM_MEMBERS_TEMPLATE['social_links']['start']  ='<ul class="social-links social-icon-colored">';
$TEAM_MEMBERS_TEMPLATE['social_links']['item']  ='<li><a href="{URL}">{ICON}</a></li>';
$TEAM_MEMBERS_TEMPLATE['social_links']['end']  ='</ul>';


$TEAM_MEMBERS_TEMPLATE['facts']['start']  =' <table class="agent-info">';
$TEAM_MEMBERS_TEMPLATE['facts']['item']  ='<tr><td><strong>{LABEL}</strong></td><td> {TEXT}</td></tr>';

    
$TEAM_MEMBERS_TEMPLATE['facts']['end']  ='</table> ';


$TEAM_MEMBERS_TEMPLATE['pagination']['start']			= '<div class="container"> <ul class="pagination justify-content-center pagination-lg">';
$TEAM_MEMBERS_TEMPLATE['pagination']['end'] 			= "</ul></div> ";
$TEAM_MEMBERS_TEMPLATE['pagination']['nav_caption'] 	= '';

$TEAM_MEMBERS_TEMPLATE['pagination']['nav_first'] 		= '<li class="page-item">			<a class="page-link first hidden-xs" href="{url}" title="{url_label}">{label}</a></li>';
$TEAM_MEMBERS_TEMPLATE['pagination']['nav_prev'] 		= '<li class="page-item prev-post">	<a class="page-link" href="{url}" title="{url_label}"><span class="fa fa-angle-left"></span> {label}</a></li>';
$TEAM_MEMBERS_TEMPLATE['pagination']['nav_last'] 		= '<li class="page-item">			<a class="page-link last hidden-xs" href="{url}" title="{url_label}">{label}</a></li>';
$TEAM_MEMBERS_TEMPLATE['pagination']['nav_next'] 		= '<li class="page-item next-post" ><a class="page-link"   href="{url}" title="{url_label}"> {label}</a></li>';

$TEAM_MEMBERS_TEMPLATE['pagination']['items_start'] 	= '';
$TEAM_MEMBERS_TEMPLATE['pagination']['item'] 			= '<li class="page-item"><a class="page-link hidden-xs" href="{url}" title="{url_label}">{label}</a></li>';
$TEAM_MEMBERS_TEMPLATE['pagination']['item_current'] 	= '<li class="page-item active disabled"><a class="page-link"  href="#" onclick="return false;" title="{url_label}">{label}</a></li>';
$TEAM_MEMBERS_TEMPLATE['pagination']['items_end'] 		= '';

$TEAM_MEMBERS_TEMPLATE['pagination']['separator'] 		= '';




