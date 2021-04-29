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
        <a class="nav-link" href="#">Album Managing <span class="sr-only">(current)</span></a>
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
                <h2 class="card-title text-center"> Release a Music</h2>
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="albumManaging">
                        <div class="form-group">
                            Music Name: <input type="text" class="form-control" id="Mname" placeholder="Music Name" name="Mname">
                        </div> 
                        <br>
                        <div class="form-group">
                            Music Duration: <input type="number" class="form-control" id="Mtime" placeholder="Duration" name="Mtime">
                        </div> 
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="addMusic" class="btn btn-primary mr-1">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin:5% 0% 5% 0%">
                <h2 class="card-title text-center"> Your New Songs </h2>
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="albumManaging">
                    <div class="form-group">
                        <?php
                            for ($i=0; $i < sizeof($data['songs']); $i++) { 
                                echo '<input type="checkbox" name="checkSong[]" value="'.$data['songs'][$i]['Mname'].'">'.' ' .$data['songs'][$i]['Mname'].'<br>';
                        } 
                        ?>
                    </div>
                    <div class="form-group">
                            Album Name: <input type="text" class="form-control" id="AlbumTitle" placeholder="Music Name" name="AlbumTitle">
                        </div> 
                        <div class="form-group">
                            Genre: <input type="text" class="form-control" id="genre" placeholder="Genre" name="genre">
                        </div> 
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="addAlbum" class="btn btn-primary mr-1">Submit Album</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Card 3 -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin:5% 0% 5% 0%">
                <h2 class="card-title text-center"> Delete a Song</h2>
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="albumManaging">
                    <div class="form-group">
                            Music Name: <input type="text" class="form-control" id="songname" placeholder="Music Name" name="songname">
                        </div> 
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="delSong" class="btn btn-primary mr-1">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Card 4 -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin:5% 0% 5% 0%">
                <h2 class="card-title text-center"> Delete an Album </h2>
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="albumManaging">
                        <div class="form-group">
                            Album Name: <input type="text" class="form-control" id="albName" placeholder="Album Name" name="albName">
                        </div>  
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="delAlbum" class="btn btn-primary mr-1">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</div>


</body>
</html>
