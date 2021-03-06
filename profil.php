<?php
session_start();

$bdd = new PDO('mysql:host=127.0.0.1;dbname=connexion', 'root', '');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM user WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();

?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/apiMoodle/style.css">
  </head>
  <body>
    <nav class="mb-1 navbar navbar-expand-sm bg-dark navbar-dark">
       <div class="container">
         <img src="https://www.alaji.fr/wp-content/uploads/logo.png" alt="" class="logo">
         <a class="navbar-brand" href="#">Prototype application</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
           aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent-333">
           <ul class="navbar-nav ml-auto">
             <li class="nav-item active">
               <a class="nav-link" href="/apiMoodle">
                 Liste
                 <span class="sr-only">(current)</span>
               </a>
             </li>
             <li class="nav-item active">
               <a class="nav-link" href="/apiMoodle/connexion.php">
                 Connexion
                 <span class="sr-only">(current)</span>
               </a>
             </li>
           </ul>
         </div>
       </div>
     </nav>
     <div class="container">
       <div class="card testimonial-card mb-3">
          <div class="card-up aqua-gradient"></div>
          <div class="avatar mx-auto white">
            <img src="<?php echo $userinfo['image']; ?>" class="rounded-circle img-responsive" alt="woman avatar">
          </div>
          <div class="card-body">
            <h4 class="card-title font-weight-bold text-center"><?php echo $userinfo['full_name']; ?></h4>
            <hr>
            <p>Mon email : <?php echo $userinfo['email'] ?></p>
          </div>
      </div>
     </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  }
 ?>
