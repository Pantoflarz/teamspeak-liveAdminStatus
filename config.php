<?php
/**
*
*	Plik Konfiguracyjny do Aplikacji Admin Live Status (na potrzeby MPC Forum)
*
* 	Data Ostatniej Edycji: 09.12.2016r. - v1.0
*	Autor: @Pantoflarz (https://tsforum.pl/uzytkownik/444-pantoflarz/)
*
*	Aktualizacja headerów: 12.05.2018r.
*
**/

$config = array();

$config['system'] = array(
	
	'teamspeak' => array(
	
		/*
		
			Konfiguracja łączenia z Serwerem.
			
			przykład:
			
		'serverIP' => 'localhost',
		'serverQueryPort' => 10011,
		'serverVoicePort' => 9987,
		'serverQueryLogin' => 'serveradmin',
		'serverQueryPassword' => 'ftyhtrf',			
			
		*/
			
		'serverIP' => 'localhost',
		'serverQueryPort' => 10011,
		'serverVoicePort' => 9987,
		'serverQueryLogin' => 'serveradmin',
		'serverQueryPassword' => '',			
		
		'instanceName' => 'PantoBOT @Pracuś',
		
		/* Kanał na którym BOT ma przebywać */
		'instanceChannel' => 266,
		
		/* Co ile sekund Status ma być sprawdzany */
		'howOftenToRun' => 30,	
		
		/* PUSTY CONFIG
		
			'1' => 
			
			Liczba 1 musi być zmieniana po kolei przy dodawanych osobach do statusu - inaczej BOT nie będzie mógł pobrać poprawnej konfiguracji.
			
		*/
		
		/*
				'1' => array(
					'client_database_id' => ,
					'channel' => ,
					'statusFormat' => '[GROUPNAME] : [NICKNAME] - [STATUS]',
					'text' => array(
						'onlineText' => 'Dostępny',
						'afkText' => 'AFK',
						'offlineText' => 'Niedostępny',
					),
				),
		*/
		
		/* Konfiguracja Statusu */		
		
		'adminsOnChannelsStatus' => array(
		
			'adminGroups' => array(10,15,21,25,29,32), /* Wszystkie Grupy Adminowskie */
			'idleTimeToAFK' => 10, 	/* Czas w minutach, po którym uznajemy że osoba jest AFK */
			
			'configuration' => array(
			
				'1' => array(
					'client_database_id' => , /* DBID osoby */
					'channel' => , /* Kanał który mamy dla tej osoby edytować */
					'statusFormat' => '[GROUPNAME] : [NICKNAME] - [STATUS]', /* Format nazwy kanału - dostępne to [GROUPNAME], [NICKNAME] oraz [STATUS] */
					'text' => array( /* Teksty to wyświetlania */
						'onlineText' => 'Dostępny',
						'afkText' => 'AFK',
						'offlineText' => 'Niedostępny',
					),
				),
				
			),
		),
		
	
	),
);

?>
