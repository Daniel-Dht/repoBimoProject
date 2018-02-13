<!DOCTYPE> 
    <meta charset="utf-8" />
    <title> Liste medoc </title>
<html>
<body>
    <p> salut </p>
</body>

<?php
$row = 1;
$delimiter1 = ";";
$informations = array();
// ouverture du fichier et lecture
if (($handle = fopen("bdd_med.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE ) {
        $num = count($data);
        $row++;
        
        for ($c=0; $c < $num; $c++) {  
            $premier = explode($delimiter1,$data[$c]);
            $premier = str_replace("_", "é", $premier);
            $informations[] = $premier[1];
        }
    }
    fclose($handle);
}



try
    {
        $db = new PDO('mysql:host=localhost;dbname=symfony;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    // requete SQL
    for ($n = 2; $n < sizeof($informations);$n++){
    $test = $bdd->query('INSERT INTO medicaments(id, Medoc) VALUES ("'.$n.'" , "'.$informations[$n].'")');
    }
?>


</html>