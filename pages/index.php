<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>

  <title>
    Bart Kastermans: Home Page
  </title>

  <meta http-equiv="content-type" 
        content="text/html; charset=ISO-8859-1" />

  <meta name="description" 
        content="Bart Kastermans' home page: contains a presentation
                 of myself, contact information, CV and some
                 information for students." />

  <meta name="keywords" 
        content="Bart, Kastermans, Bart Kastermans, contact info, home
                 page, homepage, email address, email, bkasterm,
                 bkaster, kasterma" />

  <link rel="stylesheet" 
        type="text/css"
        href="bkstyle.php" />

   <?php include ("menudf.incl"); ?>

   <?php writemenufunctions ($onbartk);
   echo "\n";
    writemenufunctions ($elsewhere); ?>

</head>

<body>

<?php
$active = "index";
include ('menu.php');
?>

<div class="content">

 <table cellspacing="20" class="hptopbox">
 <tr style="height:300px;">
  <td class="hpbox">
   <img class="mypic"
        src="images/me.jpg" />
   <p> 
     I am a software developer at CoachR Development in Dodewaard, Netherlands.
   </p>

   <p>
     In 2006 I received a PhD in Mathematics at the University of Michigan, Ann Arbor.  After that I was a postdoc at the University of Wisconsin, Madison, and then an Assistant Professor at the University of Colorado, Boulder.
     </p>

     <p>
    My mathematical work has been in Set Theory (almost disjoint type
    families) and Computability theory (effective randomness and
    reverse mathematics).
   </p>

  </td>
  <td width="40%" class="hpbox">
   <p>
    Bart Kastermans<br />
    CoachR Development<br />
    Edisonring 4-b<br />
    6669 NB, Dodewaard<br />
    Netherlands
   </p>

   <p>
    Email: kasterma@kasterma.net
   </p>
  </td>
 </tr>
 </table>


 <div class="hpitemlist">
  <?php include('out.html'); ?>
 </div>

</div>

</body>

</html>
