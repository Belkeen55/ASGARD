#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Pieces
#------------------------------------------------------------

CREATE TABLE Pieces(
        Id      int (11) Auto_increment  NOT NULL ,
        Nom     Varchar (255) ,
        T_ideal Decimal (25,2) ,
        H_ideal Decimal (25,2) ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Mesures
#------------------------------------------------------------

CREATE TABLE Mesures(
        Id          int (11) Auto_increment  NOT NULL ,
        Heurodatage Datetime ,
        Tempint     Decimal (25,2) ,
        Tempext     Decimal (25,2) ,
        Radiateur   Decimal (25,2) ,
        Humidite    Decimal (25,2) ,
        Id_Pieces   Int ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Radiateurs
#------------------------------------------------------------

CREATE TABLE Radiateurs(
        Id        int (11) Auto_increment  NOT NULL ,
        Radiateur Decimal (25,2) NOT NULL ,
        Id_Pieces Int ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Equipements
#------------------------------------------------------------

CREATE TABLE Equipements(
        Id           int (11) Auto_increment  NOT NULL ,
        Nom          Varchar (25) NOT NULL ,
        Ip           Varchar (255) ,
        Commentaires Text ,
        Id_Pieces    Int ,
        Id_Typ_Equip Int NOT NULL ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Typ_Equip
#------------------------------------------------------------

CREATE TABLE Typ_Equip(
        Id    int (11) Auto_increment  NOT NULL ,
        Nom   Varchar (25) NOT NULL ,
        Image Varchar (255) ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Codes
#------------------------------------------------------------

CREATE TABLE Codes(
        Id          int (11) Auto_increment  NOT NULL ,
        Fonction    Varchar (255) ,
        Commentaire Varchar (255) ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Logs
#------------------------------------------------------------

CREATE TABLE Logs(
        Id          int (11) Auto_increment  NOT NULL ,
        Heurodatage Datetime NOT NULL ,
        Client      Varchar (255) ,
        Id_Codes    Int NOT NULL ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Meteo
#------------------------------------------------------------

CREATE TABLE Meteo(
        Id          Int NOT NULL ,
        Heurodatage Datetime NOT NULL ,
        Code        Varchar (255) ,
        Temperature Decimal (25,2) ,
        Humidite    Decimal (25,2) ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Utilisateurs
#------------------------------------------------------------

CREATE TABLE Utilisateurs(
        Id       int (11) Auto_increment  NOT NULL ,
        Login    Varchar (255) ,
        Password Varchar (255) ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Taches
#------------------------------------------------------------

CREATE TABLE Taches(
        Id           int (11) Auto_increment  NOT NULL ,
        Heurodatage  Datetime NOT NULL ,
        Titre        Varchar (255) ,
        Commentaires Text ,
        Deploiement  Datetime ,
        Id_Devs      Int NOT NULL ,
        Id_Etapes    Int NOT NULL ,
        Id_Modules   Int NOT NULL ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Devs
#------------------------------------------------------------

CREATE TABLE Devs(
        Id  int (11) Auto_increment  NOT NULL ,
        Nom Varchar (255) NOT NULL ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Etapes
#------------------------------------------------------------

CREATE TABLE Etapes(
        Id  Int NOT NULL ,
        Nom Varchar (255) NOT NULL ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Modules
#------------------------------------------------------------

CREATE TABLE Modules(
        Id  int (11) Auto_increment  NOT NULL ,
        Nom Varchar (255) ,
        PRIMARY KEY (Id )
)ENGINE=InnoDB;

ALTER TABLE Mesures ADD CONSTRAINT FK_Mesures_Id_Pieces FOREIGN KEY (Id_Pieces) REFERENCES Pieces(Id);
ALTER TABLE Radiateurs ADD CONSTRAINT FK_Radiateurs_Id_Pieces FOREIGN KEY (Id_Pieces) REFERENCES Pieces(Id);
ALTER TABLE Equipements ADD CONSTRAINT FK_Equipements_Id_Pieces FOREIGN KEY (Id_Pieces) REFERENCES Pieces(Id);
ALTER TABLE Equipements ADD CONSTRAINT FK_Equipements_Id_Typ_Equip FOREIGN KEY (Id_Typ_Equip) REFERENCES Typ_Equip(Id);
ALTER TABLE Logs ADD CONSTRAINT FK_Logs_Id_Codes FOREIGN KEY (Id_Codes) REFERENCES Codes(Id);
ALTER TABLE Taches ADD CONSTRAINT FK_Taches_Id_Devs FOREIGN KEY (Id_Devs) REFERENCES Devs(Id);
ALTER TABLE Taches ADD CONSTRAINT FK_Taches_Id_Etapes FOREIGN KEY (Id_Etapes) REFERENCES Etapes(Id);
ALTER TABLE Taches ADD CONSTRAINT FK_Taches_Id_Modules FOREIGN KEY (Id_Modules) REFERENCES Modules(Id);
