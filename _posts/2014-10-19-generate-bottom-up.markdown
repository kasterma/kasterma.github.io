---
layout: post
title: Generating Bottom Up
---

After yesterdays very easy tree generation I wondered if something I had recently
done in R (though not posted here yet) could be done easiy in `clojure.test.check`
as well.  The below shows I got it to work, but there is the one point `next-step-fn`
that is really way too ugly.  After I get some more familiarity with
`clojure.test.check` I'll come back and try to clean it up.

The basic problem is to generate a map with some values where the distributions
of those values are not independent.  For instance if the map has a key :a having
value 1 makes it more likely for key :behavior to have value :act.  Because I am
thinking of this data to be used as input for machine learning tasks I call the
keys :predictors.  There is in the below example on special predictor :behavior,
this is the one we focus on to give it a value that is random but dependent
on the other predictor values.

The requires I used are as follows

{% highlight clojure %}
(:require [taoensso.timbre :as log]
            [plumbing.core :as plumbing]
            [schema.core :as s]
            [clojure.test.check :as tc]
            [clojure.test.check.generators :as gen]
            [clojure.test.check.properties :as prop]
            [clojure.test.check.rose-tree :as rose]))
{% endhighlight %}

## The Generation Graph

This graph describes how the datum we want has to be generated.  It is a
map where the keys are the vertices of a graph that is described, the values
describe the edges.  There are at this time three types of edges implemented:

1. {}, the empty edge.  When we get to a vertex with this as its value, the
   generation process is finished.
2. {:predictor X :values [{:freq N :value V :next :N}]} indicates that at
   leaving this vertex the predictor X will get a value.  In the values map
   the freq values indicate the relative frequency of the different values,
   the :value obviously gives the value the predictor gets, and :next indicates
   what the next vertex to be active is.
3. {:predictor X :value-fn F :next :N} indicates that leaving this vertex
   :predictor X will get a value.  This value will be generated using generator
   value-gen, and the next vertex will be :N

We currently experiment with the graph g1 exhibiting all three node
types.

In this graph we have three predictors, :F1 :F2 and :behavior.  :behavior
can have values :act or :no-act, and the values of the other predictors
influence the probabilities of these values.  To easily generate different
action behaviors we have the function acter.

{% highlight clojure %}
(defn acter
  "Generate an action with probablity x%, or a noaction with probability (- 100 x)%."
  [x]
  (assert (<= 0 x 100))
  (fn [next]
    (gen/frequency [[x (gen/return {:value :act :next next})]
                    [(- 100 x) (gen/return {:value :no-act :next next})]])))
{% endhighlight %}

Here then is the graph we want to generate along

{% highlight clojure %}
(def g1 {:root {:predictor :F1 :values [{:freq 10 :value 1 :next :a}
                                       {:freq 20 :value 2 :next :b}]}
         :a {:predictor :F2 :values [{:freq 50 :value "A" :next :act}
                                    {:freq 50 :value "B" :next :no-act}]}
         :b {:predictor :F2 :values [{:freq 100 :value "A" :next :act}]}
         :act {:predictor :behavior :value-gen (acter 90) :next :done}
         :no-act {:predictor :behavior :value-gen (acter 10) :next :done}
         :done {}})
{% endhighlight %}

Note: many functions below this have direct reference to g1.  Clearly they should
have this as an additional argument.

{% highlight clojure %}
(defn prep-freqs
  "Given the values at a node where the outgoing edges are described by frequencies,
  prepare this input for use in gen/frequency."
  [values]
  (map (fn [v] [(:freq v) (gen/return (dissoc v :freq))]) values))

(defn step
  "Given the value at a node of a graph (i.e. the description of out-edges) generate
  the value and label for the next node.  Should be a nonempty value, i.e. check if
  there are out edges before calling this."
  [{:keys [values value-gen next]}]
  (if values
    (gen/frequency (prep-freqs values))
    (value-gen next)))
{% endhighlight %}

The next function is the main problem function.  Clearly the use of gen/call-gen and (even
worse) rose/pure are out of place.  This is the function the user of bottom-up-gen
should write, and this user should not have to bother with such details.

{% highlight clojure %}
(defn next-step-fn
  "Wrapper around the step function."
  [last-step]
  (gen/make-gen
   (fn [rnd size]
     (let [edges                            (g1 (last-step :next))
           {value :value next-node :next}   (first (gen/call-gen (step edges) rnd size))]
       (rose/pure {:value (merge {(edges :predictor) value}
                                (last-step :value))
                   :next next-node})))))
{% endhighlight %}

With this problem function in place, and working as intended (though not implemented
as it should be) we can make the following definitions.

{% highlight clojure %}
(def leaf-gen (gen/return {:next :root :value {}}))

(defn done? [{:keys [next] :as xx}]
  (assert next (str "failed :next from" xx))
  (empty? (g1 next)))

(defn bottom-up-helper [next-step-fn done? value rnd size iteration-limit]
  (if (done? value)
    value
    (if (zero? iteration-limit)
      (assert false)
      (recur next-step-fn
             done?
             (first (gen/call-gen (next-step-fn value) rnd size))
             rnd
             size
             (dec iteration-limit)))))

(defn bottom-up-gen [next-step-fn done? leaf-gen iteration-limit]
  (gen/make-gen
   (fn [rnd size]
     (let [leaf-value (first (gen/call-gen leaf-gen rnd size))]
       (rose/pure (:value (bottom-up-helper next-step-fn done? leaf-value rnd size iteration-limit)))))))
{% endhighlight %}

With that in place we can call the following

{% highlight clojure %}
(gen/sample (bottom-up-gen next-step-fn done? leaf-gen 10))
{% endhighlight %}

this call has the following result (depending on state of your random generator I believe).  If
you generate a larger number you can do the analysis and see that predictor :behavior is indeed
dependent on the other predictors.

{% highlight clojure %}
({:F2 "A", :F1 1, :behavior :no-act}
 {:F2 "A", :F1 1, :behavior :act}
 {:F2 "A", :F1 2, :behavior :act}
 {:F2 "A", :F1 1, :behavior :no-act}
 {:F2 "A", :F1 2, :behavior :act}
 {:F2 "A", :F1 2, :behavior :act}
 {:F2 "A", :F1 2, :behavior :act}
 {:F2 "A", :F1 2, :behavior :act}
 {:F2 "A", :F1 2, :behavior :act}
 {:F2 "A", :F1 2, :behavior :act})
{% endhighlight %}