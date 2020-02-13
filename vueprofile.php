<?php
  $url = $_SERVER['REQUEST_URI'];
  $url = explode('/', $url);
  $lastPart = array_pop($url);
  $token = '92e270ed7da760d3d6df191e5582337b';
  $domainName = 'http://e-learning.alaji.fr/';
  $format = '/webservice/rest/server.php?moodlewsrestformat=json&wstoken=';
  function getUser($id)
  {
    global $token;
    global $domainName;
    global $format;

    $params = "&criteria[0][key]=id&criteria[0][value]=";
    $functionName = 'core_user_get_users';

    $url = $domainName . $format . $token . '&wsfunction=' . $functionName . $params.$id;
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

  function getAttempsReview($id)
  {
    global $token;
    global $domainName;
    global $format;

    $params = '&attemptid=';
    $functionName = 'mod_quiz_get_attempt_review';

    $url = $domainName . $format . $token . '&wsfunction=' . $functionName . $params.$id;
    return $response = json_decode(file_get_contents($url));

  }



  function averageCoef2(array $array)
  {
    $nbElements = count($array);
    $sum = 0;
    $coef = 0;
    for ($i=0; $i < $nbElements; $i++) {
      $sum = $sum + ($array[$i][0] * $array[$i][1]);
      $coef = $coef + $array[$i][1];
    }
    return $sum/$coef;
  }

  function acquis($moyenne)
  {
    if ($moyenne>=0.5) {
      $response = "Acquis";
    }else {
      $response = "Non acquis";
    }
    return $response;
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
          <a class="navbar-brand" href="#">Prototype application alaji</a>
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
         $datas = getUser($lastPart);
         $attempt = getAttempsUser($lastPart);

       ?>

       <div class="row">
         <?php
             $id = ($datas->users[0]->id);
             $fullName = ($datas->users[0]->fullname);
             $email = $datas->users[0]->email;

             $idAttempts = end($attempt->attempts)->id;

             $review = getAttempsReview($idAttempts);
             $note1 = $review->questions[0]->mark;
             $note2 = $review->questions[1]->mark;
             $note3 = $review->questions[2]->mark;
             $note4 = $review->questions[3]->mark;
           ?>

           <?php
              $oral1Error = $oral2Error = $oral3Error = $oral4Error = "";
              $oral1 = $oral2 = $oral3 = $oral4 = "";
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!isset($_POST["critere1"])) {
                  $oral1Error = "Critère 1  est requis";
                } else if ($_POST['critere1'] == 0 || $_POST['critere1'] == 1)  {
                  $oral1 = $_POST['critere1'];
                } else {
                  $oral1Error = "Critère 1  doit être compris entre 0 et 1.";
                }
                if (!isset($_POST["critere2"])) {
                  $oral2Error = "Critère 2  est requis";
                } else if ($_POST['critere2'] == 0 || $_POST['critere2'] == 1)  {
                  $oral2 = $_POST['critere2'];
                }else {

                  $oral2Error = "Critère 2  doit être compris entre 0 et 1.";
                }
                if (!isset($_POST["critere3"])) {
                  $oral3Error = "Critère 3  est requis";
                } else if ($_POST['critere3'] == 0 || $_POST['critere3'] == 1) {
                    $oral3 = $_POST['critere3'];
                }else {
                  $oral3Error = "Critère 3  doit être compris entre 0 et 1.";
                }
                if (!isset($_POST["critere4"])) {
                  $oral4Error = "Critère 4  est requis";
                } else if ($_POST['critere4'] == 0 || $_POST['critere4'] == 1) {
                  $oral4 = $_POST['critere4'];
                }else {
                  $oral4Error = "Critère 4  doit être compris entre 0 et 1.";
                }
                $tab1 = [[intval($note1), 0.23], [$oral1, 0.77]];
                $moyenneCritère1 = averageCoef2($tab1);

                $tab2 = [[intval($note2), 0.89], [$oral2, 0.11]];
                $moyenneCritère2 = averageCoef2($tab2);

                $tab3 = [[intval($note3), 0.52], [$oral3, 0.48]];
                $moyenneCritère3 = averageCoef2($tab3);

                $tab4 = [[intval($note4), 0.34], [$oral4, 0.66]];
                $moyenneCritère4 = averageCoef2($tab4);
              }

            ?>
           <div class="col-md-12 mt-5">
             <div class="card">
               <div class="card-body">
                 <h5 class="card-title"><?php echo $fullName; ?></h5>
                 <p><?php echo $email; ?></p>
                 <div class="note">
                   <p><span class="error">* Champs requis</span></p>
                    <form action="" method="post">
                      <p>Critère 1 oral : <input type="number" name="critere1" step="1" min="0" max="1"><span class="error"> * <?php echo $oral1Error;?></span></p>
                      <p>Critère 2 oral : <input type="number" name="critere2" step="1" min="0" max="1"><span class="error"> * <?php echo $oral2Error;?></span></p>
                      <p>Critère 3 oral : <input type="number" name="critere3" step="1" min="0" max="1"><span class="error"> * <?php echo $oral3Error;?></span></p>
                      <p>Critère 4 oral : <input type="number" name="critere4" step="1" min="0" max="1"><span class="error"> * <?php echo $oral4Error;?></span></p>
                      <input class="btn btn-secondary" type="submit" name="submit" value="Envoie!" />
                    </form>
                 </div>
                 <?php

                  ?>
                 <table class="table text-center">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Test</th>
                      <th>Oral</th>
                      <th>Moyenne critère</th>
                      <th>Acquis</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th>Critères 1</th>
                      <td><?php echo intval($note1); ?></td>
                      <td><?php echo $oral1; ?></td>
                      <td>
                        <?php
                          if($_SERVER["REQUEST_METHOD"] == "POST"){
                            echo $moyenneCritère1;
                          } else {
                            echo "-";
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            echo acquis($moyenneCritère1);
                          }else {
                            echo "-";
                          }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Critères 2</th>
                      <td><?php echo intval($note2); ?></td>
                      <td><?php echo $oral2; ?></td>
                      <td>
                        <?php
                          if($_SERVER["REQUEST_METHOD"] == "POST"){
                            echo $moyenneCritère2;
                          } else {
                            echo "-";
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            echo acquis($moyenneCritère2);
                          }else {
                            echo "-";
                          }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Critères 3</th>
                      <td><?php echo intval($note3); ?></td>
                      <td><?php echo $oral3; ?></td>
                      <td>
                        <?php
                          if($_SERVER["REQUEST_METHOD"] == "POST"){
                            echo $moyenneCritère3;
                          } else {
                            echo "-";
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            echo acquis($moyenneCritère3);
                          }else {
                            echo "-";
                          }
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <th>Critères 4</th>
                      <td><?php echo intval($note4); ?></td>
                      <td><?php echo $oral4; ?></td>
                      <td>
                        <?php
                          if($_SERVER["REQUEST_METHOD"] == "POST"){
                            echo $moyenneCritère4;
                          } else {
                            echo "-";
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            echo acquis($moyenneCritère4);
                          }else {
                            echo "-";
                          }
                        ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
               </div>
             </div>
           </div>
       </div>
     </div>
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   </body>
 </html>
