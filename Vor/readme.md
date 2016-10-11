Installation Vor (serveur SQL)
==
#### Installation du systeme (Fait sur Raspbian jessie lite 2016 05 10) 
	sudo raspi-config 
		Expand SD card 
		Internationalisation 
		HostName Vor 

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
	sudo apt install mysql-server php5-mysql 
	sudo apt install phpmyadmin 
	sudo apt install git 

#### Preparation des dossiers
	sudo nano /etc/php5/apache2/php.ini 
	ajouter extension=imagick.so 
	sudo chown -R www-data:"Utilisateur" /var/www/html/ 
	sudo chmod -R 770 /var/www/html 
	sudo reboot 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 
	
#### Mise en place des crontab
	crontab -e 
	1 7 * * * php /var/www/html/daily.php >/dev/null 2>&1 
	
#### Configuration MySQL
	mysql -u root -p 
	CREATE DATABASE ASGARD; 
	CREATE DATABASE ASGARDTEST; 
	GRANT ALL PRIVILEGES ON ASGARD.* TO asgard@'%' IDENTIFIED BY 'mot_de_passe'; 
	GRANT ALL PRIVILEGES ON ASGARDTEST.* TO asgard@'%' IDENTIFIED BY 'mot_de_passe'; 
	flush privileges; 
	exit 
	sudo nano /etc/mysql/my.cnf 
	changer bind-address = 127.0.0.1 par #bind-address = 127.0.0.1 
	sauvegarder les modifications 
	sudo /etc/init.d/mysql restart 