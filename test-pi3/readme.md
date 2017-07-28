Installation serveur test-pi3
==
#### Installation du systeme (Fait sur Raspbian jessie lite 2016 05 10) 
	sudo raspi-config 
		Expand SD card 
		Internationalisation 
		HostName test-pi3 

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
	ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp,/usr/bin/apt update 
	sudo deluser --remove-home pi 
	sudo passwd 
	
#### Installation des packages 
	sudo apt install git 
	sudo apt install apache2 
	sudo apt install php5 
	sudo apt install php5-mysql 
	sudo apt install php5-imagick 
	sudo apt install php5-gd 

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
	faire un pull de github 
	sudo git clone https://github.com/Codiad/Codiad /var/www/html/ 
	sudo touch /var/www/nouveau_dossier/config.php 
	sudo nano /etc/php5/apache2/php.ini 
	ajouter extension=imagick.so 
	sudo chown www-data:www-data -R /var/www/html/ 
	sudo chown -R www-data:"utilisateur" /var/www/html 
	sudo chmod -R 770 /var/www/html 
	sudo git remote add hub git@github.com:Belkeen55/"deposit".git 
	git remote set-url --add --push origin git@github.com:Belkeen55/"deposit".git 
	git remote set-url --add --push origin ssh://belkeen@raspberry/home/belkeen/asgard.git 

#### Configuration réseau
	allow-hotplug wlan0 
	auto wlan0 
	iface wlan0 inet dhcp 
	wpa-ssid "" 
	wpa-psk "" 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 

#### mise en place des Cron	
	crontab -e 
	1 7 * * * php /var/www/html/daily.php >/dev/null 2>&1 
