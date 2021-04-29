<!DOCTYPE html>
<html lang="en">
<head>
  <title>Premium</title>
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
     <h2 class="card-title text-center">Upgrade to premium</h2>
      <div class="card-body py-md-4">
       <form _lpchecked="1" method="POST" action="premiumAccount">
          <div class="form-group">
             Card Number<input type="number" class="form-control" id="cardnum" placeholder="Card Number" name="cardnum">
          </div>
          <div class="form-group">
             Card Expire Date:<input type="date" class="form-control" id="exdate"  name="exdate">
          </div>                        
          <div class="form-group">
          Pick your Premium account type:
          <br>
            <input type="radio" name="kind" value="g"> Gold (5days)
            <input type="radio" name="kind" value="s"> Silver (3days)
          </div>
          
          <div class="d-flex flex-row align-items-center justify-content-between">
            <a href="common.php">Cancel</a>
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
