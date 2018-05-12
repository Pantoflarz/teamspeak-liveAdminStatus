<?php
date_default_timezone_set('Europe/Warsaw');
ini_set('default_charset', 'UTF-8');
setlocale(LC_ALL, 'UTF-8');
gc_enable();

include_once 'inc/functions.php';
include_once 'inc/ts3admin.class.php';
include_once 'config.php';

$systemConfig = $config['system']['teamspeak'];

$ts = new ts3admin($systemConfig['serverIP'], $systemConfig['serverQueryPort']);

if($ts->getElement('success', $ts->connect())){ 

	echo "".$systemConfig['instanceName']." pomyślnie połączył się z serwerem pod adresem ".$systemConfig['serverIP']." oraz portem query ".$systemConfig['serverQueryPort']."." . PHP_EOL;
	
	if($ts->getElement('success', $ts->login($systemConfig['serverQueryLogin'], $systemConfig['serverQueryPassword']))){
		
		echo "".$systemConfig['instanceName']." pomyślnie zalogował się przy użyciu konta ".$systemConfig['serverQueryLogin']."." . PHP_EOL;

		if($ts->getElement('success', $ts->selectServer($systemConfig['serverVoicePort']))){
			
			echo "".$systemConfig['instanceName']." pomyślnie wybrał Serwer na porcie ".$systemConfig['serverVoicePort']."." . PHP_EOL;
			
			echo "Konsola: " . PHP_EOL;
			
			$ts->setName($systemConfig['instanceName']);

			$core = $ts->getElement('data',$ts->whoAmI());

			$ts->clientMove($core['client_id'], $systemConfig['instanceChannel']);	
				
			while (1) {			
				
				$clients = $ts->getElement('data', $ts->clientList("-uid -away -voice -times -groups -info -country -icon -ip -badges"));
			
				foreach($systemConfig['adminsOnChannelsStatus']['configuration'] as $admin){
						
						unset($isAdminAFK);
						unset($adminOnline);
						unset($adminInfo);
						unset($clientAdminGroup);
					
						foreach($systemConfig['adminsOnChannelsStatus']['adminGroups'] as $group){
							
							$groupInfo = $ts->serverGroupClientList($group);
							
							foreach ($groupInfo['data'] as $groupInfo){
								foreach($clients as $value){
									if(array_key_exists('cldbid', $groupInfo)){
										if($admin['client_database_id'] == $groupInfo['cldbid']){
											$clientAdminGroup = getGroupName($group);
											break;
										}
									}
								}
							}
						}
						
						foreach ($clients as $potentialAdmin){
							if ($potentialAdmin['client_database_id'] == $admin['client_database_id']){
								$adminInfo = $potentialAdmin;
								$adminOnline = true;
								break;
							}else{
								$adminOnline = false;
							}
						}
						
						if($adminOnline == true){
							$isAdminAFK = false;
							if (($adminInfo['client_idle_time'] >= ($systemConfig['adminsOnChannelsStatus']['idleTimeToAFK']*60000)) or ($adminInfo['client_output_muted'] == 1) or ($adminInfo['client_away'] == 1)){
								$isAdminAFK = true;
							}
						}
						
						$adminDbInfo = $ts->getElement('data', $ts->clientDbInfo($admin['client_database_id']));
						
						if ($adminOnline == true && $isAdminAFK == true){
							
							$channelName = str_replace(array('[GROUPNAME]', '[NICKNAME]', '[STATUS]'), array($clientAdminGroup , $adminDbInfo['client_nickname'], $admin['text']['afkText']), $admin['statusFormat']);
							
						}
						
						if ($adminOnline == true && $isAdminAFK == false){
							
							$channelName = str_replace(array('[GROUPNAME]', '[NICKNAME]', '[STATUS]'), array($clientAdminGroup , $adminDbInfo['client_nickname'], $admin['text']['onlineText']), $admin['statusFormat']);
		
						}
						
						if ($adminOnline == false){
							
							$channelName = str_replace(array('[GROUPNAME]', '[NICKNAME]', '[STATUS]'), array($clientAdminGroup , $adminDbInfo['client_nickname'], $admin['text']['offlineText']), $admin['statusFormat']);
						}
						
						$ts->channelEdit($admin['channel'], array(
							'channel_name' => $channelName,
							)
						);

					}
				
				sleep($systemConfig['howOftenToRun']);
			}
		
		}else{
			
			echo "\e[0;31m".$systemConfig['instanceName']." nie mógł wybrać Serwera na porcie ".$systemConfig['serverVoicePort'].".\e[0m". PHP_EOL;
			echo "\e[0;31mSzczegóły: \e[0m". PHP_EOL;
			
			arrayErrorsSeparate($ts->getElement('errors', $ts->selectServer($systemConfig['serverVoicePort'])));
		
		}						
	
	}else{
		
		echo "\e[0;31m".$systemConfig['instanceName']." nie mógł się zalogować używając konta ".$systemConfig['serverQueryLogin'].".\e[0m". PHP_EOL;
		echo "\e[0;31mSzczegóły: \e[0m". PHP_EOL;
		
		arrayErrorsSeparate($ts->getElement('errors', $ts->login($systemConfig['serverQueryLogin'], $systemConfig['serverQueryPassword'])));
		
	}
}else{
	
	echo "\e[0;31m".$systemConfig['instanceName']." nie mógł połączyć się z serwerem pod adresem ".$systemConfig['serverIP']." wraz z portem query ".$systemConfig['serverQueryPort'].".\e[0m". PHP_EOL;
	echo "\e[0;31mSzczegóły: \e[0m". PHP_EOL;
	
	arrayErrorsSeparate($ts->getElement('errors', $ts->connect()));

}


?>