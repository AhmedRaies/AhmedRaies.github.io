<?php
        
        try{
            $base = new PDO("mysql:host=localhost", "root", "");
            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           try 
           { $base->exec("CREATE DATABASE pfa");}
           catch(PDOException $e)
           {echo "";}
           $base->exec("use pfa;");
            //$exx='exx';
           try
            { 
                $base->exec("CREATE TABLE transcrire(
                    N_tr INT NOT NULL AUTO_INCREMENT,
                    cin INT,
                    idg int ,
                    devise TEXT,
                    taux NUMERIC,
                    date_tr TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY(N_tr),
                    FOrEIGN KEY (cin) REFERENCES client(cin),
                    FOREIGN KEY (idg) REFERENCES guichetier(idg)  
                );");
                $base->exec("CREATE TABLE client (cin INT NOT NULL PRIMARY KEY,nom TEXT,prenom TEXT,quota_dispo NUMERIC,ddl TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP);");

                $base->exec("CREATE TABLE guichetier (idg INT NOT NULL PRIMARY KEY,nom TEXT,prenom TEXT,pass TEXT,Nom_banque TEXT,email TEXT,ddl TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP);");
            }
            catch(PDOException $e)
                {
                echo "";
                }
    }
    catch(PDOException $e)
    {
    echo "";
    } 
    ?>
<html>
    <head>
        <style>
        #glob{
        margin: 0px;

        height:600px;
        max-width : 100%;
        background-image: url("bb.png");
        background-size: cover;
        opacity: 1;

        border-radius: 10px;
        }
        body
        {
            top: 5%;
            overflow: hidden;
        }
        #gauche{
        width: 60%;
        height: 600px;
        float: left;
        
        }
        #droite{

        width: 40%;
        height: 600px;
        float: right; 
        background-image: url("b1.png");  
        border-radius: 7px;
        }

        #button 
        {
            background-color: #008CBA;
        padding : 2% 5%;
        text-align : center;
        display: inline-block;
        color : white ;
        border : none;
        border-radius: 7px;
        transition-duration: 0.4s;
        opacity: 1;
        }
        #button:hover {
        background-color: rgb(115, 204, 118);
        color: white;
        cursor: pointer;
        }
        form
        {
            padding-top: 6%;
            padding-left: 3%;
        }
        label
        {
            color: #008CBA;
            font-size: x-large;
            
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance:textfield;
        }
        input
        {
            border-radius: 9px;
            opacity: 0.75;
            font-size: larger;
            overflow: hidden;
        }
        </style>
    </head>
    <body>
        <div id="glob">        
            <div id="gauche">
                 
            </div>
            <div id="droite"">
                <h1 style="color: #03769c;padding-top: 18%;">&nbsp;Espace Guichetier</h1>
                    <form action="verif.php" method="POST">
                    <label for="fid"><strong>Identifiant:</strong></label></br>
                     <input type="number" id="fid" name="idd"><br><br>
                    <label for="pass"><strong>Mot de passe:</strong></label></br>
                     <input type="password" id="pass" name="pass"><br><br>
                    <input id="button" type="submit" name="conn" value="Connecter">
                    
                  </form>
                
            </div>
        </div>
    </body>
</html>