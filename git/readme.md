Installation serveur Mimir et environnement de test
==
#### Installation du systeme (Fait sur Raspbian jessie lite 2016 05 10) 
	sudo raspi-config 
		Expand SD card 
		Internationalisation 
		HostName Mimir 

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
	ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp,/usr/bin/apt update 
	sudo deluser --remove-home pi 
	sudo passwd 
	
#### Installation des packages 
	sudo apt install git 
	sudo apt install apache2 
	sudo chown -R www-data:"utilisateur" /var/www 
	sudo chmod -R 770 /var/www/html 
	sudo apt install php5 
	sudo apt install mysql-server php5-mysql 
	sudo apt install phpmyadmin 

#### Creation Key SSH 
	ssh-keygen -t rsa -b 4096 -C "adresse_mail" 
	cd ~/.ssh 
	eval `ssh-agent -s` 
	eval `ssh-agent -c` 
	ssh-add id_rsa 
	more id_rsa.pub 
		copier/collé dans gitHub 

#### Mise en place des gits 
	création des git (un par un) 
	sudo git remote add deploy ssh://user@monserveur.fr/home/user/MonProjet 
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

#### mise en place des Cron	
	crontab -e 
	1 7 * * * php /var/www/html/daily.php >/dev/null 2>&1 
