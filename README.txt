@author Sergi Triadó <s.triado@sapalomera.cat>

*** IMPORTANT CANVIAR LA BASEURL DEL FITXER ENVIRONMENT.JSON A LA URL BASE DEL PROJECTE ***
*** IMPORTANT POSAR LES DADES DEL CORREU DE SORTIDA AL FITXER MAIL_SENDER.PHP A TEMPLATES/LOGIN/PWD_RECOVER/MAIL_SENDER.PHP ***

Com a millores he fet la introducció de nous articles i s'afegeixen segons l'autor (usuari registrat), els posts per pàgina es poden 
modificar per veure la llista d'articles amb una paginació diferent

Sobretot a nivell de formularis, la majoria de millores possibles serien més senzilles de fer amb Frontend, pero per falta de temps 
no he pogut implementar moltes de les coses

També he decidit fer un hash de la contrasenya i guardar el hash per reforçar la seguretat enlloc de encriptar-la. Per això, la opció 
de recuperació de contrasenya realment no la recupera, si no que permet modificar-la si l'usuari té accés al correu amb el que va es va registrar.

L'estructura de la aplicació es la següent

/environment/
        /environment.json   *** IMPORTANT CANVIAR EL VALOR DE LA BASEURL D'AQUEST FITXER PERQUE FUNCIONI

/model/                     *** model
            /user.php           *** Classe per crear objectes Usuari
            /article.php        *** Classe per crear objectes Article
            /http.request.php   *** Classe amb funcions estàtiques per fer peticions HTTP al Backend
            /Validator.php      *** Classe amb funcions estàtiques per validar formularis

/modules/                   *** Aquesta carpeta és el propi Backend
        /api/                   *** Entrada al Backend, cada fitxer s'encarrega d'una funció específica
            /article/
                /create.php 
                /delete.php
                /read.php
                /update.php
            /usuari/
                /create.php
                /read.php
                /update.php

        /config/                *** Fitxers amb les clases que pertanyen a la connexió a la BBDD
            /database.php

        /control/               *** Controlador
            /llista_articles.php    *** Controlador d'articles
            /control_usuaris.php    *** Controlador d'usuaris

/public/                    *** Fitxers HTML i PHP senzills que pertanyen a la VISTA
    /assets/
        /fontawesome/               *** Carpeta amb els fitxers necessaris per fer servir les utilities de FontAwesome

    /lib/
        /hydridauth-3.8.2/          *** Llibreria de hybridauth
        /OAuth2/                    *** Llibreria de OAuth2
        /PHPMailer/                 *** Llibreria de PHPMailer

    /styles/                    *** Fitxers d'estils
    /navbar.php                 *** Barra de navegació

/templates/                 *** Fitxers de PHP i formularis més complexes que necessiten de més codi
    /articles/                  *** Fitxer que s'executa quan es clica al botó d'eliminar un usuari
        /articles.php           *** Fitxer que controla els articles
        /articles.vista.php     *** Fitxer amb la vista dels articles
        /delete.php             *** Fitxer que controla l'eliminació d'articles
        /update.php             *** Fitxer que controla l'actualització d'articles
        /update.view.php        *** Fitxer amb la vista del formulari per actualitzar un article

    /login/                 *** Fitxers que gestionen les funcionalitats relacionades amb el login, el registre, etc.
        /pwd_recover/           *** Fitxers que porten la funcionalitat de la recuperació de contrasenya
            /mail_sender.php        *** Fitxer que envia un correu per canviar la contrasenya al email de l'usuari
            /pwd_recover.php        *** Fitxer que gestiona el canvi de contrasenya
            /pwd_recover.view.php   *** Fitxer amb la vista per canviar la contrasenya
            /user_check.php         *** Fitxer que comprova que l'usuari especificat existeix a la BBDD i en recupera el email per enviar instruccions
            /user_check.view.php    *** Fitxer amb la vista per comprovar l'usuari 

        /socials/           *** Fitxers que gestionen l'autenticació social (Gmail no funciona perqué em dona un error de SSL)
            /google.php         *** Fitxer que gestiona l'autenticació mitjançant un compte de google
            /steam.php          *** Fitxer que gestiona l'autenticació mitjançant una compte d'Steam

        /login.php              *** Fitxer que controla el login
        /login.view.php         *** Fitxer amb la vista del Login
        /logout.php             *** Fitxer que controla el deslogament
        /recaptcha.php          *** Fitxer amb el captcha 
        /signup.php             *** Fitxer que controla el registre
        /signup.view.php        *** Fitxer amb la vista del formulari de registre

/index.php                  *** Index de l'aplicació