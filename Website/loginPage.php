<?php
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    
    require 'vendor/facebook/graph-sdk/src/Facebook/autoload.php';


    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    use Facebook\FacebookResponse;
    use Facebook\FacebookSDKException;
    use Facebook\FacebookRequestException;
    use Facebook\FacebookAuthorizationException;
    use Facebook\GraphObject;
    use Facebook\GraphLocation;
    use Facebook\GraphUser;
    use Facebook\GraphSessionInfo;
    use Facebook\Entities\AccessToken;
    use Facebook\HttpClients\FacebookCurlHttpClient;
    use Facebook\HttpClients\FacebookHttpable;


    $fb = new Facebook\Facebook([
      'app_id' => '1504323456292270',
      'app_secret' => '946d6447c4f44aeecc5ee101e0ac146b',
      'default_graph_version' => 'v2.9',
      'persistent_data_handler'=>'session'
      ]);

    try {
        // Get the \Facebook\GraphNodes\GraphUser object for the current user.
        // If you provided a 'default_access_token', the '{access-token}' is optional.
        $helper = $fb->getRedirectLoginHelper();
        if(isset($_GET['state']))
            $_SESSION['FBRLH_state']=$_GET['state'];
        $permissions = ['email','user_location']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('https://sitejinni.com/fbcallback.php', $permissions);
    } catch(\Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    } catch(\Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <meta name="description" content="Login and Registration Form with HTML5 and CSS3" />
        <meta name="keywords" content="html5, css3, form, switch, animation, :target, pseudo-class" />
        <meta name="author" content="Codrops" />
        
        <link rel="shortcut icon" href="../favicon.ico"> 
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style3.css" />
        <link rel="stylesheet" type="text/css" href="css/animate-custom.css" />
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.css" rel="stylesheet">
        <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
        
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        
       
        <script type="text/javascript">
            var isSignUpError = false;
            var signUpErrorMessage = '';
            $(document).ready(function()
            {
               $('#passwordsignup_confirm').on('input',function()
               {               
                   var pwd = $('#passwordsignup').val();
                   var pwd_conf = $(this).val();
                   if( pwd == pwd_conf){
                       $('#passwordsignup').css('border', function(){
                            return '2px solid #0f0';
                        });
                       $('#passwordsignup_confirm').css('border', function(){
                            return '2px solid #0f0';
                        });
                        isSignUpError = false;
                        signUpErrorMessage = '';
                   }
                   else{
                       $('#passwordsignup').css('border', function(){
                            return '2px solid #f00';
                        });
                       $('#passwordsignup_confirm').css('border', function(){
                            return '2px solid #f00';
                        });
                       isSignUpError = true;
                       signUpErrorMessage = 'The passwords do not match';
                   }
               }); 
               $('#passwordsignup').on('input',function()
               {               
                   var pwd = $(this).val();
                   
                   var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{8,}$/;
                   if( regex.test(pwd)){
                       $(this).css('border', function(){
                            return '2px solid #0f0';
                        });
                        isSignUpError = false;
                        signUpErrorMessage = '';
                   }
                   else{
                       $(this).css('border', function(){
                            return '2px solid #f00';
                        });
                        isSignUpError = true;
                        signUpErrorMessage = 'The password should contain atleast 1 small letter, 1 capital letter, 1 number. Minimum length 8. No Special characters.';
                   }
               }); 
               $('#signupform').on('submit',function(){
                   var uid = $('#usernamesignup').val();
                   var upwd = $('#passwordsignup').val();
                   var umail = $('#emailsignup').val();
                   var ufname = $('#userfnamesignup').val();
                   var ulname = $('#userlnamesignup').val();
                   var ubladd1 = $('#userbilladdressl1').val();                   
                   var ucity = $('#usercity').val();
                   var uzipcd = $('#userzipcode').val();
                   var ustate = $('#userstate').val();
                   var ucntry = $('#usercountry').val();
                   var uphn1 = $('#userphone1').val();
                   var uuidtype = $('#useruniqueidtype').val();
                   var uuid = $('#useruniqueid').val();
                   
                   if(uid === null || upwd === null || umail === null || ufname === null || ulname === null || ubladd1 === null || uuid === null ||
                      ucity === null || uzipcd === null || ustate === null || ucntry === null || uphn1 === null || uuidtype === null ||
                      uid === '' || upwd === '' || umail === '' || ufname === '' || ulname === '' || ubladd1 === '' || 
                      ucity === '' || uzipcd === '' || ustate === '' || ucntry === '' || uphn1 === '' || uuid === '' || uuidtype === '')
                   {
                       isSignUpError = true;
                       signUpErrorMessage = 'Please fill in the required (*) fields.';
                   }
                   
                   if(isSignUpError)
                   {
                       alert(signUpErrorMessage);
                       return false;
                   }
                   else
                       return true;
               });
            });            
        </script>
    </head>
    <body>
        
        <?php            
            include './Classes/DataAccess.php';
            include './Classes/Entities/EntityBase.php';
            include './Classes/Entities/User.php';
            include './Classes/Entities/Client.php';
            try {
                    $desturl = NULL;
                    if(isset($_GET['u']))
                    {
                        $str = $_GET['u'];
                        $clnt = Client::GetClientbyURL($str);
                        $finalurl = "/docroots/userdocroots/" + $clnt->clientname + "/docroot/index.php";
                        $_SESSION["destpage"] = $str;
                    }
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(isset($_POST["btnSubmitSignup"]))
                    {
                        $userbyid = User::GetUserbyID($_POST["usernamesu"]);
                        $userbymail = User::GetUserbyEMail($_POST["emailsu"]);
                        if($userbyid!=NULL || $userbymail != NULL)
                        {
                            echo "<script>alert('The userid or the mail address already exists. Please choose a different id and mail address.');</script>";
                        }
                        else {
                            $passwordhash = password_hash($_POST["passwordsu"], 1);
                            $user = new User($_POST["usernamesu"],$passwordhash,$_POST["emailsu"],$_POST["userfnamesu"],$_POST["userlnamesu"],
                                             $_POST["userbilladdressl1"],$_POST["userbilladdressl2"],$_POST["usercity"],$_POST["userzipcode"],$_POST["userstate"],
                                             $_POST["usercountry"],$_POST["userphone1"],$_POST["useruniqueidtype"], $_POST["useruniqueid"]);
                            $user->AddEntity();                    
                        }
                        if(isset($_SESSION["installpage"]) && isset($_SESSION["purpose"]) && $_SESSION["purpose"] == "install") {
                            $_SESSION["user"] = $user;
                            die('<script type="text/javascript">window.location.href="FirstClientCreationPage.php";</script>');
                        }
                    }
                    if(isset($_POST["loginSubmit"]))
                    {
                        $userid = $_POST["username"];
                        $userpwd = $_POST["password"];
                        
                        $user = User::GetUserbyID($userid);
                        if($user != NULL)
                        {
                            if(password_verify($userpwd, $user->userpasswd))
                            {
                                //if(session_status()!=PHP_SESSION_ACTIVE) session_start();
                                $_SESSION["user"] = $user;
                                if(isset($_SESSION["destpage"]) && $_SESSION["destpage"] != NULL) {
                                    $destpage = $_SESSION["destpage"];
                                    unset($_SESSION["destpage"]);
                                    die('<script type="text/javascript">window.location.href="http://' . $destpage . '";</script>');
                                } else {
                                    die('<script type="text/javascript">window.location.href="userPortfolioPage.php";</script>');
                                }
                            }
                            else 
                            {
                                echo "<script>alert('The password does not match.');</script>";
                            }
                        }
                        else
                            echo "<script>alert('The userid does not exist.');</script>";
                    }
                }               
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }


                               
        ?>
        
        <div class="container">            
            <div style="height: 12%"></div>
            <section>				
                <div id="container_demo">
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
                            <form  action="loginPage.php" method="POST" id="loginform" autocomplete="on"> 
                                <h1>Log in</h1> 
                                <p> 
                                    <label for="username" class="uname" data-icon="u" > Your email or username </label>
                                    <input id="username" name="username" required="required" type="text" placeholder="myusername or mymail@mail.com"/>                                    
                                </p>
                                <p> 
                                    <label for="password" class="youpasswd" data-icon="p"> Your password </label>
                                    <input id="password" name="password" required="required" type="password" placeholder="eg. X8df!90EO" /> 
                                </p>
                                <p class="keeplogin"> 
                                    <input type="checkbox" name="loginkeeping" id="loginkeeping" value="loginkeeping" /> 
                                    <label for="loginkeeping">Keep me logged in</label>
                                </p>
                                <p class="login button"> 
                                    <input type="submit" name="loginSubmit" value="Login" /> 
                                </p>
                                <h1></h1>
                                <div class="text-center">
                                    <a href="<?php echo htmlspecialchars($loginUrl); ?>" class="btn btn-default btn-lg"><i class="fa fa-facebook fa-fw"></i> <span class="network-name">Sign in with FB</span></a> 
                                    <span class="network-name" style="margin: 5px"> OR </span>
                                    <a href="#toregister" class="btn btn-default btn-lg to_register">Register Now</a>
                                </div>
                            </form>
                        </div>

                        <div id="register" class="animate form" >
                            <form id="signupform" action="#tologin" method="POST" autocomplete="on"> 
                                <h1> Sign up </h1> 
                                <p> 
                                    <label for="usernamesignup" class="uname" data-icon="u">Your username</label>
                                    <span style="color: red">*</span>
                                    <input id="usernamesignup" name="usernamesu" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="emailsignup" class="youmail" data-icon="e" > Your email</label>
                                    <span style="color: red">*</span>
                                    <input id="emailsignup" name="emailsu" required="required" type="email" placeholder="mysupermail@mail.com"/> 
                                </p>
                                <p> 
                                    <label for="passwordsignup" class="youpasswd" data-icon="p">Your password </label>
                                    <span style="color: red">*</span>
                                    <input id="passwordsignup" name="passwordsu" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="passwordsignup_confirm" class="youpasswd" data-icon="p">Please confirm your password </label>
                                    <span style="color: red">*</span>
                                    <input id="passwordsignup_confirm" name="password_confirmsu" required="required" type="password" placeholder="eg. X8df!90EO"/>
                                </p>
                                <p> 
                                    <label for="userfnamesignup" class="uname" data-icon="u">First Name</label>
                                    <span style="color: red">*</span>
                                    <input id="userfnamesignup" name="userfnamesu" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="userlnamesignup" class="uname" data-icon="u">Last Name</label>
                                    <span style="color: red">*</span>
                                    <input id="userlnamesignup" name="userlnamesu" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="userbilladdressl1" class="uname" data-icon="u">Billing Address Line 1</label>
                                    <span style="color: red">*</span>
                                    <input id="userbilladdressl1" name="userbilladdressl1" required="required" type="text" placeholder="mysuperusername690" />
                                    <input id="userbilladdressl2" name="userbilladdressl2" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="usercity" class="uname" data-icon="u">City</label>
                                    <span style="color: red">*</span>
                                    <input id="usercity" name="usercity" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="userzipcode" class="uname" data-icon="u">Zip Code</label>
                                    <span style="color: red">*</span>
                                    <input id="userzipcode" name="userzipcode" required="required" type="text" placeholder="mysuperusername690" />
                                    <label for="userstate" class="uname" data-icon="u">State</label>
                                    <span style="color: red">*</span>
                                    <input id="userstate" name="userstate" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="usercountry" class="uname" data-icon="u">Country</label>
                                    <span style="color: red">*</span>
                                    <input id="usercountry" name="usercountry" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="userphone1" class="uname" data-icon="u">Phone Number</label>
                                    <span style="color: red">*</span>
                                    <input id="userphone1" name="userphone1" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="useruniqueidtype" class="uname" data-icon="u">Unique ID Type</label>
                                    <span style="color: red">*</span>
                                    <input id="useruniqueidtype" name="useruniqueidtype" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p> 
                                    <label for="useruniqueid" class="uname" data-icon="u">Unique ID</label>
                                    <span style="color: red">*</span>
                                    <input id="useruniqueid" name="useruniqueid" required="required" type="text" placeholder="mysuperusername690" />
                                </p>
                                <p class="signin button"> 
                                    <div class="box">
                                        <p>
                                            <input type="submit" name="btnSubmitSignup" value="Sign up"/> 
                                        </p>
                                        
                                    </div>
                                </p>
                                <p class="change_link">  
                                    Already a member ?
                                    <a href="#tologin" class="to_register"> Go and log in </a>
                                </p>
                            </form>
                        </div>
						
                    </div>
                </div>  
            </section>
        </div>
        <script src="vendor/twbs/bootstrap/dist/js/jquery.js"></script>
        <script src="vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>

    </body>
</html>
