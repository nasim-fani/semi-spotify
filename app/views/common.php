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
        <a class="nav-link" href="#">Profile <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="premium">Premium</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="jhl">Logout</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="report">Report</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="mail">Messages</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="album">Album Managing</a>
      </li>   
    </ul>
  </div>  
</nav>

<div class="container">
    <!-- Card 1 -->
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card" style="margin:5% 0% 5% 0%">
                <h2 class="card-title text-center"> Welcome to your page <?=$_SESSION['username']?>!</h2>
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="follow">
                        <div class="form-group">
                        <h5 class="card-title">Other Users: </h5>
                            <?php
                               for ($i=0; $i < sizeof($data['users']); $i++) { 
                                echo '<input type="checkbox" name="checkUser[]" value="'.$data['users'][$i]['username'].'">'.' ' .$data['users'][$i]['username'].'<br>';
                                // echo '<button type="submit" class="btn btn-primary" name="userbttn[]" value="'.$data['users'][$i]['username'].'" ><br>';                                
                               } 
                            ?>
                        </div>                                              
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name='follow' class="btn btn-primary mr-1">Follow</button>
                            <button type="submit" name='unfollow' class="btn btn-primary">Unfollow</button>
                        </div>
                        <br>
                            <h5 class="card-title">Your Followers </h5>
                            <?php
                            for ($i=0; $i < sizeof($data['followers']); $i++) { 
                                echo '<p>'.$data['followers'][$i]['firstUsername'].'</p>';                               
                               } 
                            ?>
                            <h5 class="card-title">Your Followings </h5>
                            <?php
                            for ($i=0; $i < sizeof($data['followings']); $i++) { 
                                echo '<p>'.$data['followings'][$i]['secondUsername'].'</p>';                            
                               } 
                            ?>
                            <br>
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
                    <form _lpchecked="1" method="POST" action="likePlay">
                        <div class="form-group">
                            <h5 class="card-title">All Albums: </h5>
                            <?php
                            for ($i=0; $i < sizeof($data['albumNames']); $i++) { 
                                echo '<b>'.$data['albumNames'][$i]['AlbumTitle'].'</b><br>';
                                for ($j=0; $j < sizeof($data['albums']); $j++) { 
                                    if(!strcmp($data['albums'][$j]['AlbumTitle'],$data['albumNames'][$i]['AlbumTitle']) )
                                    echo '<input type="checkbox" name="checkAlb[]" value="'.$data['albums'][$j]['Mname'].'">'.' ' .$data['albums'][$j]['Mname'].'<br>';       
                                }                         
                            }?>                            
                        </div>                                              
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name="like" class="btn btn-primary mr-1">Like</button>
                            <button type="submit" name="unlike" class="btn btn-primary mr-1">Unlike</button>
                            <button type="submit" name="play" class="btn btn-primary mr-1">play</button>
                        </div>
                        <br>
                        <div class="form-group">
                            Playlist Name: <input type="text" class="form-control" id="pname" placeholder="Playlist Name" name="pname">
                        </div> 
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button class="btn btn-primary mr-1">Add to playlist</button>
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
                <h2 class="card-title text-center"> </h2>
                <div class="card-body py-md-4">
                    <form _lpchecked="1" method="POST" action="playlist">
                        <div class="form-group">
                            <h5 class="card-title">All Playlists: </h5>
                            <?php
                               for ($i=0; $i < sizeof($data['playlists']); $i++) { 
                                echo '<input type="checkbox" name="checkPlay[]" value="'.$data['playlists'][$i]['pName'].'">'.' <b>' .$data['playlists'][$i]['pName'].'</b> by '.$data['playlists'][$i]['username'].'<br>';                              
                               } 
                            ?>
                        </div>                                              
                        <br>
                        <div class="form-group">
                            Playlist Name: <input type="text" class="form-control" id="Dpname" placeholder="Playlist Name" name="Dpname">
                        </div> 
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name='deleteplaylist' class="btn btn-primary mr-1">Delete</button>
                        </div>
                        <br>
                        <div class="form-group">
                            User Name: <input type="text" class="form-control" id="Upname" placeholder="User name" name="Upname">
                        </div> 
                        <div class="d-flex flex-row align-items-center justify-content-start">
                            <button type="submit" name='sharePlaylist'  class="btn btn-primary mr-1">Share</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br>
</div>



</body>
</html>
