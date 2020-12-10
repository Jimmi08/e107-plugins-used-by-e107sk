<?php

// v2.x Standard for extending admin areas.

e107::lan('gsitemap',true);

class gsitemap_admin
{

	/**
	 * Extend Admin-ui Parameters
	 * @param $ui admin-ui object
	 * @return array
	 */
	
	public function config($ui)
	{
		$config = array();
		// Event name, e.g: 'wmessage', 'news' etc. (core or plugin).
		$type = $ui->getEventName();
		// Current mode, e.g: 'create', 'edit', 'list'.
		$action = $ui->getAction();
		// Primary ID of the record being created/edited/deleted.
		$id = $ui->getId();

		/*** Common for all plugins ***/
		$where = "gsitemap_table='{$table}' AND gsitemap_table_id=" . $id;
		
 
		switch($type)
		{
			case "page":
			case "news":
				$config['tabs'] = array('gsitemap'=>'Google Sitemap');
				$config['fields']['gsitemap'] = 
						array ( 'title' =>"", 'type' => 'method',  'tab'=>'gsitemap', 
						'writeParms'=> array(
							'table'=>$type,
							'id'=>$id,
							'nolabel'=>true
							), 
						'width' => 'auto', 'help' => '', 'readParms' => '', 'class' => 'left', 'thclass' => 'left', 
				 );
 
			return $config;
			break;
		}

		return $config;
	}

	/**
	 * Process Posted Data.
	 *
	 * @param object $ui
	 *  Admin UI object.
	 * @param int $id
	 *  Primary ID of the record being created/edited/deleted.
	 */
	public function process($ui, $id = 0)
	{
		$data = $ui->getPosted();
		$type = $ui->getEventName();
		$action = $ui->getAction(); // current mode: create, edit, list
		$sql = e107::getDb();

 
		 
		if($data['gsitemap_update']  == 1)  {
			//get actual (SEF) URL
		}
		elseif( $data['gsitemap_delete']  == 1) {
            //delete record
		}
		elseif($data['gsitemap_create'] == 1) {
			//add record
			if($type == 'news') {
				// we needs type settings
				// this doesn't work: $addons = e107::getAddonConfig('e_gsitemap', 'news_gsitemap', 'import');
				$addons = e107::getAddonConfig('e_gsitemap', null, 'config');
				// add config 

				$sitemap_type = $addons['news']['news']['type'] ;
				$url =  e107::getUrl()->create('news/view/item', $data, array('full' => 1));

				$insert = array(
					'gsitemap_id'       => NULL,
					'gsitemap_name'     => e107::getParser()->toDB($data['news_title']),
					'gsitemap_url'      => e107::getParser()->toDB($url),
					'gsitemap_table'    => e107::getParser()->toDB($type),
					'gsitemap_table_id' => (int) $id,
					'gsitemap_lastmod'  => time(),
					'gsitemap_freq'     => varset($data['gsitemap_freq'], '0.1'), 
					'gsitemap_priority' => varset($data['gsitemap_priority'], 'always'),  
					'gsitemap_cat'      => $sitemap_type,
					'gsitemap_order'    => '0',
					'gsitemap_img'      => '',
					'gsitemap_active'   => '1',
				);

				$result =  e107::getDb()->insert("gsitemap", $insert, true);
 
			}
		}
 
	 
	}
}

/**
 * Class gsitemap_admin_form.
 */
class gsitemap_admin_form extends e_form
{
	protected $freq_list = array();
	protected $priority_list = array();
	
