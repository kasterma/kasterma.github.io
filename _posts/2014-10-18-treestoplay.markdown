---
layout: post
title: Generating Large Trees to Play In.
---

I have been working at understanding Huet's Zippers.  To do some proper
testing of the code I have written, I need some large trees to play in.
This post is about generating these trees with `org.clojure/test.check`.

It has been a while since I used test.check, so I'll be following
[the guide](https://github.com/clojure/test.check/blob/master/doc/intro.md).
Here on first scan I see that was a good idea anyway since: "NOTE: Writing
recursive generators was significantly simplified in version 0.5.9."  When
really trying to use it, it turned out that I had forgotten too much to
make an easy start.  However, once I got to understand the new recursive
generator, it was easy.

Here it is:

{% highlight clojure %}
(def compound (fn [inner-gen]
                (gen/not-empty (gen/map gen/keyword inner-gen))))
(def scalar-tree (gen/recursive-gen compound gen/nat))
{% endhighlight %}

Using this we can generate a tree as intended (and by chaning the value 10 to
a large value we can get large trees indeed)

{% highlight clojure %}
(gen/sample (gen/resize 10 scalar-tree) 2)
{% endhighlight %}

which gives us

{% highlight clojure %}
({:ch- {:i:6:!O? {:cyum:gVk:*:407 2,
                  :Y 8,
                  :!2_?:c?LT:_EJO 0}}}
 {:+*9t:GJ {:L7R:+:9 {:hr*:G {:o9:+X1 2},
                      :kz {:q:w:_fp_n:Co0sn 10,
                           :X*5:_!0:9 8,
                           :*_0+9:!:*1:e:*Tq 8}}},
  :_+9:Vwe:0-:20*D:_ {:R:f {:A2:0SjMt:!9+!J:I+3+ {:+9E:30_:- 0,
                                                  :H 2}}}})
{% endhighlight %}

Using this here is a property for zippers (if you have a nonempty tree, make it into a
zipper, go down the first key, then back up; after all that, the current value is the
original tree) and its test

{% highlight clojure %}
(def downup-is-id
  (prop/for-all [t (gen/not-empty scalar-tree)]
                (let [k (first (keys t))]
                  (= t (get-cur (up (down (zipper t) k)))))))

(tc/quick-check 100 downup-is-id)
{% endhighlight %}
