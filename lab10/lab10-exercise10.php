<?php 

require_once('config.php'); 

/*
 Displays a list of genres
*/
function outputGenres() {
   try {
      $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               

      $pdo = null;
   }
   catch (PDOException $e) {
      die( $e->getMessage() );
   }
}

/*
 Displays a single genre
*/
function outputSingleGenre($row) {

}

/* 
  Constructs a link given the genre id and a label (which could
  be a name or even an image tag
*/
function constructGenreLink($id, $label) {

}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapter 14</title>
    <link href="semantic/semantic.css" rel="stylesheet"> 
  </head>
<body>
<main class="ui container">
      <div class="ui secondary segment">
         <h1>List of Links</h1>
      </div>
      
      <div class="ui segment">  
         <div class="ui six doubling cards">
            <?php outputGenres(); ?>  
         </div>
      </div>            
</main>

</body>
</html>