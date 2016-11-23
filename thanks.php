<?php
  require_once 'config/build.php';
  
  $username = $MBX_CONF['db_username'];
  $password = $MBX_CONF['db_password'];
  $dsn = $MBX_CONF['db_source'];
  
  try {
  
  // other_email must be blank, if it isn't this is probably spam submission
  if ($_POST['other_email'] == '')
  {
  
      $dbh = new PDO($dsn, $username, $password);
      /*** echo a message saying we have connected ***/
     
       /*** INSERT data ***/
  //    $sql = $dbh->prepare("INSERT INTO applications(FullName, Job, Work, MembershipType, Street, City, State, Zip, Phone, Email, Website, Twitter, SkillSet, Hear, Refer, Offer, Relationship) VALUES (:FullName, :Job, :Work, :MembershipType, :Street, :City, :State, :Zip, :Phone, :Email, :Website, :Twitter, :SkillSet, :Hear, :Refer, :Offer, :Relationship)");
      $sql = $dbh->prepare("INSERT INTO applications(FullName, Job, Work, MembershipType, Street, City, State, Zip, Phone, Email, Website, Twitter, SkillSet, Hear, Refer, Offer, Relationship, SubmissionDateTime) VALUES (:FullName, :Job, :Work, :MembershipType, :Street, :City, :State, :Zip, :Phone, :Email, :Website, :Twitter, :SkillSet, :Hear, :Refer, :Offer, :Relationship, :SubmissionDateTime)");
  
      $sql->bindParam(':FullName', $_POST['appFullName']);
      $sql->bindParam(':Job', $_POST['appJob']);
      $sql->bindParam(':Work', $_POST['appWork']);
      $sql->bindParam(':MembershipType', $_POST['appMembershipType']);
      $sql->bindParam(':Street', $_POST['appStreet']);
      $sql->bindParam(':City', $_POST['appCity']);
      $sql->bindParam(':State', $_POST['appState']);
      $sql->bindParam(':Zip', $_POST['appZip']);
      $sql->bindParam(':Phone', $_POST['appPhone']);
      $sql->bindParam(':Email', $_POST['appEmail']);
      $sql->bindParam(':Website', $_POST['appWebsite']);
      $sql->bindParam(':Twitter', $_POST['appTwitter']);
      $sql->bindParam(':SkillSet', $_POST['appSkillSet']);
      $sql->bindParam(':Hear', $_POST['appHear']);
      $sql->bindParam(':Refer', $_POST['appRefer']);
      $sql->bindParam(':Offer', $_POST['appOffer']);
      $sql->bindParam(':Relationship', $_POST['appRelationship']);
      $date = date("Y-m-d H:i:s");
      $sql->bindParam(':SubmissionDateTime', $date);
      
      $sql->execute();    
  
      /*** close the database connection ***/
      $dbh = null;
   }   
      }
  catch(PDOException $e)
      {
      echo $e->getMessage();
      }
      
  include_once "assets/lib/swift_required.php";
  
  $subject = 'MatchBOX Membership Application Confirmation';
  $from = array('hello@matchboxstudio.org' =>'MatchBOX');
  $to = array(
   $_POST['appEmail']  => $_POST['appFullName']
  );
  
  $text = "Hi " . $_POST['appFullName'] . ",  \n\n Thanks for your application. We really appreciate it. We'll be in touch in a few weeks.\n\n-The MatchBOX Team \n http://www.MatchBOXStudio.org \n http://fb.com/matchboxcowork \n https://twitter.com/matchboxcowork";
  $html = "Hi " . $_POST['appFullName'] . ", <br /><br />Thanks for your application. We really appreciate it. We'll be in touch in a few weeks.<br /><br />-The MatchBOX Team<br />http://www.MatchBOXStudio.org<br />http://fb.com/matchboxcowork<br />https://twitter.com/matchboxcowork";
  
  $smtp_host = $MBX_CONF['smtp_host'];
  $smtp_port = $MBX_CONF['smtp_port'];
  $smtp_encryption = $MBX_CONF['smtp_enc'];
  $transport = Swift_SmtpTransport::newInstance($smtp_host, $smtp_port, $smtp_encryption);
  $transport->setUsername($MBX_CONF['smtp_username']);
  $transport->setPassword($MBX_CONF['smtp_password']);
  $swift = Swift_Mailer::newInstance($transport);
  
  $message = new Swift_Message($subject);
  $message->setFrom($from);
  $message->setBody($html, 'text/html');
  $message->setTo($to);
  $message->addPart($text, 'text/plain');
  
  if ($recipients = $swift->send($message, $failures))
  {
  // echo 'Message successfully sent!';
  } else {
   echo "There was an error:\n";
   print_r($failures);
  }
