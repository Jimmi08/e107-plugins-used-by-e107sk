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
	</div>';

$TEAM_MEMBERS_TEMPLATE['list_']['end'] 	= '
 
';

/* template used for pure bootstrap4 template - example for 2 lines caption */
$TEAM_MEMBERS_TEMPLATE['list_pure']['caption'] 	= 
'<h2 class="text-warning display-2">{MENU_TITLE}</h2><p class="lead text-light">{MENU_SUBTITLE}</p>';  
$TEAM_MEMBERS_TEMPLATE['list_pure']['item'] = '
{SETIMAGE: w=500}
<div class="col-lg-4 col-sm-10 mx-auto mb-4">
	<div class="card">
		{AGENT_IMAGE: class=card-img-top}
		<div class="card-body">
			<div class="card-title">
				<h3 class="text-muted">{AGENT_TITLE}</h3>
			</div>
			<div class="card-subtitle">
				<p class="lead text-secondary">{AGENT_SUMMARY}</p>
			</div>
			<div class="text-right">
				{AGENT_SOCIALLINKS}
			</div>
		</div>
	</div>
</div>';
$TEAM_MEMBERS_TEMPLATE['list_pure']['end'] = '</div>';


/* template used for freelancer bootstrap4 template */
$TEAM_MEMBERS_TEMPLATE['list_freelancer']['tablestyle'] = 'home-section-primary';
$TEAM_MEMBERS_TEMPLATE['list_freelancer']['caption'] = '{MENU_TITLE}';
$TEAM_MEMBERS_TEMPLATE['list_freelancer']['start'] = '<div class="row">';

$TEAM_MEMBERS_TEMPLATE['list_freelancer']['item'] = '
{SETIMAGE: w=500}
<div class="col-lg-4 col-sm-10 mx-auto mb-4">
	<div class="card">
		{AGENT_IMAGE: class=card-img-top}
		<div class="card-body">
			<div class="card-title">
				<h3 class="text-muted">{AGENT_TITLE}</h3>
			</div>
			<div class="card-subtitle">
				<p class="lead text-secondary">{AGENT_SUMMARY}</p>
			</div>
			<div class="text-right">
				{AGENT_SOCIALLINKS}
			</div>
		</div>
	</div>
</div>';
$TEAM_MEMBERS_TEMPLATE['list_freelancer']['end'] = '</div>';

/* example for solid bootstrap4 theme - hover efect for social links */
$TEAM_MEMBERS_TEMPLATE['list_solid']['start'] 	= '<div class="container mtb"><div class="row centered">';     

$TEAM_MEMBERS_TEMPLATE['list_solid']['item'] 	= '
{SETIMAGE: w=600}
<div class="col-lg-3 col-md-3 col-sm-3">  
	<div class="he-wrap tpl6">
	{AGENT_IMAGE}
		<div class="he-view">
			<div class="bg a0" data-animate="fadeIn">
				<h3 class="a1" data-animate="fadeInDown">Contact Me:</h3>
				<a href="mailto:{AGENT_EMAIL}" class="dmbutton a2" data-animate="fadeInUp"><i class="fa fa-envelope"></i></a>
				{AGENT_SOCIALLINKS: template=social_links_solid}
			</div><!-- he bg -->
		</div><!-- he view -->      
	</div><!-- he wrap -->
	<h4>{AGENT_TITLE}</h4>
	<h5 class="ctitle">{AGENT_POSITION}</h5>
	<p>{AGENT_SUMMARY}</p>
	<div class="hline"></div>
</div><! --/col-lg-3 -->';

$TEAM_MEMBERS_TEMPLATE['list_solid']['end'] 	= '</div><! --/row -->
	</div><! --/container -->';

$TEAM_MEMBERS_TEMPLATE['social_links_solid']['start']  ='';
$TEAM_MEMBERS_TEMPLATE['social_links_solid']['item']  ='<a href="{URL}" class="dmbutton a2" data-animate="fadeInUp">{ICON}</a>';
$TEAM_MEMBERS_TEMPLATE['social_links_solid']['end']  ='';


/* example for bootstrap4 theme - 4 columns with circle images */	
$TEAM_MEMBERS_TEMPLATE['list_mdb1']['tablestyle'] = 'home-section-primary';
$TEAM_MEMBERS_TEMPLATE['list_mdb1']['caption'] = '<h2 class="h1-responsive font-weight-bold my-5">{MENU_TITLE}</h2><p class="grey-text w-responsive mx-auto mb-5">{MENU_SUBTITLE}</p>';
$TEAM_MEMBERS_TEMPLATE['list_mdb1']['start'] 	= '<div class="row">';
$TEAM_MEMBERS_TEMPLATE['list_mdb1']['item'] 	= '{SETIMAGE: w=300}	
		<!-- Grid column -->
		<div class="col-lg-3 col-md-6 mb-lg-0 mb-5">
		  <div class="avatar mx-auto">{AGENT_IMAGE: class=rounded-circle z-depth-1}</div>
		  <h5 class="font-weight-bold mt-4 mb-3">{AGENT_TITLE}</h5>
		  <p class="text-uppercase blue-text"><strong>{AGENT_POSITION}</strong></p>
		  <p class="grey-text">{AGENT_SUMMARY}</p>
		  {AGENT_SOCIALLINKS: template=social_links_mdb1&icon_class=text-blue}
		</div>
		<!-- Grid column -->';

$TEAM_MEMBERS_TEMPLATE['list_mdb1']['end'] 	= '</div>';

$TEAM_MEMBERS_TEMPLATE['social_links_mdb1']['start']  ='<ul class="list-unstyled mb-0">';
$TEAM_MEMBERS_TEMPLATE['social_links_mdb1']['item']  =' <a class="p-2 fa-lg fb-ic" href="{URL}">{ICON}</a> ';
$TEAM_MEMBERS_TEMPLATE['social_links_mdb1']['end']  ='</ul>';



/*  view template for team member page ****************************************************************/

$TEAM_MEMBERS_TEMPLATE['view_']['caption'] = '';
$TEAM_MEMBERS_TEMPLATE['view_']['tablerender'] = 'nocaption';
$TEAM_MEMBERS_TEMPLATE['view_']['start'] = '
    <!-- Agent Detail -->
    <div class="agent-detail">';

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
</div>';
            
       
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




