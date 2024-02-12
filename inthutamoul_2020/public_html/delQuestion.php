<?php
session_start();
require_once('database.php');

//Suppression question
$req1 = $bdd->prepare("DELETE FROM questions WHERE idQuest = ?");
$req1->execute(array($_GET['idQuest']));

//Suppression réponses
$req2 = $bdd->prepare("DELETE FROM reponses WHERE idQuest = ?");
$req2->execute(array($_GET['idQuest']));

//Suppression dans QCM_answered
$req3 = $bdd->prepare("DELETE FROM QCM_answered WHERE idQuest = ?");
$req3->execute(array($_GET['idQuest']));

header("Location: pageQCM.php?id=1&niv=".$_GET['niv']."&idYr=".$_GET['idYr']);
?>

