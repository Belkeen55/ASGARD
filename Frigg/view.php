<?php

  header('Content-type: text/html; charset=utf-8');

  // nom du dossier dans lequel sont stockées les images
  $dst_dir  = 'camera';

  // liste des caméras à afficher
  $cameras = array('Zacharie');

  // taille d'affichage des images
  $width  = '640';
  $height = '480';

  // fonction qui renvoie la dernière image d'une caméra
  function showLastImage ($cam_name) {
    global $dst_dir;
    header('Content-type: image/jpeg');
    $dir  = $dst_dir."/".$cam_name."/cam_".$cam_name."_*";
    $imgs = glob($dir);
	echo new Imagick(end($imgs));
  }

  if(isset($_REQUEST['get_cam_img'])){
    echo showLastImage($_REQUEST['get_cam_img']);
  }
  else{

?>

  <!DOCTYPE html>
  <html>
    <head>
      <title>Cameras</title>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
      <style>
        body { text-align : center; background-color : #000;}
        div.camera { display : inline-block; text-align : center; margin : 5px }
        img.camera { width : <?php echo $width; ?>px; height : <?php echo $height; ?>px; }
      </style>
    </head>
    <body>

      <?php foreach($cameras as $camera){ ?>
        <div class="camera" id="<?php echo $camera; ?>">
          <img class="camera" id="img_<?php echo $camera; ?>" src="">
        </div>
      <?php } ?>

      <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
      <script>
        var refresh = 3000;

        $( document ).ready(function() {
          setInterval(function() {
            var now = new Date().getTime();
            $("div.camera").each(function( index ) {
              var camera_name = $( this ).attr("id");
              console.log( "refresh "+camera_name+"..." );
              var url = 'view.php?get_cam_img='+camera_name;
              var img_tmp  = $("<img />").attr("src", url+"&"+now);
              $("#img_"+camera_name).attr("src", url+"&"+now);
            });
          }, refresh);
        });
      </script>

    </body>
  </html>

<?php } ?>