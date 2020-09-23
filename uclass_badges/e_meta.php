<?php
if (!defined('e107_INIT')) { exit; }

//print_a(e_PAGE);


if (e_PAGE == "user.php") {
                              
  $auto_view = e107::pref('uclass_badges', 'auto_view_template');
  $auto_list = e107::pref('uclass_badges', 'auto_list_template');
 
  $USER_TEMPLATE = e107::getCoreTemplate('user');
  //print_a($USER_TEMPLATE);

  if($auto_view) { 
    $user3_old = "{USER_LOGINNAME}";
    $user3_new = "{USER_LOGINNAME} {UCLASS_BADGES}";
    $USER_FULL_TEMPLATE = str_replace($user3_old, $user3_new, $USER_FULL_TEMPLATE);
    $USER_TEMPLATE['view'] = str_replace($user3_old, $user3_new, $USER_TEMPLATE['view']);
  }
  if($auto_list) { 
    $user2_old = "{USER_NAME_LINK}";
    $user2_new = "{USER_NAME_LINK} <br> {UCLASS_BADGES}";
    $USER_SHORT_TEMPLATE = str_replace($user2_old, $user2_new, $USER_SHORT_TEMPLATE);
    $USER_TEMPLATE['list']['item'] = str_replace($user2_old, $user2_new, $USER_TEMPLATE['list']['item']);
  } 

  //e107::setRegistry('core/e107/templates/user', $USER_TEMPLATE['view']); 
 
}