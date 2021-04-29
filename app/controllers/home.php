<?php
session_start();
class Home extends Controller
{
    protected $user;
    protected $album;
    public function __construct()
    {
        $this->user = $this->model('User');
        $this->album = $this->model('Album');
        $this->playlist = $this->model('Playlist');
        $this->sharedplaylist = $this->model('SharedPlaylist');
        $this->follow = $this->model('Follow');
        $this->qlist = $this->model('QList');
        $this->artist = $this->model('Artist');
        $this->listener = $this->model('Listener');
        $this->music = $this->model('Music');
        $this->premium = $this->model('Premium');
        $this->play = $this->model('Play');
        $this->loglim = $this->model('LoginLimit');
        $this->iploglim = $this->model('IpLoginlimit');
        $this->reqcon = $this->model('RequestControl');
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $ip = ( isset($_SERVER["HTTP_CF_CONNECTING_IP"]) ) ? $_SERVER["HTTP_CF_CONNECTING_IP"] : $_SERVER['REMOTE_ADDR'];
            $now=date('H:i:s');
            $clean = RequestControl::where('expires','<=',$now)->delete();       
            $exists = RequestControl::select('ip','requests')->where('ip','=',$ip)->get();
            if (!empty(json_decode($exists, true))){
                $plusexists=$exists[0]['requests'] + 1;
                $result = RequestControl::where('ip','=',$ip )->take(1)->update(array('requests' => $plusexists));
            }
            else{
                $datee=date('H:i:s', time() + 5 );
                $data = array('ip' => $ip,'requests' => 1,'expires' => $datee);
                $dn = RequestControl::create($data);
            }
            // Check if needs to be blocked
            if (!empty(json_decode($exists, true))){
                if ( $exists[0]['requests'] > 20 ){
                    http_response_code( 429 );
                    header('Retry-After: ' . 5 );
                    die( 'Too many requests, please wait a few seconds' );
                    //$this->alert('Too many requests, please wait a few seconds');
                }
            }
        }
    }

    public function index($name='' , $mood='happy')
    {
        //page not found
        $this->view('home/index');
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        //$data = $mysqli->real_escape_string($data);
        return $data;
    }

    public function jhl($alert='')
    {
        if($alert!='')$this->alert($alert);
        session_unset();
        $this->view('jhl');
    }

    public function signup($alert='')
    {
        if($alert!='')$this->alert($alert);
        $this->view('signup');
    }

    public function report($alert='')
    {
        if($alert!='')$this->alert($alert);
        $this->view('report');
    }

    public function reportSong($alert='')
    {
        if($alert!='')$this->alert($alert);
        if (empty($_POST["rmname"])) {
            $this->report('all fields are required!');
          } 
          else {
            $repm = $this->test_input($_POST["rmname"]);
            $s = Music::select('*')->where('Mname','=',$repm)->get();
            if(sizeof($s)==0){
                $this->report("wrong music name!");
            }
            else{
                $u = Music::where('Mname','=',$repm )->update(array('report' => 'reported'));
                if($u) {
                    $this->profile('music reported successfuly!');
                }
                else{
                    $this->report("something went wrong!");
                }
            }
          }
    }

    public function login($alert='')
    {
        if($alert!='')$this->alert($alert);
        $this->view('login');
    }

    public function adminlog($alert='')
    {
        if($alert!='')$this->alert($alert);
        $this->view('adminlog');
    }

    public function album($alert='')
    {
        if($alert!='')$this->alert($alert);
        $artname = Artist::select('ArtName')->where('username','=',$_SESSION['username'])->get();
        $songs = Music::select('Mname')->where('ArtName','=',$artname[0]['ArtName'])->get();
        $this->view('album',['songs' => $songs]);
    }

    public function admin($alert='')
    {
        if($alert!='')$this->alert($alert);
        $artists = Artist::select('ArtName')->get();
        $artistCheck = Artist::select('ArtName')->where('resType','=','Checking')->get();
        $users = User::select('username')->get();
        $playlists = Playlist::select('pName')->get();
        $albums = Album::select('AlbumTitle')->get();
        $reported = Music::select('Mname')->where('report','=','reported')->get();
        if(isset($_SESSION['username'])){
        if($_SESSION['username']=='admin'){
        $this->view('admin',['artists' => $artists,'artistCheck' => $artistCheck,
        'users' => $users, 'playlists' => $playlists, 'albums' => $albums, 'reported' => $reported]);
        }
    }
        else{
            $this->jhl('access denied');
        }
    }

    public function delaccount()
    {
        $this->view('delaccount');
    }

    public function mail()
    {
        $faveArtist=Play::select('ArtName')
        ->groupBy('ArtName')
        ->where('username','=',$_SESSION['username'])
        ->orderByRaw('COUNT(*) DESC')
        ->limit(1)
        ->get();

        $top=Play::select('Mname')
        ->groupBy('Mname')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(5)
        ->get();
        $nationality = Listener::select('nationality')->where('username','=',$_SESSION['username'])->get();
        if(sizeof($nationality)==0){
            $nationality = Artist::select('nationality')->where('username','=',$_SESSION['username'])->get(); 
        }
       $artistCountry = Artist::select('ArtName')->where('nationality','=',$nationality[0]['nationality'] )->get();
       $this->view('mail',['favArtist' => $faveArtist[0]['ArtName'], 'top' => $top, 'artistCountry' => $artistCountry ]);
    }

    public function premium($alert='')
    {
        if($alert!='')$this->alert($alert);
        $per = Premium::select('*')->where('username','=',$_SESSION['username'])->get();
        if(sizeof($per)==0){
            //print_r(sizeof($per));
            $this->view('premium');
        }
        else if(strtotime($per[0]['expdate'])> strtotime(date('m/d/y'))){//expired
            Premium::where('username','=',$_SESSION['username'])->delete();
            $this->view('premium');
        }
        else {
            $this->profile("you have premium account!");
        }
    }

    public function premiumAccount()
    {
        if (empty($_POST["cardnum"]) || empty($_POST["exdate"])||empty($_POST["kind"])) {
            $this->premium("all fields are required!");
          } 
          else {
             $cardno = $this->test_input($_POST["cardnum"]);
             $xdate = $this->test_input($_POST["exdate"]);
             $kind = $this->test_input($_POST["kind"]);
             $date=date("Y/m/d");
             if(strtotime($xdate)<strtotime($date)){
                $this->premium('your card has been expired!');
             }
             else{
                if($kind=='g')
                $kdate=date('Y-m-d', strtotime("+5 days"));
                if($kind=='s')
                $kdate=date('Y-m-d', strtotime("+3 days"));
                $userType = User::select('userType')->where('username','=',$_SESSION['username'])->get();
                $data = array('cardNo' => $cardno, 'expcardDate' => $xdate, 'buyDate' => $date, 
                'expDate' => $kdate, 'username' => $_SESSION['username'], 'userType' => $userType[0]['userType']);
                $dn = Premium::create($data);
                if($dn){
                    $this->profile('your account is premium!');
                }
                else{
                    $this->premium('something went wrong!');
                }
          }
          }
    }

    public function repass($alert='')
    {
        if($alert!='')$this->alert($alert);
        $this->view('repass', ['name' => $this->user->name]);
    }

    public function passwordRecovery()
    {
        if (empty($_POST["fUsername"]) || empty($_POST["fPass"])|| (empty($_POST["fFtn"]) && empty($_POST["fColor"]))){
            $this->repass('all fields are required');
          }
          else if(!empty($_POST["fFtn"]) && !empty($_POST["fColor"])){
            $this->repass('you should answer just one of the password recovery questions');
          }
          else{
            $fUsername = $this->test_input($_POST["fUsername"]);
            $fPass = $this->test_input($_POST["fPass"]);
            $fhashed_password = password_hash($fPass, PASSWORD_DEFAULT);
            $question = QList::select('*')->where('username','=',$fUsername)->get();
            if(empty($question)){
                $this->repass('incorrect username!');
            }
            
            else if(!empty($_POST["fFtn"]) && $question[0]['question']=='faveTeacher'){
                if(preg_match('/[A-Za-z]/', $_POST["fPass"]) && preg_match('/[0-9]/', $_POST["fPass"]) && strlen($_POST["fPass"])> 7){
                    if(strcmp($question[0]['answer'],$this->test_input(($_POST['fFtn'])))==0){
                        User::where('username','=',$fUsername )->update(array('pass' => $fPass, 'hashedpass' => $fhashed_password));
                        $this->login('password changed successfuly!');
                    }
                    else {
                        $this->repass('incorrect answer to recovery question!');
                    }
                }
                else {
                    $this->repass('password is too weak!');
                }
            }
            else if(!empty($_POST["fColor"]) && $question[0]['question']=='color'){
                if(preg_match('/[A-Za-z]/', $_POST["fPass"]) && preg_match('/[0-9]/', $_POST["fPass"]) && strlen($_POST["fPass"])> 7){
                    if(strcmp($question[0]['answer'],$this->test_input(($_POST['fColor'])))==0){
                        User::where('username','=',$fUsername )->update(array('pass' => $fPass, 'hashedpass' => $fhashed_password));
                        $this->login('password changed successfuly!');
                    }
                    else {
                        $this->repass('incorrect answer to recovery question!');
                    }
                }
                else {
                    $this->repass('password is too weak!');
                }
            }

            else{
                $this->repass('you have answered the wrong question!');
            } 
          }
    }

    public function listenerSignUp($alert='')
    {
        if($alert!='')$this->alert($alert);
        $this->view('listenerSignup');                
    }
    
    public function artistSignUp($alert='')
    {
        if($alert!='')$this->alert($alert);
        $this->view('artistSignup');                
    }
 

    public function test($name='')
    {
        echo "hey".$name;
    }

    public function common()
    {
        if (empty($_POST["loguser"]) || empty($_POST["logpass"])) {
            $this->alert('all fields are required!');
            $this->login();
          }
          else{            
            $loguser = $this->test_input($_POST["loguser"]);
            $logpass = $this->test_input($_POST["logpass"]);
            $mnts=(int) date('i');
            $idadad = LoginLimit::where('username', '=', $loguser)->max('ID');
            //$this->alert($idadad);
            if(isset($idadad))
                $x=$idadad+1;
            else $x=1;

            $data = array('ID' => $x,'username' => $loguser,'timeDiff' => $mnts);
            $dn = LoginLimit::create($data);
            $count = LoginLimit::where('username', '=', $loguser)->max('ID');            

            if($count < 4){                
                $rightPass = User::select('pass')
                ->where('username','=',$loguser)
                ->get();
                
                if(empty(json_decode($rightPass, true))){
                    if($count[0] == 1){
                        $this->login('wrong username and you have two left');
                     }
                     if($count[0] == 2){
                       $this->login('wrong username and you have one left');

                     }
                     if($count[0] == 3){
                       $this->login('wrong username and you cant try more');

                     }
                     else if($count[0] > 3){
                       ///////////pak behse
                      $this->login('wrong user');

                     }
                }
                else {
                //exist
                    $r = User::select('*')->where('username', '=', $loguser)->get();
                    $rightPass = $r[0]['hashedpass'];
                    $loginType = $r[0]['userType'];
    
              if(password_verify($logpass, $rightPass)) {
                LoginLimit::where('username','=',$loguser)->delete();

                // $sql ="DELETE FROM ip_loginLimit WHERE ip ='".$ip."'";
                $_SESSION['username'] = $loguser;
                $users = User::select('username')
                ->where('username','!=',$loguser)
                ->get();

                $albumNames = Album::select('AlbumTitle')
                ->distinct('AlbumTitle')
                ->get();

                $albums = Album::select('*')
                ->get();

                $playlists = Playlist::select('*')->get();

                $followers = Follow::select('firstUsername')
                ->where('secondUsername','=',$loguser)->get();

                $followings = Follow::select('secondUsername')
                ->where('firstUsername','=',$loguser)->get();

                //$this->alert('registered successfully');
                $this->view('common', ['name' => $loguser,
                'users' => $users, 'albums' => $albums,
                'albumNames' => $albumNames, 'playlists' => $playlists,
                'followers' => $followers, 'followings' => $followings]);
              }
              else{
                $rightPasss=$r[0]['pass'];
                if($rightPasss==$logpass){
                    LoginLimit::where('username','=',$loguser)->delete();
                  // $sql ="DELETE FROM ip_loginLimit WHERE ip ='".$ip."'";
                    $_SESSION['username'] = $loguser;

                    $users = User::select('username')
                    ->where('username','!=',$loguser)
                    ->get();

                    $albumNames = Album::select('AlbumTitle')
                    ->distinct('AlbumTitle')
                    ->get();

                    $albums = Album::select('*')
                    ->get();

                    $playlists = Playlist::select('*')->get();

                    $followers = Follow::select('firstUsername')
                    ->where('secondUsername','=',$loguser)->get();

                    $followings = Follow::select('secondUsername')
                    ->where('firstUsername','=',$loguser)->get();

                    //$this->alert('registered successfully');
                    $this->view('common', ['name' => $loguser,
                    'users' => $users, 'albums' => $albums,
                    'albumNames' => $albumNames, 'playlists' => $playlists,
                    'followers' => $followers, 'followings' => $followings]);


                }
                else { //wrong pass
                    if($count == 1){
                        $this->login("wrong password and you have two left");
                    }
                    else if($count == 2){
                        $this->login("wrong password and you have one left");
                    }
                    else if($count == 3){
                        $this->login("wrong password and you cant try more");
                    }
                    else if($count > 3){
                    ////////////pak behse
                    echo "<script>alert('wrong pas');</script>";
                    $this->login("wrong password and you have two left");
                    }
                }
                }
              
                }
            
              }


              else if($count>3){

            //     $new_mnts=(int) date('i');
            //     $adad = mysqli_query($conn, "SELECT max(ID) FROM loginLimit WHERE username='".$loguser."' "); //Fetching Data
            //   // $adad = mysqli_query($conn, "SELECT max(ID) FROM ip_loginLimit WHERE ip='".$ip."' "); //Fetching Data
            //     $idadad = mysqli_fetch_array($adad);
            //     $x=$idadad[0];
            //   $resultcnt = mysqli_query($conn, "SELECT timeDiff FROM loginLimit WHERE username='$loguser' AND ID='$x' "); //Fetching Data
            //   // $resultcnt = mysqli_query($conn, "SELECT timeDiff FROM ip_loginLimit WHERE ip='$ip' AND ID='$x' "); //Fetching Data
            //     $lastmin = mysqli_fetch_array($resultcnt);
            //     if($new_mnts<$lastmin[0])$new_mnts=$new_mnts+60;
            //     if($new_mnts-$lastmin[0]<=5) echo "<script>alert('after 5 minuts try again');</script>";
            //     else {
            //         $sql="DELETE FROM loginLimit WHERE username ='".$loguser."'";
            //         // $sql="DELETE FROM ip_loginLimit WHERE ip ='".$ip."'";
            //         $conn->query($sql);
            //}
                $this->jhl("too much requests!");
              }
            
        }
              
        
    }

    public function deleteAccount(){
        if (empty($_POST["userdel"]) || empty($_POST["passdel"])) {
            $this->alert('all fields are required');
            $this->delaccount();
          }
          else{            
            $userdel = $this->test_input($_POST["userdel"]);
            $passdel = $this->test_input($_POST["passdel"]);
            $rightPass = User::select('pass')
            ->where('username','=',$userdel)
            ->get();
            if(empty(json_decode($rightPass, true))){
                $this->alert('wrong username!');
                $this->delaccount();
            }
            else if(!strcmp($passdel,json_decode($rightPass,true)[0]['pass'])){ //return 0 if equal
                $del = User:: where('username','=',$userdel)
                ->delete();
                if($del) {
                    $this->alert('Account deleted successfully');
                    $this->jhl(); 
                }
                else {
                    $this->alert('Something went wrong!');
                    $this->delaccount();
                }               
            }
            else
            {
                $this->alert('wrong password!');
                $this->delaccount();
            }
        
        }
    }

    public function alert($text){
        echo "<script>alert('".$text."');</script>";
    }

    public function playlist()
    {
        if (isset($_POST['deleteplaylist'])) { //delete playlist
            if(empty($_POST['Dpname'])) {
                $this->profile('you did not enter the playlist name');
            }
            else {
                $del = Playlist:: where('pName','=',$this->test_input($_POST["Dpname"]))
                ->delete();
                if($del) {
                    $this->profile('playlist deleted successfully');
                }
                else{
                    $this->profile('playlist name is incorrect');
                }
            }
            
        } else if (isset($_POST['sharePlaylist'])) { //share
            if (empty($_POST["Dpname"])|| empty($_POST['Upname'])) {
                $this->profile('You have to write the name of the playlist and user');
              }
              else{
                $exist = SharedPlaylist::select('*')
                ->where('pName','=',$this->test_input($_POST["Dpname"]))
                ->where('mainUsername','=',$_SESSION['username'])
                ->where('addUsername','=',$this->test_input($_POST['Upname']))
                ->get();

                if($exist[0]==''){
                    $sharedData = array('pName' => $this->test_input($_POST["Dpname"]), 
                    'mainUsername' => $_SESSION['username'],
                    'addUsername' => $this->test_input($_POST['Upname']));
                    $dn = SharedPlaylist::create($sharedData);
                    if($dn){
                        $this->profile('playlist shared successfully');
                    }
                    else {
                        $this->profile('something went wrong!');
                    }
                }
                else {
                    $this->profile('you have already shared this playlist with the user');
                }
              }
            
        }   
    }

    public function profile($alert='')//common
    {
        if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
            $loguser = $_SESSION['username'];          

            $users = User::select('username')
                ->where('username','!=',$loguser)
                ->get();

                $albumNames = Album::select('AlbumTitle')
                ->distinct('AlbumTitle')
                ->get();

                $albums = Album::select('*')
                ->get();

                $playlists = Playlist::select('*')->get();

                $followers = Follow::select('firstUsername')
                ->where('secondUsername','=',$loguser)->get();

                $followings = Follow::select('secondUsername')
                ->where('firstUsername','=',$loguser)->get();

                if($alert!='')$this->alert($alert);
                $this->view('common', ['name' => $loguser,
                'users' => $users, 'albums' => $albums,
                'albumNames' => $albumNames, 'playlists' => $playlists,
                'followers' => $followers, 'followings' => $followings]);
         }
         else{
             $this->alert('something went wrong!');
         }
    }

    public function follow(){
        if (isset($_POST['follow'])) { //follow
            if(empty($_POST['checkUser'])) {
                $this->profile('you did not select any user');                
            }
            else{
                $wrong=1;
                for ($i=0; $i <sizeof($_POST['checkUser']) ; $i++) {
                    $exist = Follow:: where('firstUsername','=',$_SESSION['username'])->where('secondUsername','=',$this->test_input($_POST['checkUser'][$i]))
                    ->get();
                    if(sizeof($exist)==0){
                        $fData = array('firstUsername' => $_SESSION['username'], 
                        'secondUsername' =>$this->test_input($_POST['checkUser'][$i]));
                        $f = Follow::create($fData);
                        if(!$f){
                            $wrong=0; 
                        }
                    }
                    else{
                        $this->alert('you have already followed '.$this->test_input($_POST['checkUser'][$i]));
                    }
                    
                }
                if($wrong==0){
                    $this->profile("something went wrong!");
                }
                else{
                    $this->profile("no error found");
                }
                
            }
        }
        else if (isset($_POST['unfollow'])) { //unfollow
            if(empty($_POST['checkUser'])) {
                $this->profile('you did not select any user');                
            }
            else{
                $wrong=1;
                for ($i=0; $i <sizeof($_POST['checkUser']) ; $i++) {
                    $f = Follow:: where('firstUsername','=',$_SESSION['username'])->where('secondUsername','=',$_POST['checkUser'][$i])
                    ->delete();
                    if(!$f){
                        $wrong=0; 
                    }
                }
                if($wrong==0){
                    $this->profile("something went wrong!");
                }
                else{
                    $this->profile("you unfollowed ".sizeof($_POST['checkUser'])." user successfuly");
                }
                
            }
        }
        else {
            $this->profile('something went wrong!');
        }

    }

    public function createAccount()
    {
        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["userType"]) || empty($_POST["email"])) {
            $this->signup('all fields are required');
          } 
          else if(empty($_POST["ftn"]) && empty($_POST["color"])){
            $this->signup('you should answer one of the password recovery questions');
          }
          else if(!empty($_POST["ftn"]) && !empty($_POST["color"])){
            $this->signup('you should answer just one of the password recovery questions');
          }
          else if (!filter_var($email= $this->test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $this->signup('Invalid email format');
          }
        
          else if(preg_match('/[A-Za-z]/', $_POST["password"]) && preg_match('/[0-9]/', $_POST["password"]) && strlen($_POST["password"])> 7)
           {
             
            $user = $this->test_input($_POST["username"]);
            $email = $this->test_input($_POST["email"]);
            $pass = $this->test_input($_POST["password"]);
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
            $userType = $this->test_input($_POST["userType"]);
            $color = $this->test_input($_POST["color"]);
            $ftn = $this->test_input($_POST["ftn"]);
            $_SESSION['username'] = $user;
            $data = array('username'=> $user, 'pass' => $pass, 'hashedpass' => $hashed_password , 'email' => $email
            , 'userType' => $userType);
            $dn = User::create($data);
            if(!empty($_POST["color"])) {
                $q = array('username'=> $user, 'question' => 'color', 'answer' => $color);
                $dn = QList::create($q);
            }
            else if(!empty($_POST["ftn"])) {
                $q = array('username'=> $user, 'question' => 'faveTeacher', 'answer' => $ftn);
                $dn = QList::create($q);
            }
            if($userType=='A' && $dn){
                $this->artistSignup();
              }
            else if($userType=='L' && $dn){
                $this->listenerSignUp();
              }
           
        }
           else{
            $this->signup('password is too weak!');
           }
    

    }

    public function artistAccount(){
        if (empty($_POST["ArtName"]) || empty($_POST["nationality"])|| empty($_POST["startDate"])) {
            $this->artistSignup('all fields are required');
        } 
        else {
            $ArtName = $this->test_input($_POST["ArtName"]);
            $nationality = $this->test_input($_POST["nationality"]);
            $startDate = $_POST["startDate"];
            $data = array('ArtName' => $ArtName, 'nationality' => $nationality, 'startDate' => $startDate,
            'username' => $_SESSION['username'], 'userType' => 'A', 'resType' => 'Checking');
            $dn = Artist::create($data);
            if($dn){
                $this->profile("registered successfuly!");
            }
            else{
                $this->artistSignup('something went wrong!');
            }
        }
    }

    public function ListenerAccount(){
        if (empty($_POST["firstName"]) || empty($_POST["lastName"]) || empty($_POST["nationality"])|| empty($_POST["DateOfBirth"])) {
            $this->listenerSignup('all fields are required!');
        } 
        else {

            $firstName = $this->test_input($_POST["firstName"]);
            $lastName = $this->test_input($_POST["lastName"]);
            $nationality = $this->test_input($_POST["nationality"]);
            $DateOfBirth = $_POST["DateOfBirth"];
            $data = array('firstName' => $firstName, 'lastName' => $lastName, 'nationality' => $nationality, 
            'DateOfBirth' => $DateOfBirth, 'username' => $_SESSION['username'], 'userType' => 'L');
            $dn = Listener::create($data);
            if($dn){
                $this->profile("registered successfuly!");
            }
            else{
                $this->listenerSignup('something went wrong!');
            }
        }

    }

    public function adminCheck()
    {
        if ($_POST["adminPass"]=="adminadmin") {
            $_SESSION['username']='admin';
            $this->admin();
          }
        else {
            $this->adminlog('access denied!');
        }  
    }

    public function adminStuff(){
        if (isset($_POST["artistOk"])) {
            if(sizeof($_POST['artistChecked'])==0){
                $this->admin('you did not select any artist');
            }
            else{
                for ($i=0; $i <sizeof($_POST['artistChecked']) ; $i++) { 
                    Artist::where('Artname','=',$_POST['artistChecked'][$i] )->update(array('reType' => 'ok'));
                }
                $this->admin('artists approved successfuly!');
            }
           
        }
        else if (isset($_POST["artistDel"])) {
            if(sizeof($_POST['artistChecked'])==0){
                $this->admin('you did not select any artist');
            }
            else{
                for ($i=0; $i <sizeof($_POST['artistChecked']) ; $i++) { 
                    Artist:: where('Artname','=',$_POST['artistChecked'][$i])
                    ->delete();
                }
                $this->admin('artists deleted successfuly!');
            }
        }
        else if (isset($_POST["userDel"])) {
            if(sizeof($_POST['userChecked'])==0){
                $this->admin('you did not select any user');
            }
            else{
                for ($i=0; $i <sizeof($_POST['userChecked']) ; $i++) { 
                    User:: where('username','=',$_POST['userChecked'][$i])
                    ->delete();
                }
                $this->admin('users deleted successfuly!');
            }
        }
        else if (isset($_POST["playlistDel"])) {
            if(sizeof($_POST['playlistCheck'])==0){
                $this->admin('you did not select any playlist');
            }
            else{
                for ($i=0; $i <sizeof($_POST['playlistCheck']) ; $i++) { 
                    Playlist:: where('pName','=',$_POST['playlistCheck'][$i])
                    ->delete();
                }
                $this->admin('playlist(s) deleted successfuly!');
            }
        }
        else if (isset($_POST["albumDel"])) {
            if(sizeof($_POST['albumCheck'])==0){
                $this->admin('you did not select any album');
            }
            else{
                for ($i=0; $i <sizeof($_POST['albumCheck']) ; $i++) { 
                    Album:: where('AlbumTitle','=',$_POST['albumCheck'][$i])
                    ->delete();
                }
                $this->admin('playlist(s) deleted successfuly!');
            }
        }
        else if (isset($_POST["reportDel"])) {
            if(sizeof($_POST['repCheck'])==0){
                $this->admin('you did not select any music');
            }
            else{
                for ($i=0; $i <sizeof($_POST['repCheck']) ; $i++) { 
                    Music:: where('Mname','=',$_POST['repCheck'][$i])
                    ->delete();
                }
                $this->admin('music(s) deleted successfuly!');
            }
        }

    }

    public function albumManaging()
    {
        $resType = Artist::select('resType')->where('username', '=', $_SESSION['username'])->get();
        if($resType[0]['resType'] == 'ok'){
            if (isset($_POST["addMusic"])) {
                if (empty($_POST["Mname"]) || empty($_POST["Mtime"])) {
                    $this->album('all fields are required!');
                }
                else {

                } 
            }
            else if (isset($_POST["addAlbum"])) {
                if (empty($_POST["AlbumTitle"]) || empty($_POST["genre"])) {
                    $this->album('all fields are required!');
                }
                else if(empty($_POST["checkSong"])){
                    $this->album('you did not select any song!');
                }
                else {
                    for ($i=0; $i <sizeof($_POST["checkSong"]) ; $i++) { 
                        $mtime = Music::select('Mtime')->where('Mname', '=', $this->test_input($_POST["checkSong"][$i]))->get();
                        $artn = Artist::select('ArtName')->where('username', '=',  $_SESSION['username'])->get();

                        $data = array('AlbumTitle' => $this->test_input($_POST["AlbumTitle"]), 
                        'genre' => $this->test_input($_POST["genre"]), 'regDate' => date(''), 
                        'Mname' =>$this->test_input($_POST["checkSong"][$i]) , 
                        'Mtime' => $mtime[0]['Mtime'] , 'ArtName' => $artn[0]['ArtName']);
                        $dn = Album::create($data);
                    }
                    if($dn) {
                        $this->album('album created successfuly!');
                    }
                    else {
                        $this->album('something went wrong!');
                    }
                }
            }
            else if (isset($_POST["delSong"])) {
                if (empty($_POST["songname"])) {
                    $this->album('all fields are required!');
                }
                else {
                    $dn = Music::where('username', '=', $_SESSION['username'])
                    ->where('Mname', '=', $this->test_input($_POST["songname"]))->delete();
                    if($dn) {
                        $this->album('song deleted successfuly!');
                    }
                    else {
                        $this->album('something went wrong!');
                    }
                }
            }

            else if (isset($_POST["delAlbum"])) {
                if (empty($_POST["albName"])) {
                    $this->album('all fields are required!');
                }
                else {
                    $dn = Album::where('username', '=', $_SESSION['username'])
                    ->where('AlbumTitle', '=', $this->test_input($_POST["albName"]))->delete();
                    if($dn) {
                        $this->album('album deleted successfuly!');
                    }
                    else {
                        $this->album('something went wrong!');
                    }
                }
            }
        }

        else{
            $this->album('you are not approved yet!');
        }

    }

    public function likePlay(){
        if(!isset($_POST['checkAlb'])){
            $this->profile('select a song!');
        }

        else if(isset($_POST['like'])){

        }

        else if(isset($_POST['unlike'])){

        }

        else if(isset($_POST['play'])){
            //Play::
            $dn = Premium::select('*')->where('username', '=', $_SESSION['username'])->get();
            if(sizeof($dn)==0){
                //account mamuli
            }

            else {
                //account mamuli
                //todo
            }


            // $data = array('cardNo' => $cardno, 'expcardDate' => $xdate, 'buyDate' => $date, 
            //     'expDate' => $kdate, 'username' => $_SESSION['username'], 'userType' => $userType[0]['userType']);
            //     $dn = Premium::create($data);
        }
    }
} 