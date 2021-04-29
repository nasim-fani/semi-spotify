<!DOCTYPE html>
<html lang="en">
<head>
  <title>Listener Sign Up</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../../public/css/signup.css">

</head>
<body>

<div class="container">
  <div class="row justify-content-center">
  <div class="col-md-5">
   <div class="card">
     <h2 class="card-title text-center"> Welcome!</h2>
      <div class="card-body py-md-4">
       <form _lpchecked="1" method="POST" action="ListenerAccount">
          <div class="form-group">
             First Name:<input type="text" class="form-control" id="firstName" placeholder="First Name" name="firstName">
          </div>                        
          <div class="form-group">
            Last Name:<input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
          </div>
          <div class="form-group">
            Nationality:<input type="text" class="form-control" id="nationality" name="nationality" placeholder="Nationality">
          </div>
          <div class="form-group">
            Date Of Birth:<input type="date" class="form-control" id="DateOfBirth" name="DateOfBirth">
          </div>
          <div class="d-flex flex-row align-items-center justify-content-between">
            <a href="jhl.php">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
       </form>
     </div>
  </div>
</div>
</div>
</div>

</body>
</html>
