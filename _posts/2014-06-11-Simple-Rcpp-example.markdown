---
layout: post
---

A while ago Dirk Eddelbuettel gave a talk in the Orange County R users
group about Rcpp.  At the time I was busy with other things and I
skipped watching.  Finally I went and watched the talk.  Seemed like
a really nice package, but what to do with it in practice?

Well, the following is a simplified example of a problem I had to
solve (which was simple too): Compute a Fibonacci type sequence with a
varying number of offspring.  Since I have been mostly working with
R that seemed like the language to use.  Unfortunately, the solution
was really slow (even with memoization, which I can't quite explain
why it doesn't give a speedup; I'll get back to that later).  But
using Rcpp I could use the C++ solution right in R with really simple
code:

    library(memoise)
    library(Rcpp)
    
    get.rabbits <- function(weeks, offspring) {
      if (weeks <= 2) {
        1
      } else {
        get.rabbits(weeks - 1, offspring) + offspring * get.rabbits(weeks - 2, offspring)
      }
    }
    
    gr <- memoise(get.rabbits)
    
    cppFunction("long long grcpp(long long weeks, long long offspring)
         { if (weeks <= 2) return 1;
           else return grcpp(weeks-1, offspring) +
              offspring * grcpp(weeks-2, offspring);}")

The timings are for get.rabbits(40,5) 234 seconds, for gr(40,5) (first
call) 227 seconds, for grcpp(40,5) 0.6 seconds.  That is what you call
a speedup; and with Rcpp easily achieved.

UPDATE: the memoization not speeding things up is because the
memoization function only adds a table to the function on the outside.
It doesn't go in and replace the recursive calls to the memoized
version of the function.