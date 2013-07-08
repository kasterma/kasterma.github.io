<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>
 Bart Kastermans Files.
</title>

<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
<meta name="author" content="Bart Kastermans" />
<meta name="description" content="Links to files of articles and slides." />

<link rel="stylesheet" type="text/css" href="bkstyle.css" />
<style type="text/css">sup.double {vertical-align: 1.2ex}</style>
<style type="text/css">sub.double {margin-left: -1ex; vertical-align: -0.5ex}</style>

<?php include ("menudf.incl"); ?>

<?php writemenufunctions ($onbartk); 
      echo "\n";
      writemenufunctions ($elsewhere); ?>

<script type="text/javascript">
function showabstract(idx) {
   document.getElementById("abstract" + idx).style.display = "block";
}

function hideabstract(idx) {
   document.getElementById("abstract" + idx).style.display = "none";
}

function flipabstract(idx) {
  var abstract = document.getElementById("abstract" + idx);
  if (abstract.style.display == "block") {
    abstract.style.display = "none";
  } else {
    abstract.style.display = "block";
  }
}
</script>

</head>

<body>

<?php
$active = "files";
include ('menu.php'); ?>

<div class="content">

<ul>
  <li class="paper">
   <div class="box">
    My Thesis: Cofinitary Groups and Other Almost Disjoint Families
    (written under supervision of Andreas Blass and Yi Zhang)
    <a href="papers/thesis.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(1); return false;">abstract</a>


    <blockquote id="abstract1" style="display:none">
      <i>Abstract:</i>
      We study two different types of (maximal) almost disjoint
      families: very mad families and (maximal) cofinitary groups. For
      the very mad families we prove the basic existence results. We
      prove that MA implies there exist many pairwise orthogonal
      families, and that CH implies that for any very mad family there
      is one orthogonal to it. Finally we prove that the axiom of
      constructibility implies that there exists a coanalytic very mad
      family. <br />

      Cofinitary groups have a natural action on the natural
      numbers. We prove that a maximal cofinitary group cannot have
      infinitely many orbits under this action, but can have any
      combination of any finite number of finite orbits and any finite
      (but nonzero) number of infinite orbits. <br />

      We also prove that there exists a maximal cofinitary group into
      which each countable group embeds. This gives an example of a
      maximal cofinitary group that is not a free group. We start the
      investigation into which groups have cofinitary actions. The
      main result there is that it is consistent that the direct sum
      of &aleph;<sub>1</sub> many copies of Z<sub>2</sub> has a
      cofinitary action. <br />

      Concerning the complexity of maximal cofinitary groups we prove
      that they cannot be K<sub>&sigma;</sub>, but that the axiom of
      constructibility implies that there exists a coanalytic maximal
      cofinitary group. We prove that the least cardinality
      a<sub>g</sub> of a maximal cofinitary group can consistently be
      less than the cofinality of the symmetric group. <br />

      Finally we prove that a<sub>g</sub> can consistently be bigger
      than all cardinals in Cichon's diagram.
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    Cardinal Invariants Related to Permutation Groups, with Yi Zhang
    (Ann. Pure Appl. Logic 143 (2006), pp. 139-146)
    <a href="papers/DiamondPermutations.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(2); return false;">abstract</a>


    <blockquote id="abstract2" style="display:none">
      <i>Abstract:</i>
      We consider the possible cardinalities of the following three
      cardinal invariants which are related to the permutation group
      on the set of natural numbers: <br />

      a<sub>g</sub> := the least cardinal number of maximal cofinitary
      permutation groups; <br />

      a<sub>p</sub> := the least cardinal number of maximal almost disjoint
      permutation families; <br />

      c(Sym(N)) := the cofinality of the permutation group
      on the set of natural numbers. <br />

      We show that it is consistent with ZFC that a<sub>p</sub> =
      a<sub>g</sub> &lt; c(Sym(N)) = 2; in fact we show that in the
      Miller model a<sub>p</sub> = a<sub>g</sub> = &aleph;<sub>1</sub>
      &lt; &aleph;<sub>2</sub>= c(Sym(N)).
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    Very Mad Families  (published in Contemporary Mathematics 425, Advances in
    Logic, The North Texas Logic Conference, October 8-10, 2004,
    University of North Texas, Denton, Texas, edited by Su Gao, Steve
    Jackson, and Yi Zhang, pp.  105-112)
    <a href="papers/vmad_exist.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(3); return false;">abstract</a>


    <blockquote id="abstract3" style="display:none">
      <i>Abstract:</i>
      The notion of very mad family is a strengthening of the notion
      of mad family of functions. Here we show existence of very mad
      families in different contexts.
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    Analytic and Coanalytic Families of Almost Disjoint Functions,
    with Juris Steprans and Yi Zhang (JSL, Vol. 73 (2008), no. 4,
    pp. 1158-1172)
    <a href="papers/madKSZ.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(4); return false;">abstract</a>

    <blockquote id="abstract4" style="display:none"> 
      <i> Abstract:</i> 
      If F <font face="Symbol">&#204;</font> N<sup>N</sup> is an
      analytic family of pairwise eventually different functions then
      the following strong maximality condition fails: For any
      countable H <font face="Symbol">&#204;</font> N<sup>N</sup>, no
      member of which is covered by finitely many functions from F,
      there is f <font face="Symbol">&#206;</font> F such that for all
      h <font face="Symbol">&#206;</font> H there are infinitely many
      integers k such that f(k) = h(k). However if V = L then there
      exists a coanalytic family of pairwise eventually different
      functions satisfying this strong maximality condition.
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    The Complexity of Maximal Cofinitary Groups (Proceedings AMS, Vol. 137
    (2009), no. 1, pp. 307-316)
    <a href="papers/pi11mcg.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(5); return false;">abstract</a>

    <blockquote id="abstract5" style="display:none">
      <i>Abstract:</i>
      A cofinitary group is a subgroup of the infinite symmetric group
      in which each element of the subgroup has at most finitely many
      fixed points.  A maximal cofinitary group is a cofinitary group
      that is maximal with respect to inclusion. We investigate the
      possible complexities of maximal cofinitary groups, in
      particular we show that (1) under the axiom of constructibility
      there exists a coanalytic maximal cofinitary group, and (2)
      there does not exist an eventually bounded maximal cofinitary
      group. We also suggest some further directions for
      investigation.
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    Comparing Notions of Randomness, with Steffen Lempp.
    (Theoretical Computer Science, Vol. 411 (2010), no. 3, pp. 602-616)
    <a href="papers/injrandom-hr.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(6); return false;">abstract</a>

    <blockquote id="abstract6" style="display:none">
      <i>Abstract:</i>
      It is an open problem in the area of effective (algorithmic)
      randomness whether Kolmogorov-Loveland randomness coincides with
      Martin-L&ouml;f randomness. Joe Miller and Andr&eacute; Nies
      suggested some variations of Kolmogorov-Loveland randomness to
      approach this problem and to provide a partial solution. We show
      that their proposed notion of injective randomness is still
      weaker than Martin-L&ouml;f randomness. Since in its proof some
      of the ideas we use are clearer, we also show the weaker theorem
      that permutation randomness is weaker than Martin-L&ouml;f
      randomness.
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    Stability and Posets, with Carl G. Jockusch, Jr., Steffen Lempp,
    Manuel Lerman, and Reed Solomon (JSL, 74 (2009), no. 2, pp
    693-711)
    <a href="papers/stableposets.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(7); return false;">abstract</a>

    <blockquote id="abstract7" style="display:none">
      <i>Abstract:</i>
      Hirschfeldt and Shore have introduced a notion of stability for
      infinite posets. We define an arguably more natural notion
      called weak stability, and we study the existence of infinite
      computable or low chains or antichains, and of infinite
      &Pi;<sup>0</sup><sub>1</sub>-chains and antichains, in infinite
      computable stable and weakly stable posets.  For example, we
      extend a result of Hirschfeldt and Shore to show that every
      infinite computable weakly stable poset contains either an
      infinite low chain or an infinite computable antichain. Our
      hardest result is that there is an infinite computable weakly
      stable poset with no infinite
      &Pi;<sup>0</sup><sub>1</sub>-chains or antichains. On the other
      hand, it is easily seen that every infinite computable stable
      poset contains an infinite computable chain or an infinite
      &Pi;<sup>0</sup><sub>1</sub>-antichain.  In Reverse Mathematics,
      we show that SCAC, the principle that every infinite stable
      poset contains an infinite chain or antichain, is equivalent
      over RCA<sub>0</sub> to WSCAC, the corresponding principle for
      weakly stable posets.
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    On Computable Self-Embeddings of Computable Linear Orderings, with
    Rodney G. Downey, and Steffen Lempp (JSL, Volume 74, Issue 4
    (2009), pp. 1352-1366)
    <a href="papers/etaself.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(8); return false;">abstract</a>

    <blockquote id="abstract8" style="display:none">
      <i>Abstract:</i>
      We make progress toward solving a long-standing open problem in
      the area of computable linear orderings by showing that every
      computable &eta;-like linear ordering without an infinite
      strongly &eta;-like interval has a computable copy without
      nontrivial computable self-embedding.

      The precise characterization of those computable linear
      orderings which have computable copies without nontrivial
      computable self-embedding remains open.
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    Isomorphism Types of Maximal Cofinitary Groups (BSL, September
    2009, Volume 15, pp. 300-319)
    <a href="papers/IsoTypes.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(9); return false;">abstract</a>

    <blockquote id="abstract9" style="display:none">
       <i>Abstract:</i>
       A cofinitary group is a subgroup of Sym(N) where all
       nonidentity elements have finitely many fixed points. A maximal
       cofinitary group is a cofinitary group, maximal with respect to
       inclusion. We show that a maximal cofinitary group cannot have
       infinitely many orbits. We also show, using Martin's Axiom,
       that no further restrictions on the number of orbits can be
       obtained. We show that Martin's Axiom implies there exist
       locally finite maximal cofinitary groups.  Finally we show that
       there exists a uniformly computable sequence of permutations
       generating a cofinitary group whose isomorphism type is not
       computable.
    </blockquote>
   </div>
  </li>

  <li class="paper">
   <div class="box">
    An Example of a Cofinitary Group in Isabelle/HOL (In: G. Klein,
    T. Nipkow, and L. Paulson (ed), The Archive of Formal Proofs, <a
    href="http://afp.sourceforge.net/entries/CofGroups.shtml">http://afp.sourceforge.net/entries/CofGroups.shtml</a>,
    August 2009, Formal proof development)
    <a href="papers/CGIsabelle.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(10); return false;">abstract</a>

    <blockquote id="abstract10" style="display:none">
      <i>Abstract:</i>
      We formalize the usual proof that the group generated by the
      function k &mapsto; k+1 on the integers gives rise to a
      cofinitary group.
    </blockquote>
   </div>
  </li>
  <li class="paper">
   <div class="box">
    Questions on Cofinitary Groups (submitted), with Yi Zhang
    <a href="papers/QuestionsCG.pdf">pdf file</a>
    <a href="show_abstract" onclick="flipabstract(11); return false;">abstract</a>

    <blockquote id="abstract11" style="display:none">
      <i>Abstract:</i>
      A cofinitary group is a subgroup of the symmetric group on the
      natural numbers in which all non-identity members have finitely
      many fixed points.  In this note we describe some questions
      about these groups that interest us; questions on related
      cardinal invariants and isomorphism types.
    </blockquote>
   </div>
  </li>
</ul>

</body>

</html> 
