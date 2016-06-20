Installation station meteo sur écran
==
#### Installation du systeme (Fait sur Raspbian jessie 2016 05 10) 
	sudo raspi-config 
		Expand SD card 
		Internationalisation 
		HostName meteo
		Changement MdP pour User "Pi"

#### Mise à jour du systeme 
	sudo apt update 
	sudo apt upgrade 
	
#### Securisation de connexion 
	sudo visudo 
	ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp 
	sudo passwd 

#### Installation des packages 
	sudo apt install git 
	sudo apt install apache2 
	sudo chown -R www-data:"utilisateur" /var/www/html/ 
	sudo chmod -R 770 /var/www/html 
	sudo apt install php5 
	sudo apt install mysql-server php5-mysql 
	sudo apt install phpmyadmin 
	sudo apt install unclutter 
	sudo apt install midori 
	
#### Boot automatique sur Midori en fullscreen
	sudo nano /home/pi/.config/lxsession/LXDE-pi/autostart 
	#@lxpanel --profile LXDE-pi 
	#@pcmanfm --desktop --profile LXDE-pi 
	#@xscreensaver -no-splash 
	@xset -dpms 
	@xset s off 
	@midori -e Fullscreen -a "Adresse_URL" 
	nano .xinitrx
	#!/bin/sh 
	# Cache le curseur de la souris au bout de 1 seconde 
	unclutter -idle 1 

#### mise en place du GIT de déploiement
	cd /home/pi 
	mkdir meteo.git 
	cd meteo.git 
	git init 
	git config receive.denyCurrentBranch ignore 
	git remote add GIT ssh://user@monserveur.fr/var/www/meteo 
	sudo nano /home/pi/meteo.git/.git/hooks/post-update 
	#!/bin/bash 
	echo "********** mise en production *********" 
	cd /var/www/html 
	unset GIT_DIR 
	git pull GIT master 
	chmod +x /home/user/MonProjet.git/hooks/post-update 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 