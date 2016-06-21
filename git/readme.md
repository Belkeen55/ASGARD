Installation serveur GIT et environnement de test
==
#### Installation du systeme (Fait sur Raspbian jessie lite 2016 05 10) 
	sudo raspi-config 
		Expand SD card 
		Internationalisation 
		HostName GIT 

#### Mise à jour du systeme 
	sudo apt update 
	sudo apt upgrade 

#### Securisation de connexion 
	sudo adduser "utilisatteur" 
	sudo visudo 
	Ajouter "Utilisateur" ALL=(ALL) NOPASSWD: ALL 
	logout 
	login avec "Utilisateur" 
	sudo visudo 
	retirer la ligne pi ALL=(ALL) NOPASSWD: ALL 
	ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp 
	sudo deluser --remove-home pi 
	sudo passwd 
	
#### Installation des packages 
	sudo apt install git 
	sudo apt install apache2 
	Créer un dossier par futur GIT dans /var/www 
	Créer un fichier .conf par futur GIT dans /etc/apache2/sites-available/ 
	<VirtualHost *:"PORT_ECOUTE"> 
		ServerAdmin webmaster@localhost 
		DocumentRoot /var/www/"GIT_Deposit" 
		ServerName "GIT_Deposit" 
		ErrorLog ${APACHE_LOG_DIR}/error.log 
        CustomLog ${APACHE_LOG_DIR}/access.log combined 
	</VirtualHost> 
	Rajouter dans /etc/apache2/ports.conf les nouveaux ports utilisés 
	sudo chown -R www-data:"utilisateur" /var/www 
	sudo chmod -R 770 /var/www/html 
	sudo apt install php5 
	sudo apt install mysql-server php5-mysql 
	sudo apt install phpmyadmin 

#### Mise en place de la clé USB 
	sudo blkid 
	sudo nano /etc/fstab 
		UUID="resultat_blkid"  /media/usb1     vfat    umask=770         0       3 
	cd /etc/apache2/site-available 
	dir 
	sudo nano /etc/apache2/sites-available/"site_trouvé" 
	changer le documentRoot = /media/usb1 

#### Creation Key SSH 
	ssh-keygen -t rsa -b 4096 -C "adresse_mail" 
	cd ~/.ssh 
	ssh-add id_rsa 
	more id_rsa.pub 
		copier/collé dans gitHub 

#### Mise en place des gits 
	création des git (un par un) 
	sudo git remote add meteo ssh://user@monserveur.fr/home/user/MonProjet 
	sudo git remote add hub git@github.com:Belkeen55/"deposit".git 

#### Configuration réseau
	sudo nano /etc/network/interfaces 
	auto lo 
	iface lo inet loopback 
	auto eth0 
	iface eth0 inet dhcp 
        up route add -host 192.168.1.15 gw 192.168.1.16 
        up route add -host 192.168.1.21 gw 192.168.1.16 
	allow-hotplug wlan0 
	iface wlan0 inet manual 
		wpa-conf /etc/wpa_supplicant/wpa_supplicant.conf 
	allow-hotplug wlan1 
	iface wlan1 inet manual 
		wpa-conf /etc/wpa_supplicant/wpa_supplicant.conf 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 