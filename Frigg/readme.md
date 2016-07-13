Installation Frigg (serveur Visio)
==
#### Installation du systeme (Fait sur Raspbian jessie lite 2016 05 10) 
	sudo raspi-config 
		Expand SD card 
		Internationalisation 
		Enable Camera 
		HostName Frigg 

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

#### Securisation de connexion
	sudo adduser belkeen 
	sudo visudo 
	Ajouter "utilisateur" ALL=(ALL) NOPASSWD: ALL 
	logout 
	login avec "utilisateur" 
	sudo visudo 
	retirer la ligne pi ALL=(ALL) NOPASSWD: ALL 
	ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp,/usr/bin/apt update 
	sudo deluser --remove-home pi 
	sudo passwd 
	
#### Mise à jour du systeme
	sudo apt updade 
	sudo apt upgrade 
	
#### Installation des packages
	sudo apt install apache2 
	sudo apt install php5 
	sudo apt install git 

#### Preparation des dossiers
	sudo chown -R www-data:"Utilisateur" /var/www/html/ 
	sudo chmod -R 770 /var/www/html 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 