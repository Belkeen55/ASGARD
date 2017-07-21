Installation serveur MySQL 
==
#### Installation du systeme (Fait sur Raspbian jessie lite 2016 05 10) 
	sudo raspi-config 
		Internationalisation 
		HostName mysql 

#### Securisation de connexion
	sudo adduser "utilisateur" 
	sudo visudo 
	Ajouter "utilisateur" ALL=(ALL) NOPASSWD: ALL 
	logout 
	login avec "utilisateur" 
	sudo visudo 
	ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp,/usr/bin/apt update 
	sudo deluser --remove-home pi 
	sudo passwd 
	
#### Mise à jour du systeme
	sudo apt update 
	sudo apt upgrade 
	
#### Installation des packages
	sudo apt install apache2 
	sudo apt install php5 
	sudo apt install mysql-server php5-mysql 
	sudo apt install phpmyadmin 
	sudo apt install git 

#### Preparation des dossiers
	sudo nano /etc/php5/apache2/php.ini 
	sudo chown -R www-data:"Utilisateur" /var/www/html/ 
	sudo chmod -R 770 /var/www/html 
	sudo reboot 

#### Preparation de la base SQL
        mysql -u root -p 
        GRANT ALL PRIVILEGES ON exemple.* TO user@'%' IDENTIFIED BY 'mot_de_passe'; 
        flush privileges; 
	exit 
	sudo nano /etc/mysql/my.cnf 
	#bind-address = 127.0.0.1 
	/etc/init.d/mysql restart 

#### Mise en place du git de déploiement
	cd /var/www/html/ 
	git init 
	sudo git remote add hub git@github.com:Belkeen55/"deposit".git 
	
#### Installation outils de clonage
	git clone https://github.com/billw2/rpi-clone.git 
	cd rpi-clone 
	sudo cp rpi-clone /usr/local/sbin 
	sudo blkid 
	sudo rpi-clone "sdX" 
	
#### Mise en place des crontab
	crontab -e 
	*/15 * * * * php /var/www/html/script/check_DHT.php > /var/www/html/script/log_DHT.txt 
	1 7 * * * php /var/www/html/daily.php >/dev/null 2>&1 