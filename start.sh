
cd "$(dirname "$0")"
if [ $1 = 'stop' ] 
    then
	
	echo ":: Zamykam TeamSpeak 3 - Admin Live Status by Pantoflarz";
	
	screen -S adminStatusBOT -X quit
	
	echo '
	Zatrzymano.
	';	
    fi

if [ $1 = 'start' ] 
    then 
	
echo "

	  :: Odpalam TeamSpeak 3 - Admin Live Status by Pantoflarz...

	  " 
	  

	screen -AdmS adminStatusBOT php core.php 
	
	echo '
	Wystartowano.
	';	

    fi