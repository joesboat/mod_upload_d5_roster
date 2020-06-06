<?php
/**
* @package Upload D5 Roster
* @author Joseph P. Gibson
* @website www.joesboat.org
* @email joe@joesboat.org
* @copyright (C) 2018 Joseph P. Gibson. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
jimport("usps/includes/routines");
jimport("usps/tableD5VHQAB");

require_once(dirname(__FILE__).'/helper.php');

$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB"); 
$me = JFactory::getApplication()->getMenu()->getActive()->alias;
$session = JFactory::getSession();
$user = JFactory::getUser();
$error = '';
$sqds = $vhqab->getSquadronObject();
$year = $vhqab->getSquadronDisplayYear('6243');
log_it("import_roster.php started. ");
if ($_FILES and ($_FILES['filename']['tmp_name']!='')){
	$name = $_FILES['filename']['name'];
	$n = $_FILES['filename']['tmp_name'];
	$fh = fopen($n, "r") or 
		die("Unable to open?????");
	log_it("Importing from DB2000 file - $name.");
	$ok = modUpload_D5_RosterHelper::import($fh,isset($_POST['full_update']));
	if ($ok){
		modUpload_D5_RosterHelper::update_last_update_notice();
		require(JModuleHelper::getLayoutPath('mod_upload_d5_roster','upload_success'));
	}
} else
	require(JModuleHelper::getLayoutPath('mod_upload_d5_roster','upload_request'));


?>



