---
layout: post
title: string operations on levels
---

At various times I have had to do string operations on the levels of a
factor.  The standard example is when you have an ID that consists of
multiple pieces of information (think of "customer1-item1").  The
operation

{% highlight R %}
library(stringi)
test_f1 <- factor(c(rep("customer1-item1", 4),
                    rep("customer1-item2", 3),
			rep("customer2-item1", 2)))
customer_factor <- as.factor(stri_extract(test_f1, regex = "customer[0-9]*"))
{% endhighlight %}

works for this.  For large factors this can become really and
unnessesarily slow.  The factor is first converted to a character
vector on which the extract operation is performed.  This means that
`stri_extract` has to extract `customer1` from `customer1-item1` 4
times in the above code.  To make this more efficient we can use
the following operations

{% highlight R %}
#' Operate on levels of factor one at a time
#'
#' Appply the level.op function to individual level strings
level.fn <- function(factor.in, level.op) {
  factor.out <- factor.in
  old.levels <- levels(factor.out)
  new.levels <- Map(level.op, old.levels)
  levels(factor.out) <- as.character(new.levels)
  factor.out
}

#' Operate on the levels of a factor all at the same time
#'
#' Apply the levels.op to the vector of all level strings
alllevel.fn <- function(factor.in, levels.op) {
  factor.out <- factor.in
  old.levels <- levels(factor.out)
  new.levels <- levels.op(old.levels)
  levels(factor.out) <- as.character(new.levels)
  factor.out
}
{% endhighlight %}

then the above becomes

{% highlight R %}
customer_factor <- alllevel.fn(test_f1, function(x) stri_extract(x, regex = "customer[0-9]*"))
{% endhighlight %}

On large factors this can be much more efficient.

You might want to go one step further and too far by replacing the
line

{% highlight R %}
levels(factor.out) <- as.character(new.levels)
{% endhighlight %}

by the line

{% highlight R %}
attr(factor.out, "levels") <- as.character(new.levels)
{% endhighlight %}

This fails in ways that will lead to interesting debugging later on:

{% highlight R %}
> test_f2 <- test_f1
> attr(test_f2, "levels") <- c("customer1", "customer1", "customer2")
> test_f2
[1] customer1 customer1 customer1 customer1 customer1 customer1 customer1
[8] customer2 customer2
Levels: customer1 customer1 customer2
{% endhighlight %}

Note that level "customer1" occurs twice in levels.  It is true that
if you can ensure the levels will remain distinct this is indeed lots
faster again.