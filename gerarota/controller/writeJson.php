<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$coor = $_POST['coor'];
$name = $_POST['name'];

$string = (string) json_encode($coor);

$myfile = fopen("json/".$name.".json", "w");
 
if(!$myfile) {
    $ret = array("ret"=>false, "msg"=>"Problma ao criar arquivo. Nada que um chmod 777 não resolva!");
    echo json_encode($ret); exit();
}        
        
$txt = "Mickey Mouse\n";
fwrite($myfile, $string);
fclose($myfile);

$ret = array("ret"=>true, "msg"=>"O arquivo está em: raiz/controller/json/");
echo json_encode($ret); exit();
