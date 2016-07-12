Installation Odin (serveur principal)
==
#### Installation du systeme (Fait sur Raspbian jessie lite 2016 05 10) 
	sudo raspi-config 
		Expand SD card 
		Internationalisation 
		HostName Odin 

#### Configuration reseau
	sudo nano /etc/network/interfaces 
		auto lo 
		iface lo inet loopback 
		iface eth0 inet dhcp 
		allow-hotplug wlan0 
		auto wlan0 
		iface wlan0 inet dhcp 
		wpa-ssid "" 
		wpa-psk "" 
		up route add -host 192.168.1.15 dev wlan0 
		up route add -host 192.168.1.21 dev wlan0 
		up route add -host 192.168.1.26 dev wlan0 
	sudo nano /etc/sysctl.conf 
		net.ipv4.ip_forward=1 

#### Securisation de connexion
	sudo adduser belkeen 
	sudo visudo 
	Ajouter "utilisateur" ALL=(ALL) NOPASSWD: ALL 
	logout 
	login avec "utilisateur" 
	sudo visudo 
	retirer la ligne pi ALL=(ALL) NOPASSWD: ALL 
	ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp 
	sudo deluser --remove-home pi 
	sudo passwd 
	
#### Mise à jour du systeme
	sudo apt updade 
	sudo apt upgrade 
	
#### Installation des packages
	sudo apt install apache2 
	sudo apt install php5 
	sudo apt install mysql-server php5-mysql 
	sudo apt install phpmyadmin 
	sudo apt install git 
	sudo apt install php5-imagick 

#### Preparation des dossiers
	sudo nano /etc/php5/apache2/php.ini 
	ajouter extension=imagick.so 
	sudo chown -R www-data:"Utilisateur" /var/www/html/ 
	sudo chmod -R 770 /var/www/html 
	sudo reboot 

#### Mise en place du git de déploiement
	mkdir /home/"utilisateur"/brain.git/ 
	cd /home/"utilisateur"/brain.git/ 
	git init 
	git config receive.denyCurrentBranch ignore 
	Faire un push du coté de GIT 
	git clone /home/"utilisateur"/brain.git /var/www/html 
	git remote add GIT ssh://user@monserveur/var/www/brain
	sudo nano /home/belkeen/brain.git/.git/hooks/post-update 
	#!/bin/bash 
	echo "********** mise en production *********" 
	cd /var/www/html 
	unset GIT_DIR 
	git pull origin master 
	sudo chmod +x /home/belkeen/brain/.git/hooks/post-update 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 
	
#### Mise en place des crontab
	crontab -e 
	*/15 * * * * php /var/www/html/script/check_DHT.php > /var/www/html/script/log_DHT.txt 