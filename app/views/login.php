<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
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
     <h2 class="card-title text-center">Login</h2>
      <div class="card-body py-md-4">
       <form _lpchecked="1" method="POST" action="common">
          <div class="form-group">
             User Name:<input type="text" class="form-control" id="loguser" placeholder="User Name" name="loguser">
          </div>                       
          <div class="form-group">
            Password:<input type="password" class="form-control" id="logpass" placeholder="Password" name="logpass">
          </div>
          <div class="d-flex flex-row align-items-center justify-content-between">
            <a href="jhl">Cancel</a>
            <button  type="submit" class="btn btn-primary">Login</button>
          </div>
       </form>
     </div>
  </div>
</div>
</div>
</div>

</body>
</html>
