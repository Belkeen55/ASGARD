Installation du serveur principal
==
#### Installation du systeme (Fait sur Raspbian jessie lite 2017 07 05) 
	sudo raspi-config 
		Internationalisation 
		HostName zacharie 

#### Configuration reseau
	sudo nano /etc/network/interfaces 
		allow-hotplug wlan0 
		auto wlan0 
		iface wlan0 inet dhcp 
		wpa-ssid "" 
		wpa-psk "" 

#### Securisation de connexion
	sudo adduser "utilisateur" 
	sudo visudo 
	Ajouter "utilisateur" ALL=(ALL) NOPASSWD: ALL 
	ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp,/usr/bin/apt update,/home/belkeen/Adafruit_Python_DHT/examples/./AdafruitDHT.py 
	logout 
	login avec "utilisateur" 
	sudo deluser --remove-home pi 
	sudo passwd 
	
#### Mise à jour du systeme
	sudo apt update 
	sudo apt upgrade 
	
#### Installation des packages
	sudo apt install apache2 
	sudo apt install php5 
	sudo apt install git 
	sudo apt-get install python-dev 

#### Preparation des dossiers
	sudo chown -R www-data:"Utilisateur" /var/www/html/ 
	sudo chmod -R 770 /var/www/html 
	sudo reboot 

#### Mise en place du git de déploiement
        mkdir /home/belkeen/asgard.git 
        git init 
        git config receive.denyCurrentBranch ignore 
        faire un push de test-pi3 
        sudo rm -r /var/www/html/ 
        sudo git clone /home/belkeen/asgard.git /var/www/html 
        sudo chown -R www-data:"Utilisateur" /var/www/html/ 
		sudo chmod -R 770 /var/www/html 
        sudo nano /home/belkeen/asgard.git/.git/hooks/post-update 
        coller 
	        #!/bin/bash 
			echo "********** mise en production *********" 
			cd /var/www/html 
			unset GIT_DIR 
			git pull origin master 
		sudo chmod +x /home/belkeen/asgard.git/.git/hooks/post-update 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 
	
#### Installation driver/soft DHT 22
	git clone https://github.com/adafruit/Adafruit_Python_DHT.git 
	cd Adafruit_Python_DHT 
	sudo python setup.py install 
	cd examples 
	sudo ./AdafruitDHT.py 22 17 
	17 étant le GPIO de données 
	
#### Mise en place des crontab
	crontab -e 
	0 1 * * * php /var/www/html/script/daily.php >/dev/null 2>&1 
