<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * JM Core Plugin - Export Utilities
 *
*/

require_once ("../../../class2.php");
require_once("admin_menu.php");



//double check
if(!getperms('0'))
{
	e107::redirect('admin');
	exit();
}

e107::coreLan('db', true);

$frm = e107::getForm();
$mes = e107::getMessage();


if(isset($_POST['exportXmlFile']))
{
	
	$createfile = exportXmlFile($_POST['xml_prefs'], $_POST['xml_themeprefs'] ,false, array('return'=>true));
	 
	if($createfile)
	{
		$mes = e107::getMessage();
		$mes->add(LAN_CREATED, E_MESSAGE_SUCCESS);
	}

}


class jmcore_adminArea extends jmcoremenu_adminArea
{
	protected $modes = array(	
	
		'tools'	=> array(
			'controller' 	=> 'jmcore_ui',
			'path' 			=> null,
			'ui' 			=> 'jmcore_form_ui',
			'uipath' 		=> null
		),
		

	);	
	protected $menuTitle = 'JM Core Plugin';
}
				
class jmcore_ui extends e_admin_ui
{			
	protected $pluginTitle		= 'JM Core';
	protected $pluginName		= 'jmcore';	
	protected $table			= '';
	protected $pid				= '';
	protected $fields 		= NULL;			
	protected $fieldpref = array();
	protected $prefs = array( 
	); 

	public function exportFormPage()
	{
		//selected core prefs related to theme
		$pref_types  = array(
			'sitetheme_custompages'=>'sitetheme_custompages',
			'sitetheme_deflayout'  =>'sitetheme_deflayout',
			'sitetheme_layouts'  =>'sitetheme_layouts',
			'themecss'  =>'themecss',
			);
		$text = $this->exportXmlForm($pref_types);
		e107::getRender()->tablerender('',$text);	
	}
 
    /**
	 * Export XML Dump
	 * @return string
	 * @original source: admin/db.php
	 */
	private function exportXmlForm($pref_types = array())
	{
		$mes = e107::getMessage();
		$frm = e107::getSingleton('e_form');

		$text = "
			<form method='post' action='".e_SELF."?".e_QUERY."' id='core-db-export-form'>
			<fieldset id='core-db-export'>
			<legend class='e-hideme'>".DBLAN_95."</legend>
			<table class='table adminlist'>
				<colgroup><col></colgroup>
				<thead>
					<tr>
						<th class='form-inline'>".$frm->checkbox_toggle('check-all-verify', 'xml_prefs')." 
						&nbsp;Core Theme preferencies [just selected core preferencies, use classic import tool]</th>
					</tr>
				</thead>
				<tbody>
				";


			foreach($pref_types as $key=>$description)
			{
				$checked = (vartrue($_POST['xml_prefs'][$key]) == $key) ? 1: 0;
				$text .= "<tr>
					<td>
						".$frm->checkbox("xml_prefs[".$key."]", $key, $checked, array('label'=>LAN_PREFS.": ".$key))."
					</td>
					</tr>";
			}

			$text .= "</tbody><thead><tr>
			<th class='form-inline'>".$frm->checkbox_toggle('check-all-verify', 'xml_themeprefs')."
			 &nbsp;Theme Config Data [record from core table, don't forget delete cache after importing]</th>
			</tr></thead><tbody>";
			 
			$sitetheme = e107::getPref('sitetheme');
			$key = $sitetheme; 
			$text .= "<tr>
					<td>
						".$frm->checkbox("xml_themeprefs[".$key."]", $key, $checked, array('label'=> " Configuration: ".$key))."
					</td>
					</tr>";

 			$text .= "</tbody>
				</table>
				</tbody>
				</table>
				<div class='buttons-bar center'>
					".$frm->admin_button('exportXmlFile', DBLAN_101, 'other')."
				</div>
			</fieldset>
		</form>	"; 
		return $text;
	}    			
}
 

/* original source: handlers/xml_class.php */
/* core exportXML() can't be used because you can't select prefs to export
/**
 * Create an e107 Export File in XML format
 *
 * @param array $prefs  - see e_core_pref $aliases (eg. core, ipool etc)
 * @param array $themePrefs - core record name
 * @param array $options [optional] debug, return, query
 * @return string text / file for download
 */
function exportXmlFile($xmlprefs, $themePrefs, $options = array())
{
	$xml = e107::getXml();
	$text = "<?xml version='1.0' encoding='utf-8' ?".">\n";
	$text .= "<e107Export version=\"".e_VERSION."\" timestamp=\"".time()."\" >\n";

	if(varset($xmlprefs)) // Export Core Preferences.
	{
		$text .= "\t<prefs>\n";
		$type = 'core';
		foreach($xmlprefs as $value)
		{                             
			$val= e107::getConfig('core')->getPref($value);      
				if(isset($val))
				{
					$text .= "\t\t<".$type." name=\"".$value."\">".$xml->e107ExportValue($val)."</".$type.">\n";
				}		
		}
		$text .= "\t</prefs>\n";
	}

	//$plugPrefs way can't be used, because they will not be imported 
	if(!empty($themePrefs))
	{ 
		$text .= "\t<database>\n";
		//only for core table that is excluded from standard export.
		$tables = "core";  
		//in fact there is only one key, but let it be this way
		foreach($themePrefs as $key=>$tbl)
		{      
			$eQry = " e107_name = 'theme_". $key."'";
			$eTable= str_replace(MPREFIX,"",$tables);				
			e107::getDb()->select($eTable, "*", $eQry);
			$text .= "\t<dbTable name=\"".$eTable."\">\n";
			$count = 1;
			while($row = e107::getDb()->fetch())
			{
				if($xml->convertFilePaths == true && $eTable == 'core_media' && substr($row['media_url'],0,8) != '{e_MEDIA')
				{
					continue;
				}
				$text .= "\t\t<item>\n";
				foreach($row as $key=>$val)
				{
					$text .= "\t\t\t<field name=\"".$key."\">".$xml->e107ExportValue($val,$key)."</field>\n";
				}
				$text .= "\t\t</item>\n";
				$count++;
			}
			$text .= "\t</dbTable>\n";
		}
		$text .= "\t</database>\n";
	}
	$text .= "</e107Export>";
     
	if(!empty($options['return']))
	{
		return $text;
	}

	if(!empty($options['debug']))
	{
		echo "<pre>".htmlentities($text)."</pre>";
		return null;
	}
	else
	{
		if(!$text)
		{
			return FALSE;
		}
		$fileName = (!empty($options['file'])) ? $options['file'] : "e107Export_" . date("Y-m-d").".xml";
		header('Content-type: application/xml', TRUE);
		header("Content-disposition: attachment; filename= ".$fileName);
		header("Cache-Control: max-age=30");
		header("Pragma: public");
		echo $text;
		exit; 

	}
}    
    
    
new jmcore_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?> 
