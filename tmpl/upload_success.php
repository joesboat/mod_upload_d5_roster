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
<p>
	The file <?php echo $name;?> has been uploaded to the D5_Members table.  
</p>

<?php
	showTrailer(TRUE);
