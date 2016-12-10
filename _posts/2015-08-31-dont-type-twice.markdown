---
layout: post
title: don't type it twice
---

In interactive data analysis I often update a variable after
performing some operation on it

{% highlight R %}
    variable_with_long_name <- f(variable_with_long_name)
{% endhighlight %}

The process is to first play with f for a while, and then when it is
right to add the assignment.  Using meaningful variable names is
somewhat discouraged by the typing, and, maybe more important, when
reading you have more text to compare to check it really is an update.
`magrittr` to the rescue.  While looking for the right function use

{% highlight R %}
    variable_with_long_name %>% f
{% endhighlight %}

Then when it is correct update the `%>%` to `%<>%` to get

{% highlight R %}
    variable_with_long_name %<>% f
{% endhighlight %}

giving a clear, update this variable by applying function f.  This
also works well when using `data.table`.  I use the following to zoom a
table down to a single customer

{% highlight R %}
    table_of_interest %<>% .[custid == "CUST1"]
{% endhighlight %}