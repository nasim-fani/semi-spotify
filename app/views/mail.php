<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../../public/css/signup.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/jhl.css">

</head>
<body>


<nav class="navbar navbar-expand-sm bg-dark navbar-dark navbar-custom">
  <a class="navbar-brand" href="#">Spotify</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="#">Messages <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile">Home</a>
      </li>  
    </ul>
  </div>  
</nav>

<div class="container">
    <!-- Card 1 -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin:5% 0% 5% 0%">
                <h2 class="card-title text-center"> All Messages</h2>
                <div class="card-body py-md-4">
                    <form _lpchecked="1">
                        <div class="form-group">
                        <h5 class="card-title">your favourit artist: </h5>
                          <?php
                            echo '<p>' .$data['favArtist'].'</p>'; 
                          ?>
                        </div>                                                                      
                        <br>
                        <div class="form-group">
                        <h5 class="card-title">top 5 songs: </h5>
                          <?php
                          if(sizeof($data['top'])>0){
                            for ($i=0; $i < sizeof($data['top']); $i++) { 
                              echo '<p>' .$data['top'][$i]['Mname'].'</p>';
                            } 
                          }
                          ?>
                        </div> 
                        <br>
                        <div class="form-group">
                        <h5 class="card-title">artists from your country: </h5>
                          <?php
                          if ( sizeof($data['artistCountry'])>0){
                            for ($i=0; $i < sizeof($data['artistCountry']); $i++) { 
                              echo '<p>' .$data['artistCountry'][$i]['ArtName'].'</p>';
                            } 
                          }
                          ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