?>
<!DOCTYPE html>
<html lang='en'>
  <head>
    <title>MatchBOX - Coworking Studio - A shared place to work and create in Lafayette, Indiana</title>
    <meta content='text/html; charset=UTF-8' http-equiv='Content-Type'>
    <!-- Basic Page Needs -->
    <meta charset='utf-8'>
    <meta content='Coworking Studio - A shared place to work and create in Lafayette, Indiana' name='description'>
    <meta content='coworking, co-working, cowork, co-work, office, shared, community, Lafayette, Indiana' name='keywords'>
    <link href='favicon.ico' rel='shortcut icon'>
    <!-- Mobile Specific Metas -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
    <!-- CSS -->
    <link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,600,800|Oswald:400,300,700|Source+Sans+Pro:300,400,700|Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link href='assets/css/supersized.css' rel='stylesheet'>
    <link href='assets/css/supersized.shutter.css' rel='stylesheet'>
    <link href='assets/css/base.css' rel='stylesheet'>
    <link href='assets/css/font-awesome.css' rel='stylesheet'>
    <link href='assets/css/skeleton.css' rel='stylesheet'>
    <link href='assets/css/layout.css' rel='stylesheet'>
    <link href='assets/css/prettyPhoto.css' rel='stylesheet'>
    <!-- Color CSS -->
    <link href='assets/css/mbx.css' id='default' rel='stylesheet'>
    <!-- Revolution Banner CSS Settings -->
    <link href='assets/rs-plugin/css/settings.css' media='screen' rel='stylesheet' type='text/css'>
    <!-- Load jQuery in the head so that any inline scripts have access to it -->
    <script src='//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js' type='text/javascript'></script>
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!--[if IE 7]>
      <link rel="stylesheet" href="assets/css/font-awesome-ie7.css">
      <style type="text/css">
      .page-wrapper,.footer{
      width: 100%;
      position: relative;
      }
      #break3{
      overflow: hidden;
      }
      </style>
    <![endif]-->
    <!-- Google Analytics -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      
      ga('create', 'UA-41745008-1', 'matchboxstudio.org');
      ga('send', 'pageview');
    </script>
  </head>
  <body>
    <!-- Scrolling anchor -->
    <div id='up'></div>
    <section class='home'>
      <div class='overlay'>
        <div class='super'>
          <section class='para' id='break4'>
            <div class='container message'>
              <p class='quote-block'>
                Check your inbox. We sent you a little something just to make
                sure all the bits and bytes did their thing. We'll be in touch
                soon.
              </p>
              <p>
                Head back to <a href="/">our site</a> or, better yet, <br>
                go make something awesome.
              </p>
            </div>
          </section>
        </div>
      </div>
    </section>
    <section class='menu'>
      <div class='container'>
        <div class='sixteen columns clearfix'>
          <h1 class='logo'>
            <a href='#up'>
              <img alt='MatchBOX logo' src='assets/img/theme/logo.png'>
            </a>
          </h1>
          <nav class='menu-holder'>
            <ul class='menu-list' id='main-menu'>
              <li class='active'>
                <a href='#up'>
                  Home
                  <span class='arrow'></span>
                </a>
              </li>
              <li>
                <a href='#about'>
                  About
                  <span class='arrow'></span>
                </a>
              </li>
              <li>
                <a href='#services'>
                  Join
                  <span class='arrow'></span>
                </a>
              </li>
              <li>
                <a href='#contact'>
                  Contact
                  <span class='arrow'></span>
                </a>
              </li>
              <!-- Slide panel toggle -->
              <li class='toggle-panel'>
                <a class='closed' href='#'>
                  <i class='icon-plus'></i>
                  <span class='arrow'></span>
                </a>
              </li>
            </ul>
            <!-- SubMenu -->
            <select class='sub-menu' id='subMenu' name='subMenu' onchange='moveTo(this.value)' size='1'>
              <option selected='selected' value=''>Menu</option>
              <option value='#up'>- Top</option>
              <option value='#about'>- About</option>
              <option value='#services'>- Join</option>
              <option value='#contact'>- Contact</option>
            </select>
          </nav>
        </div>
        <!-- ./sixteen columns -->
      </div>
      <!-- ./container -->
    </section>
    <script src='assets/js/jquery.scrollTo.min.js' type='text/javascript'></script>
    <script src='assets/rs-plugin/js/jquery.themepunch.plugins.min.js' type='text/javascript'></script>
    <script src='assets/rs-plugin/js/jquery.themepunch.revolution.min.js' type='text/javascript'></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/jcarousel/0.3.1/jquery.jcarousel.min.js'></script>
    <script src='assets/js/jquery.form.js'></script>
    <script src='assets/js/jquery.validate.min.js'></script>
    <script src='assets/js/scripts.js'></script>
    <script src='assets/js/supersized.3.2.7.js'></script>
    <script src='assets/js/supersized.shutter.min.js'></script>
    <script src='assets/js/jquery.prettyPhoto.js'></script>
    <script src='assets/js/main.js'></script>
    <script src='assets/js/mbx.concat.js'></script>
  </body>
</html>
