<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin Section</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../..public/css/signup.css">
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
        <a class="nav-link" href="#">Admin Panel <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="jhl">Home</a>
      </li>  
    </ul>
  </div>  
</nav>

<div class="container">
    <!-- Card 1 -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin:5% 0% 5% 0%">
                <h2 class="card-title text-center">Control Panel</h2>
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="adminStuff">
                        <div class="form-group">
                            <h5 class="card-title">All Artists </h5>
                            <?php
                               for ($i=0; $i < sizeof($data['artists']); $i++) { 
                                echo '<p>'.$data['artists'][$i]['ArtName'].'</p>';                              
                               } 
                            ?>
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
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="adminStuff">
                        <div class="form-group">
                            <h5 class="card-title">New Artists </h5>
                            <?php
                               for ($i=0; $i < sizeof($data['artistCheck']); $i++) { 
                                echo '<input type="checkbox" name="artistChecked[]" value="'.$data['artistCheck'][$i]['ArtName'].'">'.' ' .$data['artistCheck'][$i]['ArtName'].'<br>';                              
                               } 
                            ?>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="artistOk" class="btn btn-primary mr-1">ok</button>
                            <button type="submit" name="artistDel" class="btn btn-primary mr-1">Delete</button>
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
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="adminStuff">
                        <div class="form-group">           
                            <h5 class="card-title">All Users: </h5>
                            <?php
                               for ($i=0; $i < sizeof($data['users']); $i++) { 
                                echo '<input type="checkbox" name="userChecked[]" value="'.$data['users'][$i]['username'].'">' .' '.$data['users'][$i]['username'].'<br>';                              
                               } 
                            ?>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="userDel" class="btn btn-primary mr-1">Delete</button>
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
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="adminStuff">
                        <div class="form-group">
                            <h5 class="card-title">All Playlists: </h5>                           
                            <?php
                               for ($i=0; $i < sizeof($data['playlists']); $i++) { 
                                echo '<input type="checkbox" name="playlistChecked[]" value="'.$data['playlists'][$i]['pName'].'">'.' ' .$data['playlists'][$i]['pName'].'<br>';                              
                               } 
                            ?>
                        </div>
                        <div class="form-group">
                            Playlist Name:<input type="password" class="form-control" id="password" placeholder="Password" name="adminPass">
                        </div>
                        <div class="form-group">
                            User Name:<input type="password" class="form-control" id="password" placeholder="Password" name="adminPass">
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="playlistDel" class="btn btn-primary mr-1">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 5 -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin:5% 0% 5% 0%">
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="adminStuff">
                        <div class="form-group">                        
                            <h5 class="card-title">All Albums: </h5>
                            <?php
                               for ($i=0; $i < sizeof($data['albums']); $i++) { 
                                echo '<input type="checkbox" name="albumCheck[]" value="'.$data['albums'][$i]['AlbumTitle'].'">'.' ' .$data['albums'][$i]['AlbumTitle'].'<br>';                              
                               } 
                            ?>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="albumDel" class="btn btn-primary mr-1">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 6 -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin:5% 0% 5% 0%">
                <div class="card-body py-md-4">
                    <form _lpchecked="1" >
                        <div class="form-group">
                            <h5 class="card-title">Reported Songs </h5>
                            <?php
                               for ($i=0; $i < sizeof($data['reported']); $i++) { 
                                echo '<input type="checkbox" name="repCheck[]" value="'.$data['reported'][$i]['Mname'].'">' .$data['reported'][$i]['Mname'].'<br>';                              
                               } 
                            ?>
                        </div>
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="reportDel" class="btn btn-primary mr-1">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</div>


</body>
</html>
