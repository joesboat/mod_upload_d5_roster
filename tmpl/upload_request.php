<?php
/**
* @package Author
* @author Joseph P. Gibson
* @website www.joesboat.org
* @email joe@joesboat.org
* @copyright (C) 2018 Joseph P. Gibson. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
**/

// no direct access
defined('_JEXEC') or die('Restricted access');
	showHeader('Import DB2000 Data',$me,'','');
?>

<p>Uploads a current USPS DB2000 generated roster file and initiates the merger of member records with the on-line roster.  The roster file must include all available DB2000 Columns.</p>

<p>A normal merge will add member records to the on-line roster and replace selected data fields with DB2000 data. A report of new and changed records will be created in the system log.  Please take care!  Due to time delays recent changes a member has made to the on-line roster could be overwritten with old data.</p>

<p>A "Full Synchronize" option <input type="checkbox" name='full_update'/> can be used to replace all member records and delete any member records not found in DB2000.  Changes and deletions will be recorded in system log.</p>

<p>Provide the DB2000 Export File Name: 
<input type='file' name='filename' size='80' value='C:\Users\Joe\Documents\My Data Sources\20110522 - D5 Roster.csv' /> 
or select Browse to find the file.  Then proceed by selecting 

<input type='submit' name='command' value='Upload' />.</p>

<?php
	showTrailer(TRUE);
