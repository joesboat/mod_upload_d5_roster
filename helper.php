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

class modUpload_D5_RosterHelper
{
//******************************************************************
static function import($fh,$everything){
	$vhqab = JoeFactory::getLibrary("USPSd5tableVHQAB"); 
	$mbr = $vhqab->getD5MembersObject();
	$addr = $vhqab->getD5AddressesObject();
	$cnv=$vhqab->getConvertObject();
	// $file_name is array passed by $_POST[] from file upload
	// $type specifies type of file being uploaded:
	//		"membership" - format for files provide by membership committee
	//		"db2000" - format for files exported from USPS DB2000 database
	// open database change log.
	$log_file_name = date("Ym")."_db_change_log.csv";
	$db_log =  write_log($log_file_name);
	$current_list = array();
	$line = fgets($fh) ;
	$mbr->convert = $cnv->build_convert_table($line,"db2k","d5_members");
	//write_log_array($mbr->convert);
	$mbr->certificate_column = $mbr->get_certificate_column($line);
	while ($line = fgets($fh)){
		if ($line == "") continue;
		//  convert the comma seperated line to an array 
		$ln = buildArrayFromCSV($line);	
		//  We must selectively add records 
		//  Open a connection to member table and obtain mbr record 
		$current_list[] = $certificate = $ln[$mbr->certificate_column];
		$rowin = $mbr->build_mbr_content($mbr->convert, $ln, true);	// Convert index from # to name
		$rowin['squad_no'] = sprintf("%04d",$rowin['squad_no']);
		$mbr->add_or_update($rowin);
		$addr->add_or_update_address($rowin);
		// return $certificate;
	}
	if ($everything){
		$mbr->process_deleted_records($current_list);
	}
	return true;
} // end of import - Loads new records from .csv file  
} // end of class 
//*********************************************************
function buildArrayFromCSV($ln){
	$ln = str_replace('""','"',$ln);
	$ary = array();
	$i = 0;
	while (strlen($ln) > 0){
		$len = strlen($ln);
		if ($i == 130){
			$ary = array();
			$ary[130]= 'xx';
		}
		switch (substr($ln,0,1)){
			case '"':
				$j = strpos($ln,'"',1)-1;
				switch (strtolower(substr($ln,1,$j))){
					case 'false':
						$ln_ary[$i] = 0;
						break;
					case 'true':
						$ln_ary[$i] = 1;
						break;
					default:
						$ln_ary[$i] = substr($ln,1,$j);	
				}				
				//$ln_ary[$i] = substr($ln,1,$j);
				$ln = substr($ln, $j+3, strlen($ln)-$j+3) ;
				$i ++;
				break;
			case ',':
				$ln_ary[$i] = "";
				$ln = substr($ln,1,strlen($ln)-1);
				$i ++;
				break;
			default:
				// it's a number so lets add it '
				$j = strpos($ln,',',1);
				switch (strtolower(substr($ln,0,$j))){
					case 'false':
						$ln_ary[$i] = 0;
						break;
					case 'true':
						$ln_ary[$i] = 1;
						break;
					default:
						$ln_ary[$i] = substr($ln,0,$j);	
				}
				$ln = substr($ln, $j+1, strlen($ln)-$j+1) ;
				$i ++;				
				break;
				// can't happen 					
		}
	}
	return $ln_ary;
}


