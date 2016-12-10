---
layout: post
title: Using test.check
---

At last Wednesdays clojure meetup someone mentioned using test.check.
In the discussion of it one of the nice uses mentioned was a new
implementation of an old function.  That happens to be exactly what I
was working on tonight, so I decided to experiment with a test.check
for generating a type of model.

The models I'll generate are arbitrary nestings according to the following
rules:

    [:counts {:a Number, :b Number, :c Number}]

is a model for any numbers and keywords.  And the inductive case

    [:next [:x :y :z] {"value1" model, "value2" model}]

for any sequence of keywords, string values, and models.  As an example
relating to cars and brands

    [:next [:numberdoors] {3 [:counts {:opel 5 :ford 9}]
                           5 [:counts {:opel 9 :ford 7 :vw 8}]}]

This could for instance be interpreted as that Opel had 5 cars with 3
doors in this test.

The schema (using prismatic schema) describing this all is as follows:

    (def SEvent s/Keyword)

    (def SCounts {SEvent Number})

    (def SCountsVec [(s/one (s/eq :counts) "counts") SCounts])

    (def SNestedModel
      (s/either SCountsVec
                [(s/one (s/eq :next) "next")
                 (s/one [s/Keyword] "feature")
                 (s/one {String
                         (s/either (s/recursive #'SNestedModel) SCountsVec)} "next-level")]))

So the goal for this post is to write a test.check generator that
generates everything that satisfies this schema.  The function I am
testing with this against an old version is not public, so the further
use of it won't be described.

There already are generators for keywords gen/keyword and maps gen/map, so it
is easy to write a generator for SCountsVec objects

    (def gen-counts (gen/tuple (gen/return :counts) (gen/map gen/keyword gen/int)))

To see this in action

    (gen/sample gen-counts) =>
    ([:counts {}] [:counts {:I 0}]
     [:counts {:Sl 1, :W_h -2}]
     [:counts {}]
     [:counts {:?* -4, :_d6OF -2, :kg0_ 0}]
     [:counts {:g+lSb 3, :YB95+H -4, :N?c3- -1, :b -4}]
     [:counts {:!8x -5, :r? -2, :D_- -4, :Fd -4, :-Q+S+by -1}]
     [:counts {:sQ-R 7, :T-owU+M 5, :- 2, :pkh 5, :-!w -2}]
     [:counts {:y+d 3, :XDuSCF-2t 4}]
     [:counts {:m!g*-W_D3e 1, :k3w!oA* 8, :q9c+ 0, :?uR9r+4*0 -3, :!z -5, :K??** 1, :jN_U2!33l5 7, :_6+!v 3, :H -3}])

To generate complete models turns out to be really easy (also since it
fits very well with the tree example given in the test.check
documentation).

    (defn model-fn
      [size]
      (if (zero? size)
        gen-counts
        (let [size (quot size 2)
              smaller-model  (gen/resize size (gen/sized model-fn))]
          (gen/one-of [gen-counts
                       (gen/tuple (gen/return :next)
                                  (gen/vector gen/keyword)
                                  (gen/map gen/string smaller-model))]))))

    (def model (gen/sized model))

The important thing to note here is how the size of models is dealt
with.  The size is manually shrunken, if this is not done a stackoverflow
will happen.  And if the shrinking is very slow, the objects generated will
be very big and therefore the generation very slow.

Here the full model generation is shown in action:

    (gen/sample model) =>
    ([:counts {}]
     [:next [:C] {"0" [:counts {}]}]
     [:next [:V :!!] {"" [:next [:-] {}]}]
     [:counts {:cgS_ 2}]
     [:next [:+Jtm! :X*!? :i_4Y :D0Z] {"z#" [:counts {}], "¹" [:next [] {}]}]
     [:next [:+e :hG0?!1 :PA] {"@" [:next [:* :R] {}], "" [:next [] {"TQ" [:next [] {}], "¢" [:next [:M*] {"b" [:counts {}]}]}], "8oI" [:counts {}]}]
     [:next [:?8?k? :uJ+W :L!b :U_jU7 :_] {"ºÈý" [:counts {}], "¦$" [:counts {:-+ -1}], "#à" [:counts {:f- 2, :fT-I -2, :-s4 1}], "åÐë" [:counts {}], "ñ¥l=$" [:counts {:* -1, :l*?i 2, :L+!* 0}], "ªø" [:counts {}]}]
     [:next [:?_9*10?x :QQ0*Bpdq :+F?7?] {"\r×Öü" [:counts {:u -3, :MxN* -1, :l 3}], "" [:counts {:DQ*U 1, :! -3, :?V -2}], "ßÌCv" [:next [:?S :O] {}], "yk&" [:next [:dF :T :!c_] {"bÂ1" [:counts {:! 0}]}], "å" [:counts {:m 0, :Uz 0, :EN 3}]}]
     [:next [:_d+1 :-T!] {"j¯ø" [:counts {:Nb3u -4, :P- 4, :? 3}], "Ýa®¡²ð" [:counts {:*e_E8 -4, :!nwf -2}], "1" [:counts {:v5k -3, :U3e_ 3}], "SÉIÔá»~" [:counts {:plw_I 3, :S? -1, :krhW -2, :_w! 0}], "%I¸Í°P<" [:counts {:X*+n0 0, :WPoZX -4, :U 4, :DV 4}], "6\fN" [:counts {:- 1}], "" [:counts {:x-i -2, :r23+o -2, :_2 -2, :+ 1}], "P\"ÔnU¹Á" [:counts {:*r 1}]}]
     [:counts {:+5 4, :G!-F?!9- -1, :_--3* -8, :OV_W6?Nhz4 -5}])

In these and other sample runs I did I saw lots of different models be
generated, nothing is obviously missing yet.  So I feel fairly safe in
just testing that not too much is generated:

    (facts "generate counts and models"
      (let [s  (gen/sample gen-counts)
            m  (gen/sample (gen/sized model-fn))]
        s => (has every? (comp nil? (fn [x] (s/check nested/SCountsVec x))))
        m => (has every? (comp nil? (fn [x] (s/check nested/SNestedModel x))))))

## Future work

Getting the generators set up was much easier than expected.  As
future refinements I would like to restrict the keywords generated a
bit.  To help with manual testing I would like the event keywords
read like event keywords, the feature keywords read like feature
keywords, and the feature value strings to read as feature value strings.