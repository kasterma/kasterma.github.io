---
layout: post
title: Printing numbers with separators in R
---

I have been working with fairly large numbers in R (though mixed with numbers
of "ordinary size").  To help with reading them I wanted thousands and higher
separators to be printed.  This shows one way to achieve this.

Here is some test data.

{% highlight R %}
    day.counts <- structure(c(128675575, 91892653), .Names = c("day1", "day2"))
{% endhighlight %}

These number are large enough that it is easy to miss the actual order between
them.  When printed using

{% highlight R %}
    print(format(day.counts, big.mark=","), quote=FALSE)
{% endhighlight %}

You get

           day1        day2
    128,675,575  91,892,653

Clearly showing that the first has one more digit than the second.

When using the magrittr package (for instance through dplyr) you can add this
type of printing using

{% highlight R %}
    day.counts %>%
    format(big.mark=",") %>%
    print(quote=FALSE)
{% endhighlight %}