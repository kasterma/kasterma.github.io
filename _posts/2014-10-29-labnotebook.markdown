---
layout: post
title: Lab Notebooking
---

Via the clojure gazette I got to [Lab Notebooking for the Software
Engineer](https://blog.nelhage.com/2010/06/lab-notebooking-for-the-software-engineer/).
There Nelson Elhage points out some things there that I was working my
way to as well.

For keeping the log I use a function `logit` defined in my `.emacsrc`:

{% highlight clojure %}
(defun logit ()
  "Log function: open ~/org/log.org, write timestamp and put cursor in right place"
  (interactive)
  (find-file "~/org/log.org")
  (goto-char (point-max))
  (insert (format-time-string "* %H:%M    %A %B %d, %Y-%m-%d\n\n\n"))
  (forward-line -2))
{% endhighlight %}

I have found that the timestamp makes it easy to look at the file
as append only.  Now anywhere in emacs I can `M-x logit`, and add
a log entry.

I use Hazel to check that the file get updated frequently (there is a
hazel rule that after the file has not been changed for an hour
generates a popup reminding me).

One thing that he does not write about is what to do with the data
collected.  I have found that just keeping it in the log.org file
means it become too hard to use.  So I have a file notes.org where I
copy all things to that seem like they should be usefull on other
occasions.  The file notes.org I study frequently to get the
information into my brain.
