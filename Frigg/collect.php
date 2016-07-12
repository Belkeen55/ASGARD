<?php

$token    = 'azerty'; // token qui sert de mot de passe
$dst_dir  = 'camera'; // nom du dossier dans lequel seront stock�es les images

if(isset($_REQUEST['token']) && $_REQUEST['token'] == $token){

  if(isset($_REQUEST['camera_name'])){

    $camera_name = $_REQUEST['camera_name'];  // nom de la cam�ra envoy� en m�me temps que l'image
    $img_name    = 'cam_'.$camera_name.'_'.time().'.jpg';   // nom du fichier image � stocker : prefixe, nom de la camera et timestamp

    if(!is_dir($dst_dir)){mkdir($dst_dir, 0777, true);}  // cr�� le r�pertoire de stockage s'il n'existe pas
    if(!is_dir($dst_dir.'/'.$camera_name)){mkdir($dst_dir.'/'.$camera_name, 0777, true);}  // cr�� un sous r�pertoire pour chaque cam�ra s'il n'existe pas

    if (is_uploaded_file($_FILES["camera_image"]["tmp_name"])) {
      move_uploaded_file($_FILES["camera_image"]["tmp_name"], $dst_dir.'/'.$camera_name.'/'.$img_name); // enregistre l'image r�ceptionn�e dans le bon r�pertoire
    }
  }
}

?>