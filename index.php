<?php

$token = '92e270ed7da760d3d6df191e5582337b';
$domainName = 'http://e-learning.alaji.fr/';
$format = '/webservice/rest/server.php?moodlewsrestformat=json&wstoken=';

function getAllUsers()
{
  global $token;
  global $domainName;
  global $format;
  $params = "&criteria[0][key]=email&criteria[0][value]=%";
  $functionName = "core_user_get_users";

  $url = $domainName . $format . $token . '&wsfunction=' . $functionName . $params;
  var_dump($url);
  return $response = json_decode(file_get_contents($url));
}
function getAttempsUser($id)
{
  global $token;
  global $domainName;
  global $format;

  $params = '&quizid=202&userid=';
  $functionName = 'mod_quiz_get_user_attempts';

  $url = $domainName . $format . $token . '&wsfunction=' . $functionName . $params.$id;
  return $response = json_decode(file_get_contents($url));
}

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
           </ul>
         </div>
       </div>
     </nav>
    <div class="container">
      <?php
        $datas = getAllUsers();

      ?>

      <div class="row">
        <?php
          for ($i=0; $i < count($datas->users) ; $i++) {
            if (isset($datas->users[$i]) ) {
              $id = ($datas->users[$i]->id);
              $fullName = ($datas->users[$i]->fullname);
              $linkImage = $datas->users[$i]->profileimageurl;
              $attempt = getAttempsUser($id);
            }
            if (!empty($attempt->attempts)) {
          ?>
          <div class="col-md-3 mt-5">
            <div class="card text-center">
              <img src="<?php echo $linkImage; ?>" alt="Photo de profil" width="100%" height="250">
              <div class="card-body">
                <h5 class="card-title"><?php echo $fullName; ?></h5>
                <a href="./vueprofile.php/<?php echo $id; ?>" class="btn btn-info">Choisir ce candidat</a>
              </div>
            </div>
          </div>
          <?php
          }
        }
        ?>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
