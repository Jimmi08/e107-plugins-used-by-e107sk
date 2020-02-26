<?php

/*
+---------------------------------------------------------------+
 *	Contact Us Plugin for CMS e107
 *	by Spinning Planet (www.spinningplanet.co.nz)
 *  modified and supported for version 2 by
 *  Jimako (www.e107sk.com) 
 *  with kindly permission from Spinning Planet
 *	Released under the terms and conditions of the
 *	GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
+---------------------------------------------------------------+
*/


// Public
define("CU_REQUIRED", "*");
define("CU_REQUIRED_MSG", "indicates a required field");
define("CU_SUBMIT", "Submit");
define("CU_IMGCODE", "Please Enter Code");
define("CU_POST_ERROR", "Please fill out this field.");
define("CU_POST_IMGCODE_ERROR", "Please enter the code.");
define("CU_POST_IMGCODE_ERROR2", "Code Incorrect - Enter new code.");
define("CU_POST_EMAIL_ERROR", "Invalid email address");
define("CU_EMAIL_SUBJECT", "Form Submitted");
define("CU_EDIT_INFO", "Edit Contact Information");
define("CU_EDIT_FORM", "Edit Contact Form");
define("CU_EDIT_MESSAGES", "View Submitted Messages");

// Plugin
define("CUP_NAME", "SP_ContactUs");
define("CUP_DESC", "A Plugin that replaces the core e107 contact page. This plugin will store all message sent through the contact form. Also has a simple interface to edit Contact Information");
define("CUP_MENU", "Contact Us");
define("CUP_LINK_NAME", "Contact Us"); // To demonstrate your link name can be different than plugin name
define("CUP_CAPTION", "Configure ".CUP_NAME);
define("CUP_DONE1", "Installation ");
define("CUP_DONE2", "successful...");
define("CUP_DONE3","Thank you for upgrading to"); // Plugin version will be added automatically

// Admin Menu
define("CUP_MENU_00", CUP_MENU." - Options");
define("CUP_MENU_03", CUP_MENU." - Settings");
define("CUP_MENU_01", "Edit ".CUP_MENU." Information");
define("CUP_MENU_02", "Edit ".CUP_MENU." Form");
define("CUP_MENU_04", "Submitted Messages");
define("CUP_MENU_05", "Help");
define("CUP_MENU_06", "Google Map Settings");

// Admin Contact Us Settings
define("CUP_SETTINGS_00", CUP_MENU." - Configuration");
define("CUP_SETTINGS_01", "Send to Email Addresses");
define('CUP_SETTINGS_EMAILFROM', "From Name");
define('CUP_SETTINGS_EMAILFROMNAME', "From Email Address");
define("CUP_SETTINGS_02", "Send Message to Recipient");
define("CUP_SETTINGS_03", "Save Messages to Database");
define("CUP_SETTINGS_04", "Show ".CUP_MENU." Information");
define("CUP_SETTINGS_05", "Show ".CUP_MENU." Form");
define("CUP_SETTINGS_MAP", "Show Google Map ");
define("CUP_SETTINGS_MAP_HELP", "Select way how your map is displayed. Be aware that your theme should support this. ");
define("CUP_SETTINGS_06", "Thankyou Message");
define("CUP_SETTINGS_BTNADD", "Add Email");
define("CUP_SETTINGS_SAVESETTINGS", "Save Settings");
define("CUP_S_SAVEMSG", "Settings Successfully Saved");
define("CUP_SETTINGS_MAP_KEY", "Insert Google Maps API key");
define("CUP_SETTINGS_MAP_IFRAME", "Embed Google Map");
define("CUP_SETTINGS_MAP_IFRAME_HELP", "Use for embed map in iframe without API key");
define("CUP_SETTINGS_MAP_MARKER", "Map Marker");
define("CUP_SETTINGS_MAP_MARKER_HELP", " ");
 



define("CUP_S_ERRORMSG", "Error Saving Settings");

define("CUP_SETTINGS_OPT1", "Yes");
define("CUP_SETTINGS_OPT2", "No");

// Admin Contact Info
define("CUP_INFO_00", CUP_MENU." - Information");
define("CUP_INFO_01", "Page Title");
define("CUP_INFO_02", "Information");
define("CUP_INFO_MAP", "Google Map");
define("CUP_INFO_MAP_ZOOM", "Google Map Zoom");
define("CUP_INFO_ADDRESS", "Enter an Address...");
define("CUP_INFO_SAVE", "Save");
define("CUP_INFO_SAVEMSG", "Information Successfully Saved");
define("CUP_INFO_ERRORMSG", "Error Saving Information");

// Admin Contact Form
define("CUP_FORM_TITLE", CUP_MENU." - Contact Form");
define("CUP_FORM_CAP_ORDER", "Order");
define("CUP_FORM_CAP_NAME", "Name");
define("CUP_FORM_CAP_REQ", "Required");
define("CUP_FORM_CAP_TYPE", "Type");
define("CUP_FORM_CAP_VARS", "Parameters");
define("CUP_FORM_CAP_VARS_HELP", "View help on the right");
define("CUP_FORM_CAP_OPT", "Options");
define("CUP_FORM_UPDATEFORM", "Update Form");
define("CUP_UPDATE_CONF", "Form Successfully Saved");
define("CUP_FORM_CONFIRMDELETE", "This field will be permanently deleted and cannot be recovered. Are you sure?");
define("CUP_FORM_BTN_DELETEMESSAGE", "Delete Field");
define("CUP_FORM_DELETEMESSAGETITLE", "Confirm Deletion of Field");
define("CUP_FORM_DELETECONF", "Field deleted.");
define("CUP_FORM_REORDERCONF", "Field order saved.");

// Admin Contact Info
define("CUP_HELP_00", CUP_MENU." - Help");
define("CUP_HELP_01", "Page Title");
define("CUP_HELP_02", "Information");

// Admin Submitted Messages
define("CUP_MESSAGE_TITLE", CUP_MENU." - Submitted Messages");
define("CUP_MESSAGE_CONFIRMDELETE", "This message will be permanently deleted and cannot be recovered. Are you sure?");
define("CUP_MESSAGE_BTN_DELETEMESSAGE", "Delete Message");
define("CUP_MESSAGE_DELETEMESSAGETITLE", "Confirm Deletion of Message");
define("CUP_MESSAGE_DELETECONF", "Message deleted.");

//frontend strings
define("CUP_RECEPIENT_MESSAGE_01",  "Your form has been sent ");
 


?>