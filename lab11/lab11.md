# Lab11  
The Last Lab! ✌️  

>Goal of this lab:  
>1. Use COOKIE  
>2. Use Session  

This lab does not require screenshots, just a document~


**DDL: 23:59:59, June 14th, 2020**  
Please contact with us if have any questions~  

### Exercise1: Using Cookie  
1. Create a database named `Login`. Execute the database commands in `lab11-exercise1.sql` in `art`. This will create tables to store user credentials.  
2. Open, examine, and test `lab11-exercise1.php`. You will see a webpage containing a single login form. The page is also configured to connect to the database you just created. If you try to enter information and submit, the form is posted but no action is taken (aside from saying `"Login attempted"`).  
3. Add a function to check the posted credentials against the credentials stored in the database. If the user was successful, output a welcome message, otherwise output an error message with the form using code like:  
   ```php
   function validLogin(){  
     $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);  
     //very simple (and insecure) check of valid credentials. 
     $sql = "SELECT * FROM Credentials WHERE Username=:user and Password=:pass";  
   
     $statement = $pdo->prepare($sql);   
     $statement->bindValue(':user',$_POST['username']);   
     $statement->bindValue(':pass',$_POST['pword']);   
     $statement->execute();   
     if($statement->rowCount()>0){  
           return true;  
     }  
     return false;  
   }
   ```  
4. Now use this newly defined function in our main logic as follows:  
   ```php  
   $loggedIn=false;  
   if ($_SERVER["REQUEST_METHOD"] == "POST") {  
      if(validLogin()){   
         echo "Welcome ".$_POST['username'];  
         $loggedIn=true;   
      }  
      else{  
         echo "login unsuccessful";  
      }  
   } else{  
     echo "No Post detected";  
   }
   ```  
5. Finally, where we used to echo the form out, we can conditionally echo it only when no one is logged in  
   ```php
   if(!$loggedIn){
      echo getLoginForm();
   } else{
      echo "This is some content"; 
   }
   ```  
6. Once you log in successfully, you will see the welcome message, but if you refresh the URL the script will not remember your successful login, and you will be prompted to login again. This is because HTTP has no state.  

   We will now use cookies, so that when user logs in successfully, their credentials are stored in a cookie, and that cookie is subsequently examined for a valid logged in user. Where the user is authenticated correctly you add code to set the cookie:  
   
   ```php  
   if(validLogin()){  
       echo "Welcome ".$_POST['username'];  
       // add 1 day to the current time for expiry time   
       $expiryTime = time()+60*60*24;  
       setcookie("Username", $_POST['username'], $expiryTime);
   }
   ```  
7. Now, before we even check for a `POST` we should consider whether a logged in user has a good cookie. Modify your code to check for the presence of a cookie but after checking for the post.  
   ```php  
   if ($_SERVER["REQUEST_METHOD"] == "POST") {   
      if(validLogin()){  
         // add 1 day to the current time for expiry time   
         $expiryTime = time()+60*60*24;  
         setcookie("Username", $_POST['username'], $expiryTime);   
      }  
      else{  
         echo "login unsuccessful";  
      }  
   }  
   if(isset($_COOKIE['Username'])){  
      echo "Welcome ".$_COOKIE['Username'];  
   }  
   else{  
      echo "No Post detected";  
   }
   ```  
8. Similarly, chance your logic to use the cookie to determine whether or not to display the form:  
   ```php  
   if (!isset($_COOKIE['Username'])){  
      echo getLoginForm();   
   }  
   else{  
      echo "This is some content";  
   }
   ```  
9. Finally, we will create a logout file, and include a link to that file from our main page. The file, placed in `logout.php` will look like:  
   ```php  
   <?php  
   setcookie("Username", "", -1);  
   header("Location: ".$_SERVER['HTTP_REFERER']);  
   ?>
   ```  
10. Try logging out, and logging in, see how your cookie will persist until you logout (or the time expires).  


### Exercise2: Session

1. This exercise will make use of your `Exercise1`, but replace the cookies with sessions
   (which automatically use cookies).  
2. Open your main file and `logout.php` and at the top add  
   ```php
   session_start();
   ```  
   This will automatically make a session be transmitted as a cookie, and that session can then be associated with values just like a cookie.  
3. Next change every where that we used to refernce cookie with the same code, but inside the `$_SESSION`.  
   Instead of setting a cookie:  
   `setcookie("UserName", $_POST['username'], $expiryTime);`  
   set a session variable:  
   ` $_SESSION['Username']=$_POST['username'];`  
  
   As a consequence, everywhere that you check `$_COOKIE['username']` should now be `$_SESION['Username']`. So  
   ```php  
   if(isset($_SESSION['Username'])){
      echo "Welcome ".$_SESSION['Username'];
   }
   //...
   if (!isset($_SESSION['Username'])){
      echo getLoginForm(); 
   }
   ```  
4. In `logout.php` we log the user out by wiping out the session rather than the cookie.  
   `setcookie("Username", "", -1);`
   becomes
  ` unset($_SESSION['Username']);`  
5. Try logging in as before and your authentication should "stick" just like you made it do with cookies.   

### Document:  
The document must contain at least the following questions:
1. The function of cookie and session  
2. The advantages & disadvantages of cookie and session.  



   
   








