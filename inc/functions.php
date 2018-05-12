<?php
function getGroupName($groupNeed){
	
	global $ts;
	
	$groups = $ts->getElement('data', $ts->serverGroupList());
	$groupname = '';
	
	foreach($groups as $group)
	{
		if ($group['sgid'] == $groupNeed)
		{
			$groupname = $group['name'];
			return $groupname;
		}
	}

}

function arrayErrorsSeparate($errorArray){
	
	foreach ($errorArray as $error){
		echo "		\e[0;31m".$error."\e[0m". PHP_EOL;
	}
	
}

?>