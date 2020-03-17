<?php
session_start ();
try{
    $base = new PDO("mysql:host=localhost", "root", "");
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   try 
   { $base->exec("CREATE DATABASE pfa");}
   catch(PDOException $e)
   {echo "";}
   $base->exec("use pfa;");
   
}
catch(PDOException $e)
{
echo "";
} 
if (isset($_SESSION['idd']) && isset($_SESSION['pass']))
{
    $i=$_SESSION['idd'];$p=$_SESSION['pass'];
}
?>
 <html style="height:100%">
    <head>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>Espace Guichetier</title>
        <style>
            .btn {
                background-color: #1c1a66;
                border: none;
                color: white;
                padding: 12px 16px;
                font-size: 26px;
                cursor: pointer;
                border-radius: 20px;
                margin-top:-1.5%;
                }
            body
            {
                margin-left: 0%;
                margin-top:0%;
                margin-right: 0%;
                margin-bottom: 0%;
                background-image: url(bb.png);
                height: 100%;
            }
            #fdiv
            {
              
                background-image: url(b1.png);
                padding-top: 0px;
                margin-left: 0;
                margin-bottom: 0px;
                margin-right: 0px;
                height: 100%;
                border-left: 5px;
            }
            #droite
            {
                border-left:solid #03769c;
                border-top-left-radius: 60px;
                border-bottom-left-radius: 60px;
                width: 50%;
                height:95%;
                text-align: center;
                float: right;
            }
            #gauche
            {
                width: 45%;
                float: left;
            }
            #tit
            {
                margin-top: 0%;
                margin-bottom: 0%;
                color:#0b5872;
            }
            #tit2
            {
                /*margin-top: 5%;*/
                /*margin-bottom: 5%;*/
                padding-top: 20px;
                color:#0b5872;
            }
            .barr
            {
                opacity: 0.7;
                border-radius: 9px;
                width:50%;
                height: 25px;
            }
            #button 
            {
                background-color:cadetblue;
                font-size: larger;
                text-align : center;
                color : white ;
                border : none;
                border-radius: 7px;
                opacity: 1;
                transition-duration: 0.4s;
            }
            #button:hover 
            {
                background-color: rgb(115, 204, 118);
                color: white;
                cursor: pointer;
            }
            form
            {
                text-align: center;
                padding-top: 35px;
            }
        </style>
    </head>

    <body style="height:100%;overflow: hidden;">
        <div style="background-color:#1c1a66;height:40px;opacity:0.8;">
            <form method=POST>
                <button type="submit" name="bu" class="btn" ><i class="fa fa-power-off"> Quitter</i></button>
            </form>
            <?php
                if(isset($_POST['bu']))
                {
                    session_unset ();    
                    session_destroy ();

                    header ("Refresh:0;url=login1.php");
                }
            ?>
        </div>
        <div id=fdiv>
        <div id=gauche style="text-align:center;">
        <br><br><h1 id=tit>Information De l'Agent</h1><br><br>
                <?php
                
                
                $ch=$base->query("SELECT nom,prenom,Nom_banque FROM guichetier where pass='$p' and idg='$i' ORDER BY idg;");
                
                 foreach($ch as $row)
                 {      echo"<h2 id=tit>";
                     echo "Nom: ".$row['nom']."</br> ";
                     echo "Prenom: ".$row['prenom']."</br> ";
                     echo "Banque: ".$row['Nom_banque']."</br> ";
                     echo "</h2>";
                 }
                ?>
                <form action="gui.php" method=POST>
                    <label for=rech><h1 id=tit>Tapez Le numrero du CIN</h1></label></br>
                    <input type=number class=barr id=rech name=ci placeholder=exp:12345678 autocomplete=off>
                    <input type="hidden" id="hg" name="hg" value="<?php echo"".$i."".$p.""; ?> ">
                    <input type=submit id=button value=Rechercher>
                </form>
            </div>
            <div id=droite>
                <h1 id=tit2>Infos du Passager</h1>
                <?php
                
                if(isset($_POST['ci']))
                {
                    $c=$_POST['ci'];
                    function existc($c)
                    {
                        global $base;
                        $ch=$base->query("SELECT cin FROM client;");
                        foreach($ch as $row)
                        {
                            if ($row['cin']==$c)
                            {return 1;}
                        }
                        return 0;
                    }
                    
                    $h=$base->query("SELECT * FROM client where cin='$c';");
                    if(existc($c)==1)
                    {
                        foreach($h as $row)
                        {      echo"<h2 id=tit>";
                            echo "Nom: ".$row['nom']."</br> ";
                            echo "Prenom: ".$row['prenom']."</br> ";
                            echo "Quota Disponible: ".$row['quota_dispo']."</br> ";
                            echo "</h2>";
                        }  
                        function quota()
                        {
                            global $c,$base;
                            $ch=$base->query("SELECT * FROM client where cin='$c';");
                            foreach($ch as $row)
                            {
                                
                                return $row['quota_dispo'];
                            }
                            
                        }
                        $l=quota();
                        
                        //var_dump($p); 
                        echo "<form method=POST>
                        <label for=rech><h1 id=tit>Effectuer la transaction</h1></label></br>";?>
                        <input type=hidden class=barr id=rech name=ci value="<?php echo $c ?>">
                        <?php
                        echo"<input type=number class=barr id=rech name=m placeholder=\"Entrer la somme à transcrire\" autocomplete=off></br>
                        <select size=1 class=barr name=sel>
                        <option selected>EURO</option>
                        <option>DOLAR USA</option>
                        <option>YUAN CHINOIS</option>
                        <option>LIVRE STERLING</option>
                        <option>DOLLAR CANADIEN</option>
                        </select></br>
                        <input type=submit id=button value=Transcrire name=tr>
                        </form>";
                    
                        if(isset($_POST['tr']) )
                        {
                            if(isset($_POST['sel'])&& isset($_POST['m']))
                            {
                                $c=$_POST['ci'];
                                $sel=$_POST['sel'];
                                $q=$l - $_POST['m'];
                                $mon=$_POST['m'];
                                if($q>=0)
                                {
                                    $tux=NULL;
                                    $t = date("Y-m-d H:i:s");$f=$base->query("UPDATE client set quota_dispo='$q' where cin='$c' ;");
                                    switch($sel)
                                    {
                                        
                                        case 'EURO':$tux= 1/3.1814 ;break;
                                        case 'DOLAR USA':$tux=1/2.8260;break;
                                        case 'YUAN CHINOIS':$tux=1/0.4075;break;
                                        case 'LIVRE STERLING':$tux=1/3.5932;break;
                                        case 'DOLLAR CANADIEN':$tux=1/2.0613;break;
                                        
                                    }
                                    
                                    $k=$base->query("INSERT INTO transcrire(cin,idg,devise,taux,date_tr)VALUES('$c',$i,'$sel','$tux','$t');");
                                    //$k=$base->query("UPDATE transcrire set taux='$tux' where cin='$c';");
                                    //header("Refresh:0; url=gui.php");
                                    echo "<h2 style=\"color:green;\">Transaction éffectué avec succés</h2> ";
                                    $gg=round($tux*$mon,2);
                                    echo "<h3 id=tit>Le montant transcrit: $gg $sel </h2> ";
                                    $h=$base->query("SELECT * FROM client where cin='$c';");
                                    foreach($h as $row)
                                    {      echo"<h2 id=tit>";
                                        
                                        echo "Nouveau Quota Disponible: \"".$row['quota_dispo']."\"</br> ";
                                        echo "</h2>";
                                    }

                                }
                                else
                                {
                                    echo "<h2 style=\"color:red;\">Transaction échouée !</h2>";

                                }
                                

                            }
                        }   
                    

                    }
                    else
                    {
                        echo"<form action=gui.php method=POST>";?>
                            <input type=hidden class=barr id=rech name=ci value="<?php echo $c ?>">
                            <label ><h1 id=tit>Tapez Le nom du client</h1></label></br>
                            <input type=text class=barr id=rech name=na autocomplete=off>
                            <label ><h1 id=tit>Tapez Le prenom du client</h1></label></br>
                            <input type=text class=barr id=rech name=pna autocomplete=off></br>
                            <input type=submit id=button value=Ajoutez>
                        </form>
                        <?php
                        if(isset($_POST['ci'])&&isset($_POST['na'])&&isset($_POST['pna']))
                            {
                                $n=$_POST['ci'];$w=$_POST['na'];$l=$_POST['pna'];$temp = date("Y-m-d H:i:s");
                                //echo$w;
                                $m=$base->query("INSERT INTO client VALUES('$n','$w','$l',6000,'$temp');");
                                echo "<h2 style=\"color:green;\">Client ajouté avec succés</h2> ";

                            }
                    }

                }
                ?>
            </div>
            
        </div>
    </body>
</html>
