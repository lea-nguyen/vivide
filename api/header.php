<?php
    // Autoriser n'importe quel site web à récupérer en Javascript des données de cette API :
    header("Access-Control-Allow-Origin: https://vivide.leanguyen.fr");

    // Fournir un résultat en JSON :
    header('content-type:application/json , text/plain,charset=UTF-8');

    
	header('Access-Control-Allow-Headers: Origin, Content-Type, Accept');