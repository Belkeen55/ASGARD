Installation du dashboard
==
#### Installation du systeme (Fait sur Raspbian jessie 2017 07 05)
        sudo raspi-config 
                Internationalisation 
                HostName dashboard 
		Changer le mdp de l'utilisateur pi 

#### Securisation de connexion
        sudo adduser "utilisateur" 
        sudo visudo 
        Ajouter "utilisateur" ALL=(ALL) NOPASSWD: ALL 
        logout 
        login avec "utilisateur" 
        sudo visudo 
        ajouter la ligne www-data ALL=(ALL) NOPASSWD:/opt/vc/bin/vcgencmd measure_temp,/usr/bin/apt update 
        sudo passwd 

#### Mise à jour du systeme
        sudo apt update 
        sudo apt upgrade 

#### Installation des packages
        sudo apt install apache2 
        sudo apt install php5 
        sudo apt install git 
		sudo apt install xfce4-power-manager 

#### Preparation des dossiers
        sudo nano /etc/php5/apache2/php.ini 
        sudo chown -R www-data:"Utilisateur" /var/www/html/ 
        sudo chmod -R 770 /var/www/html 
        sudo reboot 

#### Mise en place du git de déploiement
        mkdir /home/belkeen/asgard.git 
        git init 
        git config receive.denyCurrentBranch ignore 
        faire un push de test-pi3 
        git clone /home/belkeen/asgard.git /var/www/html 
        sudo nano /home/belkeen/asgard.git/.git/hooks/post-update 
        coller 
	        #!/bin/bash 
			echo "********** mise en production *********" 
			cd /var/www/html 
			unset GIT_DIR 
			git pull origin master 
		sudo chmod +x /home/belkeen/asgard.git/.git/hooks/post-update 

#### Mise en place du git de déploiement
        cd /var/www/html/ 
        git init 
        sudo git remote add hub git@github.com:Belkeen55/"deposit".git 

#### Installation outils de clonage
        git clone https://github.com/billw2/rpi-clone.git 
        cd rpi-clone 
        sudo cp rpi-clone /usr/local/sbin 
        sudo blkid 

#### Desactiver la mise en veille
		Aller dans le menu > Preference > Gestion de l'alimentation 

#### Mise en place des crontab
	crontab -e 
	0 1 * * * php /var/www/html/dashboard/daily.php >/dev/null 2>&1 
