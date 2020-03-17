<?php
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
if(!(isset($_POST['idd']) && isset($_POST['pass']))&& isset($_POST['conn']))
{
    
    echo "<script type=\"text/javascript\">alert(\"*Identifiant ou Mot de passe incorrecte(s)\");</script>";header("Refresh:0; url=login1.php");
}
else
{
    if((isset($_POST['idd']) && isset($_POST['pass']))&& isset($_POST['conn']))
    {

        $i=$_POST['idd'];
        $p=$_POST['pass'];
        function exist($i,$p)
        {
            global $base;
            $ch=$base->query("SELECT idg,pass FROM guichetier ORDER BY idg;");
            foreach($ch as $row)
            {
                if ($row['idg']==$i && $row['pass']==$p)
                {return 1;}
            }
            return 0;
        }
        if (exist($i,$p)==0)
        {echo "<script type=\"text/javascript\">alert(\"*Identifiant ou Mot de passe incorrecte(s)\");</script>";header("Refresh:0; url=login1.php");}
        else
        {
            session_start();
            $_SESSION['idd']=$_POST['idd'];
            $_SESSION['pass']=$_POST['pass'];
            $t = date("Y-m-d H:i:s");
            $h=$base->query("UPDATE guichetier set ddl='$t';");
            header("Refresh:0; url=gui.php");
        }
        
    }
}
    ?>