<?php include "base.php"; ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Phys.SE Obsolete Comments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <?php  
  if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))  
  {  
  ?>
  <p style="text-align:right; margin-top:5px; margin-right:15px; font-size:14px;"><strong><?php echo $_SESSION["Username"]; ?></strong> | <button class='btn btn-warning switchbutton btn-sm'>switch sites</button> | <a href="logout.php">logout</a></p>
    <div class="page-header">
        <h1 class="col-md-offset-1"><?php echo $_SESSION["Site"]; ?> Obsolete Comment Queue:  <span class="label label-warning">

        <?php
          $query = mysql_query("SELECT COUNT(*) FROM " . $_SESSION["Site"] . " WHERE handled=0 AND LENGTH(`Text`)<40");
          while ($row = mysql_fetch_array($query)) {
            print_r($row['COUNT(*)']);
          }
        ?>

        </span></h1>
        <!-- <button type="button" class="btn btn-default btn-md" style="float:right"> -->
            <!-- <span class="glyphicon glyphicon-user"></span> Mod Login -->
        <!-- </button> -->
    </div>
    <!-- <div class="col-md-2 col-md-offset-1">
    <h3>Handling Stats</h3>
    <p class="text-muted">
    <?php
      // $query = mysql_query("SELECT COUNT(*) FROM " . $_SESSION["Site"] . " WHERE handled=1 AND handledBy=1");
      // while ($row = mysql_fetch_array($query))
      // {
      //   print_r($row["COUNT(*)"]);
      // }
      // echo "</br>Manish - ";
      // $query = mysql_query("SELECT COUNT(*) FROM " . $_SESSION["Site"] . " WHERE handled=1 AND handledBy=2");
      // while ($row = mysql_fetch_array($query))
      // {
      //   print_r($row["COUNT(*)"]);
      // }
      // echo "</br>jadarnel - ";
      // $query = mysql_query("SELECT COUNT(*) FROM " . $_SESSION["Site"] . " WHERE handled=1 AND handledBy=3");
      // while ($row = mysql_fetch_array($query))
      // {
      //   print_r($row["COUNT(*)"]);
      // }
      // echo "</br>animuson - ";
      // $query = mysql_query("SELECT COUNT(*) FROM " . $_SESSION["Site"] . " WHERE handled=1 AND handledBy=4");
      // while ($row = mysql_fetch_array($query))
      // {
      //   print_r($row["COUNT(*)"]);
      // }
      // $query = mysql_query("SELECT * FROM users");
      // while ($row = mysql_fetch_array($query))
      // {
      //   $numHandledQuery = mysql_query("SELECT COUNT(*) as 'count' FROM " . $_SESSION['Site'] . " WHERE handled=1 AND handledBy=" . $row["id"]);
      //   echo $row["username"] . " - ";
      //   while ($arow = mysql_fetch_row($numHandledQuery)) {
      //     echo $arow["count"] . "</br>";
      //   }
      // }
    echo "This is currently broked. Sorry!";
    ?>
    </p>
    </div> -->
    <div class="col-md-offset-1 col-md-10">
      <table class="table">
        <?php
          $query = mysql_query("SELECT `Text`, `UserID`, `Id`, `CreationDate` FROM " . $_SESSION["Site"] . " WHERE handled=0 ORDER BY LENGTH(`Text`) LIMIT 0,25");
          while ($row = mysql_fetch_array($query))
          {
            echo "<tr id='" . $row['Id'] . "'><td>";

            echo "<div class='comment'>";
            if ($_SESSION["Site"] == "physics")
            {
              echo "<a href='http://physics.stackexchange.com/posts/comments/" . $row["Id"] . "' target='_newtab'><h4 class='comment-text " . $row["Id"] . "'>" . $row["Text"] . " </a><span class='small'> - <strong>user" . $row["UserID"] ."</strong> " . $row["CreationDate"] . " </span></h4>";
            } 
            else
            {
              echo "<a href='http://stackoverflow.com/posts/comments/" . $row["Id"] . "' target='_newtab'><h4 class='comment-text " . $row["Id"] . "'>" . $row["Text"] . " </a><span class='small'> - <strong>user" . $row["UserID"] ."</strong> " . $row["CreationDate"] . " </span></h4>";
            } 
            echo "</div>";
            // echo "</br>";
            // if ($_SESSION["IsDev"] == 1) echo "<p class='showcontextlink text-muted' href='#' id='" . $row["Id"] . "'> show context</p></br>";
            echo "<div class='actions " . $row["Id"] . "'>";
            echo "<div class='btn btn-success' id='" . $row["Id"] . "'><strong>valid</strong></div>";
            echo "<div class='btn btn-danger' id='" . $row["Id"] . "' style='margin-left:10px'><strong>invalid</strong></div>";
            echo "</div>";

            echo "</td></tr>";
          }
          
          ?>
      </table>
    </div>
<?php
}  
elseif(!empty($_POST['username']) && !empty($_POST['password']))  
{  
    $username = mysql_real_escape_string($_POST['username']);  
    $password = md5(mysql_real_escape_string($_POST['password']));  
      
    $checklogin = mysql_query("SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'");  
      
    $success = 1;
      
    if(mysql_num_rows($checklogin) == 1)  
    {  
        $row = mysql_fetch_array($checklogin);   
        $userID = $row['id'];
          
        $_SESSION['Username'] = $username;  
        $_SESSION['LoggedIn'] = 1;  
        $_SESSION['IsDev'] = $row['isDev'];
        $_SESSION['UserID'] = $userID;
        $_SESSION['Site'] = "physics";
          
        echo "<h1>Logged in</h1>";  
//         echo "isadmin: " . $isadmin;
     $success = 0;
    }  
    
    if ($success == 1) echo "<script>this.document.location.href = '/charcoal/index.php?loginsuccess=1'</script>";
    else echo '<script>this.document.location.reload(true);</script>'; 
}  
else  
{  
  ?>
  <h2 class="col-md-offset-1" style="margin-top:30px;">Charcoal <span class="label label-primary">beta</span> <a href="/charcoal/login.php"><button class="btn btn-default pull-right" style="margin-right:30px">login</button></a></h2>
  <p class="col-md-offset-1 text-muted">Efficient obsolete comment flagging for <a href="http://stackexchange.com" target='_newtab'>Stack Exchange</a>.</p>
    <!-- <div class="logindiv" style="margin-top:100px";>  
    
    <div class="container" method="post" action="index.php" name="loginform" style="width:400px">
      <form class="form-signin" action="index.php" method="post">
        <h3 class="form-signin-heading">Login</h2>
        <?php if ($_GET['loginsuccess'] == 1) echo "<div class='alert alert-error' style='max-width:310px; margin:auto; margin-bottom:10px;'><strong>Incorrect username/password</strong></div>"; ?>
        <input name="username" id="username" type="text" class="input-block-level" placeholder="Full Name">
        <input name="password" type="password" id="password" class="input-block-level" placeholder="Password" type="text">
        <button class="btn btn-medium btn-primary" type="submit" style="width:300">Login</button>
      </form>

    </div> /container -->

    <div class="container text-center" style="margin-top:25px;">
      <div class="col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <h2>
              <?php
                $query = mysql_query("SELECT * FROM sites");
                $count = 0;
                while ($row = mysql_fetch_array($query))
                {
                  $aQuery = mysql_query("SELECT * FROM " . $row["siteTableName"] . " WHERE handled=1");
                  $count = $count + mysql_num_rows($aQuery);
                }
                echo $count;
              ?>
            </h2>
            <p class="text-muted">comments reviewed so far</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <h2>
              <?php

                function calculate_average($arr) {
                    $acount = count($arr); //total numbers in array
                    foreach ($arr as $value) {
                        $total = $total + $value; // total value of array numbers
                    }
                    $average = ($total/$acount); // get average value
                    return $average;
                }


                $query = mysql_query("SELECT * FROM sites");
                $count = array();
                while ($row = mysql_fetch_array($query))
                {
                  $aQuery = mysql_query("SELECT SUM(((SELECT COUNT(*) FROM " . $row["siteTableName"] . " WHERE handled=1 AND wasValid=1) / (SELECT COUNT(*) FROM " . $row["siteTableName"] . " WHERE handled=1)) * 100) as percentage");
                  // $count = $count + mysql_num_rows($aQuery);
                  $row = mysql_fetch_array($aQuery);
                  $count[] = $row["percentage"];
                }

                echo calculate_average($count) . " %";
              ?>
            </h2>
            <p class="text-muted">accuracy rate</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <h2>hundreds</h2>
            <p class="text-muted">of helpful flags generated</p>
          </div>
        </div>
      </div>
    </div>

    <p class="text-muted" style="font-size:20px; text-align:center">Ready to join us? Great!</p>
    <div class="text-center"><button class="btn btn-primary btn-lg" style="margin:auto"><strong>Start helping!</strong></button></div>
    <?php
}  
?>  
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
