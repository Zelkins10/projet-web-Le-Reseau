#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: IMAC_Utilisateur
#------------------------------------------------------------

CREATE TABLE IMAC_Utilisateur(
        id            Int  Auto_increment  NOT NULL ,
        pseudo        Varchar (50) NOT NULL ,
        motDePasse    Varchar (50) NOT NULL ,
        prenom        Varchar (50) ,
        nom           Varchar (50) ,
        dateNaissance Date NOT NULL ,
        email         Varchar (50) NOT NULL ,
        photoProfil   Varchar (50) ,
        bio           Longtext
	,CONSTRAINT IMAC_Utilisateur_PK PRIMARY KEY (id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: IMAC_Publication
#------------------------------------------------------------

CREATE TABLE IMAC_Publication(
        id                  Int  Auto_increment  NOT NULL ,
        texte               Longtext ,
        image               Varchar (50) ,
        date                Date NOT NULL ,
        id_IMAC_Utilisateur Int NOT NULL
	,CONSTRAINT IMAC_Publication_PK PRIMARY KEY (id)

	,CONSTRAINT IMAC_Publication_IMAC_Utilisateur_FK FOREIGN KEY (id_IMAC_Utilisateur) REFERENCES IMAC_Utilisateur(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: IMAC_Commentaire
#------------------------------------------------------------

CREATE TABLE IMAC_Commentaire(
        id                  Int  Auto_increment  NOT NULL ,
        contenu             Longtext NOT NULL ,
        date                Date NOT NULL ,
        id_IMAC_Utilisateur Int NOT NULL ,
        id_IMAC_Publication Int NOT NULL
	,CONSTRAINT IMAC_Commentaire_PK PRIMARY KEY (id)

	,CONSTRAINT IMAC_Commentaire_IMAC_Utilisateur_FK FOREIGN KEY (id_IMAC_Utilisateur) REFERENCES IMAC_Utilisateur(id)
	,CONSTRAINT IMAC_Commentaire_IMAC_Publication0_FK FOREIGN KEY (id_IMAC_Publication) REFERENCES IMAC_Publication(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: IMAC_MessagePrive
#------------------------------------------------------------

CREATE TABLE IMAC_MessagePrive(
        id                           Int  Auto_increment  NOT NULL ,
        image                        Varchar (50) ,
        date                         Date NOT NULL ,
        texte                        Longtext ,
        id_IMAC_Utilisateur          Int NOT NULL ,
        id_IMAC_Utilisateur_Recevoir Int NOT NULL
	,CONSTRAINT IMAC_MessagePrive_PK PRIMARY KEY (id)

	,CONSTRAINT IMAC_MessagePrive_IMAC_Utilisateur_FK FOREIGN KEY (id_IMAC_Utilisateur) REFERENCES IMAC_Utilisateur(id)
	,CONSTRAINT IMAC_MessagePrive_IMAC_Utilisateur0_FK FOREIGN KEY (id_IMAC_Utilisateur_Recevoir) REFERENCES IMAC_Utilisateur(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: IMAC_AimerPublication
#------------------------------------------------------------

CREATE TABLE IMAC_AimerPublication(
        id                  Int NOT NULL ,
        id_IMAC_Utilisateur Int NOT NULL
	,CONSTRAINT IMAC_AimerPublication_PK PRIMARY KEY (id,id_IMAC_Utilisateur)

	,CONSTRAINT IMAC_AimerPublication_IMAC_Publication_FK FOREIGN KEY (id) REFERENCES IMAC_Publication(id)
	,CONSTRAINT IMAC_AimerPublication_IMAC_Utilisateur0_FK FOREIGN KEY (id_IMAC_Utilisateur) REFERENCES IMAC_Utilisateur(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: IMAC_AimerCommentaire
#------------------------------------------------------------

CREATE TABLE IMAC_AimerCommentaire(
        id                  Int NOT NULL ,
        id_IMAC_Utilisateur Int NOT NULL
	,CONSTRAINT IMAC_AimerCommentaire_PK PRIMARY KEY (id,id_IMAC_Utilisateur)

	,CONSTRAINT IMAC_AimerCommentaire_IMAC_Commentaire_FK FOREIGN KEY (id) REFERENCES IMAC_Commentaire(id)
	,CONSTRAINT IMAC_AimerCommentaire_IMAC_Utilisateur0_FK FOREIGN KEY (id_IMAC_Utilisateur) REFERENCES IMAC_Utilisateur(id)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: IMAC_Suivre
#------------------------------------------------------------

CREATE TABLE IMAC_Suivre(
        id                  Int NOT NULL ,
        id_IMAC_Utilisateur Int NOT NULL
	,CONSTRAINT IMAC_Suivre_PK PRIMARY KEY (id,id_IMAC_Utilisateur)

	,CONSTRAINT IMAC_Suivre_IMAC_Utilisateur_FK FOREIGN KEY (id) REFERENCES IMAC_Utilisateur(id)
	,CONSTRAINT IMAC_Suivre_IMAC_Utilisateur0_FK FOREIGN KEY (id_IMAC_Utilisateur) REFERENCES IMAC_Utilisateur(id)
)ENGINE=InnoDB;

