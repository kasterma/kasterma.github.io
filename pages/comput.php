<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>
  Bart Kastermans Computing Page
</title>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="Bart Kastermans' Computing Page: LaTeX snippets"></meta>
<meta name="keywords" content="Bart, Kastermans, Bart Kastermans, LaTeX"></meta>

<link rel="stylesheet" type="text/css" href="bkstyle.css"></link>

<?php include ("menudf.incl"); ?>

<?php writemenufunctions ($onbartk); 
      echo "\n";
      writemenufunctions ($elsewhere); ?>

</head>

<body>

<?php $active = "comput"; include ('menu.php'); ?>

 <div class="content_ep">

<div class="cbox">
<h2 class="ctitle">
  Webpages
</h2>

<ul>
  <li>
    <a href="https://github.com/kasterma/vo_scores">vo_scores</a>: a php and mysql
    program to get soccer scores through xml, parse and put them in the database.
    Then some scripts to generate the static tables to be included in the final
    webpage.
  </li>
  <li>
    <a href="https://github.com/kasterma/homepage">homepage</a>: the html, css,
    and javascript code for my webpages.  Also includes the python code to
    fetch, parse, and generate the tweet/google+/github stream on the main
    page.
  </li>
</div>

<div class="cbox">
<h2 class="ctitle">
  MIX
</h2>

<p>
While
reading <a href="http://www-cs-faculty.stanford.edu/~knuth/taocp.html">The
    art of computer programming, Vol. 1</a> I decided to get some
experience with writing code for the mythical MIX machine.  The
following are the results of this.
</p>

<ul>
  <li>
    <a href="https://github.com/kasterma/mixmemoize/blob/master/mixmemoize.mixal">Memoization in MIX</a>.
  </li>
  <li>
    <a href="https://github.com/kasterma/mixregexp/blob/master/mixregexp.mixal">Thompson NFA in MIX</a>.
  </li>
  <li>
    <a href="https://github.com/kasterma/mixrecursion/blob/master/recursion.mixal">Recursion in MIX</a>.
  </li>
  <li>
    Initially I stored the above MIX code on my own pages, this meant I needed
    a MIX brush for <a href="http://alexgorbatchev.com/SyntaxHighlighter/">Syntax
    Highlighter</a>.  This is now available at <a href="https://github.com/kasterma/mixbrush/blob/master/mixbrush.js">kasterma/mixbrush</a>.
  </li>
</ul>
</div>


<div class="cbox">
<h2 class="ctitle">
  Particle Filter
</h2>

<p>
I wrote a <a href="https://github.com/kasterma/ai-class/blob/master/particle/particle.R">particle filter</a> in R.
</p>
</div>


<div class="cbox">
<h2 class="ctitle">
  Hadoop Map-Reduce
</h2>

<p>
I implemented all MapReduce Algorithms mentioned in the
<a href="http://www.cloudera.com/resource/mapreduce_algorithms/">Cloudera
        MapReduce Training video</a>  (that is finding the max, counting words,
making an index, searching through files, computing joins, sorting files, and 
the term frequence inverse document count algorithm).  Files can be seen at
<a href="https://github.com/kasterma/hadoop-exper">kasterma/hadoop-exer</a>.
</p>
</div>


<div class="cbox">
<h2 class="ctitle">
  Backing up
</h2>

<p>
        For a long time I used a <a href="https://bitbucket.org/kasterma/backup/">python script</a> for backing up.  Now using git and github most of my stuff is already frequently backed up, so the need for this script has disappeared.
</p>
</div>

<div class="cbox">
<h2 class="ctitle">
  Hardware
</h2>

<ul>
  <li>
    <a href="lcdreplacement.php">Moving an LCD from iBook to
    Powerbook</a>
  </li>
  <li>
    <a href="betterteatimer.php">A Better Tea Timer</a>
  </li>
</ul>
</div>

<div class="cboxlast">
<h2 class="ctitle">
  Math Circle
</h2>

<p>
Some code and a link related to a talk I gave in the Math Circle.
</p>

<ul>
  <li>
    <a href="mcTuring.php">Turing machines in python</a>
  </li>
  <li>
    <a href="mcGoedel.php">Goedel numbering in Python</a>
  </li>
  <li>
    <a href="http://en.wikipedia.org/wiki/Turing_machines">Wikipedia
    on Turing Machines.</a>
  </li>
</ul>
</div>

</div>

</body>

</html>

