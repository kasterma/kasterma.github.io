<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>
  Bart Kastermans Computing Page
</title>

<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="description" content="Bart Kastermans' Computing Page: LaTeX snippets"></meta>
<meta name="keywords" content="Bart, Kastermans, Bart Kastermans, LaTeX"></meta>

<link rel="stylesheet" type="text/css" href="bkstyle.php"></link>

<?php include ("menudf.incl"); ?>

<?php writemenufunctions ($onbartk); 
      echo "\n";
      writemenufunctions ($elsewhere); ?>

</head>

<body>

<?php $active = "cv"; include ('menu.php'); ?>

 <div class="content_ep">

<div class="cbox">
<blockquote>
I am an Assistant Professor at the University of Colorado with a
longstanding interest in information technology looking for a position
with a great team solving challenging practical problems.
</blockquote>
</div>

<div class="cbox">
<h2 class="ctitle">
        Technologies
</h2>

<p>
Development experience: python, php, R, javascript, C, Java, assembler,
clojure, the hadoop framework, ML, Octave (matlab), HTML, CSS, and
SQL.
</p>

<p>
Experience: Windows, OS X, and Linux.
</p>

<p>
In the last year I have taken a variety of relevant online courses
     (courses marked with <sup>&oplus;</sup> are in progress):
<dl>
<dt>With the coursera initiative by Stanford University:</dt>
<dd>Artificial Intelligence, Databases, Machine Learning, Cryptography<sup>&oplus;</sup>, Graphical
Probabilistic Models<sup>&oplus;</sup>, Natural Language Processing<sup>&oplus;</sup>.</dd>
<dt>With udacity:</dt>
<dd> Programming a Robotic Car.</dd>
<dt>With MIT:</dt>
<dd>Circuits and Electronics 6.002x<sup>&oplus;</sup>.</dd>
</dl>
</p>

<p>
<a href="https://github.com/kasterma">https://github.com/kasterma</a>
contains some code I have written.  Example repositories:
<dl>
<dt>ai-class/particle:</dt>
<dd>R implementation of a particle filter.</dd>
<dt>vo_scores:</dt>
<dd>PHP and MySQL code to fetch, store, and present up to date soccer scores.</dd>
<dt>robotCar:</dt>
<dd>Python code implementing A<sup>*</sup>-search for route planning
  for a robot car</dd>
<dt>mixregexp:</dt>
<dd>MIX implementation of Thompson NFA for regular
  expressions</dd>
</dl>

</div>


<div class="cbox">
<h2 class="ctitle">
        Previous Positions
</h2>

<dl>
<dt>2009 --- 2012</dt>
<dd> <b>Assistant Professor</b>, University of
Colorado, Boulder.</dd>

<dt>2006 --- 2009</dt>
<dd>Van Vleck Visiting <b>Assistant
  Professor</b>, University of Wisconsin, Madison.</dd>

<dt>2006</dt>
<dd>Graduate Student <b>Instructor</b>, University of
Michigan, Ann Arbor.</dd>

<dt>2005</dt>
<dd> <b>Visiting Scholar</b>, Sun Yat-Sen University,
Guangzhou, China.</dd>

<dt>2000 --- 2004</dt>
<dd>Graduate Student <b>Instructor</b>,
University of Michigan, Ann Arbor.</dd>
</dl>

<p>
All these positions had research in mathematical logic (set theory and
computability theory) as the main component.  They also involved
teaching a variety of classes at both undergraduate and graduate
levels, and administration (including organizing conferences).
</p>

</div>


<div class="cbox">
<h2 class="ctitle">
  Education
</h2>

<dl>
<dt>2000 --- 2006</dt>
<dd>University of Michigan, Mathematics, <b>PhD</b>.</dd>

<dt>1999</dt>
<dd>Mathematical Research Institute, Master Class in
Mathematical Logic (with honors).</dd>

<dt>1995 --- 2000</dt>
<dd>Vrije Universiteit Amsterdam, Mathematics,
<b>MSc</b> (with honors)</dd>
</dl>

</div>


<div class="cbox">
<h2 class="ctitle">
  Short Research Description
</h2>

<p>
In <emph>The Complexity of Maximal Cofinitary Groups</emph> I study how simple
certain algebraic objects can be.  I prove that a standard
construction of a Turing machine (computer program) is impossible, but
that a Turing machine that gets an additional input as a hint can
complete the construction.
</p>

<p>
In <emph>Comparing Notions of Randomness</emph> we study formalizations of
effective randomness.  These formalizations are analogous to
definitions of pseudo random generator, replacing polynomial time
computable by computable.
</p>

<p>
In <emph>An Example of a Cofinitary Group in Isabelle/HOL</emph> I formalize a
construction of a group.  That is, I take the usual proof as given,
and using the Isabelle/HOL system formalize it into a proof that has
been checked by computer.
</p>

</div>

</div>

</body>

</html>