	function x_gsitemap_gsitemap($curval, $mode, $att)
	{

		$this->freq_list = array
		(
			"always"	=>	GSLAN_11,
			"hourly"	=>	GSLAN_12,
			"daily"		=>	GSLAN_13,
			"weekly"	=>	GSLAN_14,
			"monthly"	=>	GSLAN_15,
			"yearly"	=>	GSLAN_16,
			"never"		=>	LAN_NEVER
		);


		for ($i=0.1; $i<1.0; $i=$i+0.1) 
		{
			$this->priority_list[number_format($i,1)] = number_format($i,1);
		}
		
		/*** Common for all plugins ***/
		$table = $att['table'];
		$id = $att['id'];
 
		if(empty($table)) { return ''; } 

		$where = "WHERE gsitemap_table='{$table}' AND gsitemap_table_id=" . $id;
 
		$actualValue = false;
		//default values
		$gsitemap = array();
		$gsitemap['gsitemap_url'] = '';

		/* set correct values value */
		if ($gsitemap = e107::getDb()->retrieve("gsitemap", "*", $where)) 
		{
		
			$actualValue   = true;
	 
		}
 
 
		if($mode == 'read') {
			 
			return $defaultValue;
		}
		elseif($mode == 'write') {
 
			$writeParms = array(
				'size'=>'xxlarge', 
				'placeholder'=>'',
				'default'=>$actualValue,
			);

			$text = "<div class='tab-pane'><table class='table adminform'><tbody>
			 ";

			$options = array('type' => 'boolean',   'writeParms' => $writeParms );

			$text .= "<tr>
			 <td class='text-left' style='width:25%'>In Sitemap</td>
			 <td>".$this->renderValue('gsitemap_include', $actualValue, $options)."</td>
			 </tr>";
 
			$writeParms = array('size'=>'xxlarge','placeholder'=>'',);
			$options = array('type' => 'url', 'title'=> 'ss',  'label'=> 'ss', 'writeParms' => $writeParms );

			$text .= "<tr>
			<td class='text-left' style='width:25%'>Actual Sitemap URL: </td>
			<td>".$this->renderValue('gsitemap_url', $gsitemap['gsitemap_url'], $options)."</td>
			</tr>";
 
			if($actualValue) {

				$writeParms = array('default'=>!$actualValue, 'help'=> "In Sitemap has to be off");
				$options = array('type' => 'boolean',   'writeParms' => $writeParms,  );

				$text .= "<tr>
				<td class='text-left' style='width:25%'>Delete from sitemap?  </td>
				<td>".$this->renderElement('gsitemap_delete', !$actualValue , $options)."</td>
				</tr>";

				$writeParms = array('default'=>!$actualValue, 'help'=> "Update gsitemap url when saving this record");
				$options = array('type' => 'boolean',   'writeParms' => $writeParms,  );

				$text .= "<tr>
				<td class='text-left' style='width:25%'>Update sitemap URL? </td>
				<td>".$this->renderElement('gsitemap_update', !$actualValue , $options)."</td>
				</tr>";
			}
			else {

				$writeParms = array('default'=>false, 'help'=> "Generate new record in Sitemap");
				$options = array('type' => 'boolean',   'writeParms' => $writeParms,  );

				$text .= "<tr>
				<td class='text-left' style='width:25%'>Add to sitemap? </td>
				<td>".$this->renderElement('gsitemap_create', false, $options)."</td>
				</tr>";

				$writeParms = array('optArray'=>$this->priority_list, 'help'=> "Generate new record in Sitemap");
				$options = array('type' => 'dropdown',   'writeParms' => $writeParms,  );

				$text .= "<tr>
				<td class='text-left' style='width:25%'>".GSLAN_9."'</td>
				<td>".$this->renderElement('gsitemap_priority', false, $options)."</td>
				</tr>";

				$writeParms = array('optArray'=>$this->freq_list, 'help'=> "");
				$options = array('type' => 'dropdown',   'writeParms' => $writeParms,  );

				$text .= "<tr>
				<td class='text-left' style='width:25%'>".GSLAN_10."'</td>
				<td>".$this->renderElement('gsitemap_freq', false, $options)."</td>
				</tr>";
			}

			$text .= "</tbody></table></div>";
 
			return $text;
		}

	}
 

}