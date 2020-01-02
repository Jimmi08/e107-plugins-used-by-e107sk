<?php 

/* fix for width of select box in dark admin theme e107::css() is slower */

if (ADMIN_AREA)
{
	echo "<style>  table input.form-control, table textarea.form-control, table select.form-control {
    width: 100%;
    }    </style>";
}