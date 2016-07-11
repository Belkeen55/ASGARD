Installation station meteo sur écran
==
#### Installation du systeme (Fait sur Raspbian jessie PiTFT 2016 05 10) 
	sudo raspi-config 
		Expand SD card 
		Internationalisation 
		HostName Fimafeng
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
	@xset -dpms 
	@xset s off 
	@midori -e Fullscreen -a "Adresse_URL" 
	nano .xinitrx
	#!/bin/sh 
	# Cache le curseur de la souris au bout de 1 seconde 
	unclutter -idle 1 
	sudo nano /etc/lightdm/lightdm.conf 
	Rechercher le block [SeatDefaults] 
	mettre cette ligne : xserver-command=X -s 0 dpms 
	
#### Extinction et reboot pour la nuit
	sudo crontab -e 
	0 1 * * * /opt/vc/bin/tvservice -o >/dev/null 2>&1 
	0 6   *   *   *    /sbin/shutdown -r now 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 