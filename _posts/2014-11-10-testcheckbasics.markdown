---
layout: post
title: Basic clojure/test.check Use
---

From the readme of [test.check](https://github.com/clojure/test.check): The
core idea of test.check is that instead of enumerating expected input and
output for unit tests, you write properties about your function that should
hold true for all inputs.  Here we will explore some basic uses of this
library.

There are two basic parts to clojure/test.check; first is a generator
infrastructure.  This infrastructure allows you to generate data of many
different formats.  Around this generator infrastructure there is a testing
framework.

There is a maybe even better known generation library in
clojure/data.generators.  We'll show the differences and cross use as well.

First for reproduciblity here is the namespace declaration I am working with.

{% highlight clojure %}
(ns tcplaypen.basics
  (:require [taoensso.timbre :as log]
            [plumbing.core :as plumbing]
            [schema.core :as s]
            [clojure.test.check :as tc]
            [clojure.test.check.generators :as gen]
            [clojure.test.check.properties :as prop]
            [clojure.test.check.rose-tree :as rose]
            [clojure.data.generators :as datgen])
  (:import java.util.Random))
{% endhighlight %}

And the project.clj file.

{% highlight clojure %}
(defproject tcplaypen "0.1.0-SNAPSHOT"
  :description "Test check playpen."
  :dependencies [[org.clojure/clojure "1.7.0-alpha1"]
                 [com.taoensso/timbre "3.3.1"]
                 [prismatic/plumbing "0.3.4"]
                 [prismatic/schema "0.3.1"]
                 [org.clojure/test.check "0.5.9"]
                 [midje "1.6.3"]
                 [org.clojure/data.generators "0.1.2"]]

  :plugins [[lein-midje "3.0.0"]])
{% endhighlight %}

First from both libraries some examples of basic generators.  In the
data.generators library you just call the generator and get a result; with
test.check you have to call `sample` with as argument the generator (and
optionally a number of times to call the generator; default 10).

Some of the outputs are a bit long, after enough is shown I have truncated
them with ...

{% highlight clojure %}
(gen/sample gen/int)
;; (0 1 -2 -1 -4 -1 3 -3 -1 0)
(datgen/int)
;; -407931081
(gen/sample (gen/list gen/int))
;; (() () (0 0) (1 -1 -3) (3 3) (-3 1) (-5 -5 0) (-5 3 -5 7 -3) (1 -4) (0 9))
(datgen/list datgen/int)
;; (442345428 1256272048 2105036344 -612840905 ...)
(gen/sample (gen/vector gen/int))
;; ([] [0] [-1] [0 0] [-4 0 2 2] [-2 2 -2 0] ...)
(datgen/vec datgen/int)
;; [-1393605648 -1166429411]
(gen/sample (gen/return 10))
;; (10 10 10 10 10 10 10 10 10 10)
10
;; 10
(gen/sample (gen/fmap (fn [x] (+ x 33)) (gen/return 10)))
;; (43 43 43 43 43 43 43 43 43 43)
(map (fn [x] (+ x 33)) [10 10])
;; (43 43)
(gen/sample gen/keyword)
;; (:y :CA:* :*:p :X0P:?:2!fe:A :q5fF :LoWE-I:*VD_m+  ...)
(defn small-sizer [] 2)
(datgen/keyword small-sizer)
;; :h6H
(datgen/uniform 1 20)
;; 13
(datgen/float)
;; 0.15961581468582153
(datgen/list datgen/float small-sizer)
;; (0.2816622853279114 0.841882050037384)
(datgen/bigint)
;; 14662563745106760601788546915947626615661432553384949128065358635N
(datgen/scalar)
;; "\"m:ujCm!I:2bhRObPfr?$HQ 2g)SqH]28)Vs\":cW~U~Dw(ghM "
{% endhighlight %}

You should note that mostly in both libraries it is a matter of calling
(directly or through gen/sample) `datgen/type` or `gen/type` to generate a
random item of a type.  There are a couple more things to note in the examples
above, but let us first focus on something more interesting; the randomness.

In data.generators we see the following

{% highlight clojure %}
(def ^:dynamic ^java.util.Random
     *rnd*
     "Random instance for use in generators. By consistently using this
instance you can get a repeatable basis for tests."
     (java.util.Random. 42))
{% endhighlight %}

This allows for the following

{% highlight clojure %}
(defn seeded-random [seed]
  (fn [] (java.util.Random. seed)))

(def my-rnd ((seeded-random 22)))
(binding [datgen/*rnd* my-rnd]
  (datgen/i]nt))
;; 997385540
(binding [datgen/*rnd* my-rnd]
  (datgen/int))
;; 1575887385
{% endhighlight %}

The different datgen calls use the same source of randomness, so the sequence
of different calls will always have identical results.

The other functionality in data.generators is that some of its generators take
a `sizer` argument, that helps determine the size of the resulting object.
This holds in particular for the collection generators.

This essentially describes all of data.generators.  An easy to use library to
generate random items; with good repeatability build in.  See
[github//generators.clj](https://github.com/clojure/data.generators/blob/master/src/main/clojure/clojure/data/generators.clj)
for all details (this library consists of the one file).  Note that of course
you can use the functions there to build much more complicated data
generators.

In test.check you can control the source of randomness as follows

{% highlight clojure %}
(with-redefs [gen/random (seeded-random 22)]
  (gen/sample gen/int))

(def my-rnd-fn (seeded-random 33))
(with-redefs [gen/random my-rnd-fn]
  (gen/sample gen/int))
{% endhighlight %}

Note that this is why seeded-random returns a thunk; it is what gen/random
needs to be for test.check See
[github//generators::145](https://github.com/clojure/test.check/blob/master/src/main/clojure/clojure/test/check/generators.clj#L145)
for sample, and sample-seq just above, for the the details of the use of
gen/random.

To get an integer generation similar to what datgen/int does with test.check
you can do something like the following; where you do have to give a size to
the integer generator.  This will generate an integer in the range [-200,200].

{% highlight clojure %}
(first (gen/sample (gen/resize 200 gen/int) 1))
{% endhighlight %}

Before we analyse this a little further you might have noticed we didn't
use `gen/double`.  This is because it is missing.  Here is a general
method to use any datgen generator with test.check

{% highlight clojure %}
(def gen-double
  (gen/make-gen
   (fn [rnd size]
     (binding [datgen/*rnd* rnd]
       (rose/pure (datgen/double))))))

(gen/sample gen-double 3)
;; (0.07490676184081779 0.48055986332988176 0.25519720363003096)
{% endhighlight %}

Note the importance of binding datgen/*rnd* to keep using the same source of
randomness.  If you do not do this the run will not be repeatable.

Also note that this does not at all depend on datgen/double being a special
function.  Any function that generates a value will do; although without extra
work as mentioned (but not detailed) below you will miss some of the special
sauce that `test.check` provides.

If you look through the sources to figure out what happens above you find that
a generator is a function that takes arguments `rnd` and `size` that is
wrapped in a `Generator` record.  `gen/make-gen` just does this wrapping.  For
the rose/pure part, lets first look at `sample` some more.  In there we find
the function call-gen to execute a generator.  The function call-gen unpacks a
Generator and applies it to the rnd and size arguments, so it would seem that
the above would be similar to the following two calls.

{% highlight clojure %}
(gen/call-gen gen/int ((seeded-random 33)) 10)
((:gen gen/int) ((seeded-random 33)) 10)
{% endhighlight %}

If you run either of these you get

{% highlight clojure %}
[5 ([0 ()]
    [3 ([0 ()]
        [2 ([0 ()]
        [1 ([0 ()])])])]
    [4 ([0 ()]
        [2 ([0 ()]
            [1 ([0 ()])])]
        [3 ([0 ()]
            [2 ([0 ()]
                [1 ([0 ()])])])])])]
{% endhighlight %}

which is a tree, and not 5 which is the result of

{% highlight clojure %}
(with-redefs [gen/random (seeded-random 33)]
  (gen/sample (gen/resize 10 gen/int) 1))
;; (5)
{% endhighlight %}

This is why we needed a `rose/pure` above, and where a lot of the power of
test.check comes from.

First a summary of what I hope you have learned about test.cehck from the
above.  There are a bunch of basic generators (I count gen/list and related as
part of the basic generators).  These generators take a randomness source and
a size as arguments.  When we call a generator it returns a tree structure,
not the expected value.

A typical use of `test.check` is as follows

{% highlight clojure %}
(tc/quick-check 100
                (prop/for-all [n gen/int]
                              (even? (* 2 n))))
;; {:result true, :num-tests 100, :seed 1415538215371}
{% endhighlight %}

We run a 100 iterations of checking the property that for every integer, if we
multiply it by 2 it is even.  As expected the result is true, we run 100
iterations, and the seed was as given.  Note that this is the usual way to
deal with randomness in `test.check`.  We don't set the randomness source, we
let `test.check` do that; and in case of problems using the seed it reports we
can reproduce the problems by setting the randomness.

Still with `data.generators` we can achieve the same very easily.

{% highlight clojure %}
(every? even? (map (fn [x] (* 2 x)) (repeatedly 100 datgen/int)))
{% endhighlight %}

Now however lets try a failing test.

{% highlight clojure %}
(s/defn almost-sort [s :- #{s/Int}]
  (let [has42      (contains? (set s) 42)
        without42  (clojure.set/difference s #{42})]
    (log/info without42)
    ((if has42
       (comp reverse (partial into (list 42)))
       identity)
     (sort without42))))

(defn sorted [[f s & _ :as inlist]]
  (or (nil? s)
      (and (not (> f s))
           (sorted (rest inlist)))))

(tc/quick-check 100
                (prop/for-all [v (gen/fmap set (gen/vector gen/int))]
                              (sorted (almost-sort v))))
;; {:result false,
;;  :seed 1415538737362, :failing-size 51, :num-tests 52,
;;  :fail [#{-12 -24 -4 -32 27 1 -25 -20 -49 -1 -8 48 32 40 33 -34 -3 41 -43 -50 29
;;          -31 28 -44 -48 51 17 2 -7 -47 11 -10 16 -40 30 -18 10 18 42 8}],
;; :shrunk {:total-nodes-visited 68, :depth 50, :result false, :smallest [#{0 42}]}}
{% endhighlight %}

The function `almost-sort` sorts a vector of ints, unless 42 appears in the
vector.  If 42 appears it sorts the rest, but puts 42 in front.  The output of
`quick-check` shows that the property failed, that the failing input found was
\#{-12 -24 -4 -32 27 1 -25 -20 -49 -1 -8 48 32 40 33 -34 -3 41 -43 -50 29 -31
28 -44 -48 51 17 2 -7 -47 11 -10 16 -40 30 -18 10 18 42 8}, but that the
shrunk failing input is \#{0 42}.  So given the randomly generated set on
which the function failed, quick-check looked for ways to shrink the failing
input to give you a small example to work with.

This is exactly the use of the trees seen earlier.  These rose trees (trees
with arbitrary branching) have at their root the generated value, and as other
values the different ways of shrinking this generated value.

If you look at (with rather abbreviated output)

{% highlight clojure %}
(gen/call-gen (gen/vector gen/int) (java.util.Random.) 3)
;; [[2 -2 -2] ([[-2 -2] ([[-2] ([[] []] [[0] ([[] []])] [[-1] .......
{% endhighlight %}

You notice that the list [-2 -2 -2] was generated, and the shrinking goes in
two directions.  The list can be made shorter, but also the elements in the
list can be shrunk.

{% highlight clojure %}
(#'gen/shrink-int -2)
;; (0 -1)
{% endhighlight %}

Integers are shrunk by deviding by 2.  If you want to use another shriking
(using just dec on the integer does not seem unreasonable) you'd have to
implement it yourself.

Recently I played with some unshrinkable trees; to make them shrinkable I
would have to build up the rose tree with all options to shrink them.  For
trees many different shrinkings are imaginable (removing the root and taking a
tree from the resulting forrest, removing leaves, removing levels, ...).

Before we finish with how to use this with `clojure.test` and `midje` a
summary of the second part.  Using generators you can write properties that
should always be true.  `test.check` can generate random values to test with,
and then shrink the result to give small counter examples to do further
development with.

For `clojure.test` there is integration build in, from the readme

{% highlight clojure %}
(defspec first-element-is-min-after-sorting ;; the name of the test
         100 ;; the number of iterations for test.check to test
         (prop/for-all [v (gen/not-empty (gen/vector gen/int))]
           (= (apply min v)
              (first (sort v)))))
{% endhighlight %}

For `midje` you just have to test the result of tc/quick-check.  The following
two examples show how to do that.

{% highlight clojure %}
(use 'midje.sweet)

(fact "test use of quickcheck"
      (tc/quick-check 100
                      (prop/for-all [v (gen/fmap set (gen/vector gen/int))]
                                    (sorted (sort v))))
      => (just {:result true :num-tests 100 :seed anything}))

(fact "failing use of quickcheck"
      (tc/quick-check 100
                      (prop/for-all [v (gen/fmap set (gen/vector gen/int))]
                                    (sorted (almost-sort v))))
      => (just {:result true :num-tests 100 :seed anything}))
{% endhighlight %}

Note that very importantly, if you use quick-check this way, the output of
midje will give you all the information you want.  You get the failing
example, the shrunk version of it, and the randomness seed that was used.

{% highlight clojure %}
FAIL "failing use of quickcheck" at (basics.clj:210)
Actual result did not agree with the checking function.
        Actual result: {:fail [#{-42 -39 -37 -34 -31 -26 -20 -15 -8 -7 -6 -5 -3 8 11 13 14 39
 42}], :failing-size 42, :num-tests 43, :result false, :seed 1415543913142, :shrunk {:depth 2
0, :result false, :smallest [#{0 42}], :total-nodes-visited 53}}
    Checking function: (just {:num-tests 100, :result true, :seed anything})
    The checker said this about the reason:
        Expected three elements. There were six.
{% endhighlight %}






