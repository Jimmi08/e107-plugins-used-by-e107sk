<?php
/*
* e107 website system
*
* Copyright (C) 2008-2013 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* Custom install/uninstall/update routines for jmcontactus plugin
**
*/


if(!class_exists("jmcontactus_setup"))
{
	class jmcontactus_setup
	{

	    function install_pre($var)
		{
			// print_a($var);
			// echo "custom install 'pre' function<br /><br />";
		}

		/**
		 * For inserting default database content during install after table has been created by the jmcontactus_sql.php file.
		 */
		function install_post($var)
		{
			$sql = e107::getDb();
			$mes = e107::getMessage();
			$options = array();
      $eplug_folder = "jmcontactus";
      
$eplug_tables = array(			
"INSERT INTO `".MPREFIX.strtolower($eplug_folder."_form")."` (	`id`,`name`,`req`,`type`,`vars`,`order`) 
VALUES ( NULL, 'Your Name', '1', 'text', 'a:2:{i:0;s:3:\"50%\";i:1;s:3:\"255\";}', 1);",
"INSERT INTO `".MPREFIX.strtolower($eplug_folder."_form")."` (	`id`,`name`,`req`,`type`,`vars`,`order`) 
VALUES ( NULL, 'Your Email', '1', 'email', 'a:2:{i:0;s:3:\"50%\";i:1;s:3:\"255\";}', 2);",
"INSERT INTO `".MPREFIX.strtolower($eplug_folder."_form")."` (	`id`,`name`,`req`,`type`,`vars`,`order`) 
VALUES ( NULL, 'Message Subject', '1', 'text', 'a:2:{i:0;s:3:\"50%\";i:1;s:3:\"255\";}', 4);",
"INSERT INTO `".MPREFIX.strtolower($eplug_folder."_form")."` (	`id`,`name`,`req`,`type`,`vars`,`order`) 
VALUES ( NULL, 'Your Message', '1', 'textarea', 'a:2:{i:0;s:2:\"25\";i:1;s:2:\"15\";}', 5);",
"INSERT INTO `".MPREFIX.strtolower($eplug_folder."_form")."` (	`id`,`name`,`req`,`type`,`vars`,`order`) 
VALUES ( NULL, 'Phone', '0', 'text', 'a:2:{i:0;s:3:\"50%\";i:1;s:3:\"255\";}', 3);",
); 

 foreach($eplug_tables AS $insert) {
   $sql->gen($insert);
  }
		}

 


		function uninstall_post($var)
		{
			// print_a($var);
		}


		/*
		 * Call During Upgrade Check. May be used to check for existance of tables etc and if not found return TRUE to call for an upgrade.
		 *
		 * @return bool true = upgrade required; false = upgrade not required
		 */
		function upgrade_required()
		{
			// Check if a specific table exists and if not, return true to force a db update
			// In this example, it checks if the table "jmcontactus_table" exists
//			if(!e107::getDb()->isTable('jmcontactus_table'))
//			{
//				return true;	 // true to trigger an upgrade alert, and false to not.
//			}


			// Check if a specific field exists in the specified table
			// and if not return false to force a db update to add this field
			// from the "jmcontactus_sql.php" file
			// In this case: Exists field "jmcontactus_id" in table "jmcontactus_table"
//			if(!e107::getDb()->field('jmcontactus_table','jmcontactus_id'))
//			{
//				return true;	 // true to trigger an upgrade alert, and false to not.
//			}


			// In case you need to delete a field that is not used anymore,
			// first check if the field exists, than run a sql command to drop (delete) the field
			// !!! ATTENTION !!!
			// !!! Deleting a field, deletes also the data stored in that field !!!
			// !!! Make sure you know what you are doing !!!
			//
			// In this example, the field "jmcontactus_unused_field" from table "jmcontactus_table"
			// isn't used anymore and will be deleted (dropped) if it still exists
//			if(e107::getDb()->field('jmcontactus_table', 'jmcontactus_unused_field'))
//			{
				// this statement directly deletes the field, an additional
				// db update isn't needed anymore, if this is the only change on the db/table.
//				e107::getDb()->gen("ALTER TABLE `#jmcontactus_table` DROP `jmcontactus_unused_field` ");
//			}


			// In case you need to delete a index that is not used anymore,
			// first check if the index exists, than run a sql command to drop (delete) the field
			// Be aware, that deleting an index is not very harmfull, as the data of the
			// index will be recreated when the index is added again.
//			if(e107::getDb()->index('jmcontactus_table','jmcontactus_unused_index'))
//			{
				// this statement directly deletes the index, an additional
				// db update isn't needed anymore, if this is the only change on the db/table.
//				e107::getDb()->gen("ALTER TABLE `#jmcontactus_table` DROP INDEX `jmcontactus_unused_index` ");
//			}

			// In case you need to check an index and which fields it is build of,
			// use the fourth parameter to return the index definition.
			// In this case, the index should be deleted if consists only of 1 field ("jmcontactus_fieldname"),
//			if(e107::getDb()->index('jmcontactus_table','jmcontactus_unused_index', array('jmcontactus_fieldname')))
//			{
				// this statement directly deletes the index, an additional
				// db update isn't needed anymore, if this is the only change on the db/table.
//				e107::getDb()->gen("ALTER TABLE `#jmcontactus_table` DROP INDEX `jmcontactus_unused_index` ");
//			}


			// In case you need to check an index and which fields it is build of,
			// use the third parameter to return the index definition.
			// In this case, the index should be deleted if consists only of 1 field ("jmcontactus_fieldname"),
//			if ($index_def = e107::getDb()->index('jmcontactus_table','jmcontactus_unused_index', array('jmcontactus_fieldname')))
//			{
				// Check if the key should be UNIQUE
//				$unique = array_count_values(array_column($index_def, 'Non_unique'));
//				if($unique[1] > 0) // Keys are not unique
//				{
					// this statement directly deletes the index, an additional
					// db update isn't needed anymore, if this is the only change on the db/table.
//					e107::getDb()->gen("ALTER TABLE `#jmcontactus_table` DROP INDEX `jmcontactus_unused_index` ");
//				}
//			}
 

			return false;
		}


		function upgrade_post($var)
		{
			// $sql = e107::getDb();
		}

	}

}