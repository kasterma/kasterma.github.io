---
layout: post
title: Zipper speedup.
---

A zipper is an interesting data structure; this is a short description of our
understanding about its use.  We have not had a real occasion to use it, but
now feel ready to spot it when it userful.

The paper frrom which we learned is [Huet's Functional
Pearl](http://www.st.cs.uni-sb.de/edu/seminare/2005/advanced-fp/docs/huet-zipper.pdf).
We implemented this for trees in clojure, where a tree is either a number, or
a map with keywords as keys and trees as values.

{% highlight clojure %}
{:e {:f 5}, :a {:b {:c 3, :d 4}}}
{% endhighlight %}

A zipper is a subtree with the context of how to walk back up the tree.  Here is the
zipper at the root of the tree (cur is the tree, and up is empty).

{% highlight clojure %}
{:cur {:e {:f 5}, :a {:b {:c 3, :d 4}}}, :up ()}
{% endhighlight %}

Here we have gone down label `:e`, so the current subtree is the one rooted at
`:e` and the siblings is the tree with `:e` removed.

{% highlight clojure %}
{:cur {:f 5}, :up ({:key :e, :siblings {:a {:b {:c 3, :d 4}}}})}
{% endhighlight %}

Now we have gone down another step to the subtree at `:f`.  Note that up now
is a list of length 2.  The elements in the list up describe how to take the
repeated steps upward if you want to zip up the zipper again.

{% highlight clojure %}
{:cur 5, :up ({:key :f, :siblings {}} {:key :e, :siblings {:a {:b {:c 3, :d 4}}}})}
{% endhighlight %}

Here comes the point of zippers as we currently understand it.  We can now do
many operations on the current subtree that are all local.  We don't have to
walk the path to the root to update all nodes along this path.  Especially on
repeated updates in a certain local area of the tree this can give great time
savings.

Before we show some timings showing this effect, here are the key zipper
functions to work with the structures as above.  We have not yet succeeded in
making the code optimally readable, but it has been reasonably
[tested](https://github.com/kasterma/basicprogramming/blob/develop/algorithms/zipper/src/core.clj).

{% highlight clojure %}
(defn up [{:keys [cur up] :as z}]
  (let [[{:keys [key siblings] :as parent} & more-up]
        up]
    {:cur (assoc siblings key cur)
     :up (if (not (nil? more-up)) more-up (list))}))

(defn down [{:keys [cur up] :as z} child-key]
  {:cur (get cur child-key)
   :up (cons {:key child-key :siblings (dissoc cur child-key)} up)})

(defn sideways [{:keys [cur up] :as z} sibling]
  (let [[{:keys [key siblings] :as parent} & more-up]
        up]
    {:cur (get siblings sibling)
     :up (cons {:key sibling :siblings (assoc (dissoc siblings sibling) key cur)} more-up)}))
{% endhighlight %}

Now the timing.  For optimal application of our understanding, we create a
deep tree consisting of a single branch with at its deepest a branching point.
Here is an example of depth 3 with branching 4.

{% highlight clojure %}
{:k {:k {:k {:0 0, :1 1, :2 2, :3 3}}}}
{% endhighlight %}

Then we want to increase the values at all leaves.  We do this respectively
with repeated `update-in` and by zipping down, updating all the leaves, and
zipping up.  The timings for depth 100 and branching 1000 are with repeated
`update-in` 118 msecs, and with zipping 4 msecs.

Note also that `update-in` uses the stack in an important way, to remember the
path of nodes to update once the update location has been found and the update
performed.  This means in particular that you can blow the stack by updating
too deeply in a structure.
