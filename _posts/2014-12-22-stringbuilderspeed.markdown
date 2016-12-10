---
layout: post
title: Stringbuilder speedup.
---

I am working on improving my java experience.  Running into the
[StringBuilder](http://docs.oracle.com/javase/8/docs/api/java/lang/StringBuilder.html)
class, I wondered what the speedup would be.  The example I decided to work
with was a full binary tree, and making a text representation of it.  A full
binary tree grows exponentially depending on its size, so should be easy to
generate long strings from this.

If we have a full binary tree of depth \\(n\\) we have a tree with \\(2^n\\)
leaf nodes and \\(2^n - 1\\) internal nodes.  The string representation I
chose would therefore be of length \\(3 (2^n - 1) + 2 \, 2^n\\).  I use the
two implementations shown in [FullBinTree 2
String](https://github.com/kasterma/basicprogramming/blob/develop/algorithms/stringbuilder/src/net/kasterma/stringbuilder/FullBinaryTree.java).

A quick analysis shows that `toString1` has \\(\sim 2^n\\) new object
allocations, and `toString2` has one `StringBuilder` that gets enlarged
\\(\sim n\\) times.  Clearly both implementations have an exponential
component (since they need to visit all nodes of the tree), but if the object
creation is the main factor `toString2` should look linear in the area we can
test it.

Actual results are that the `StringBuilder` version is about two times faster
than the version that using string concatenation with `+` (you can't say the
version that doesn't use `StringBuilder` since if you look at the bytecode you
see the sequence of `+` is compiled into creating a `StringBuilder` and
repeatedly adding to it).

I tried to use Coda Hale's
[metrics](https://dropwizard.github.io/metrics/3.1.0/) library to extract more
information, but this example seems too light to add additional measuring to
it without influencing the results.
