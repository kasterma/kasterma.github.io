---
layout: post
title: Everything is Broken
---

In the last week I had some discussions with people about how bad most software
really is.  Then as a good case in point I decided to finally give up on my
resistance to update to Yosemite.  That was, as they say, a mistake.

Something in the upgrade went wrong, and the laptop in question is now no longer
usable; I can't get past the login screen, and the login screen is already
barely working.  The reinstall of the OS has just been showing "About 2 minutes
remaining" for hours, no indication of if it is dead or just taking a tad longer
than expected on an operation.

Fortunately I had brought my work laptop home, and I could start with file and
software recovery immediately.  It is a busy time at work, so getting a serious
setback in the two projects I am working on would be a problem.

Then I couldn't connect to my timemachine backup on my airport express.  After
fighting with that for a while I could see the files, but couldn't get to it
using the timemachine software, so to make progress I had to work with the time
machine database as it is written to disk raw.  I can tell you that this is not
the most pleasant format to deal with in this way.

Among the many things that didn't work as smoothly as they should were things
like the following great error message:

{% highlight bash %}
lein do clean, midje
WARNING!!! possible confusing dependencies found:
[joda-time "2.2"]
 overrides
[joda-time "2.2"]
{% endhighlight %}

`lein` is not at all a bad bit of software, it is just that its error message is
a good example that is simple to share.  Clearly this message is incorrect.  The
number of messages like this (login to your airport express has failed, contact
your system administrator for details) just kept on going.

Currently, many hours after the initial mistake (lets try Yosemite on this
laptop), at least the currently active projects are restored.  There is still
more to do, but I am back in a working state so I can relax about it again.


# What I learned from this

Many of the things I learned from this, I learned again.  That is to say I had
learned them at some point in the past as well, but slowly forgot again.  Here
are some system administrator type things I learned again (the software
development lessons like "don't project your knowledge of a situation into an
error message" are a separate issue)

* test backup recovery extensively.
* have a fully redundant setup.
* simplify the setup as much as possible.

## Test backups

I had my laptop pretty well backed up, I thought.  At home to my airport
express, and at an offsite location as well.  I also tested restoring a file
occasionally. I had never tested restoring a file from this backup to another
computer; and this did not work.  The failure mode I experienced today, no more
access to a laptop at all, can have many reasons; a harddisk dying, or a cup of
coffee drowning it, are easy examples.  This needs to be tested for.

So, I had my files existing in different locations.  Nothing has been lost.
Getting at them is hard though.

An example; I have been using eclipse for some java projects.  Every now and
then I add a new plugin, or change a setting, to learn this program.  I have
never spend the time yet to learn where all these things are stored, and now
they are spread over many many different directories in the backup database that
time machine has setup.  Easier to start with a fresh eclipse setup.

## Have a fully redundant setup

I have two laptops, my personal laptop, and one provided by my employer.  I
am allowed to use both for both work and private stuff.  But I had decided to
simplify and just use one of them.  From now on I am going to keep both in
always working state.  If one completely dies, I can just pick up the other one
and continue working (though with maybe a trip home or to the office to pick up
the other laptop; takes much less time than what I had to do now).

As a possibly interesting, and for me certainly frustrating, sidenote, I had
actually realised this earlier this week, which is exactly why I had my work
laptop at home.

As another sidenote, the whole update to Yosemite on my personal laptop was
investing time in something I should not; after working on it all day I get
tired eyes, because of this I have been considering getting one of the retina
screen laptops.

## Simplify the setup as much as possible

Finally, some of the problems I run into were because of my setup not being as
simple as it could.  I have been experimenting with sublimetext, but still
make a lot of use of emacs with lots of packages.  Getting emacs back into
working state took quite a bit of work.

I spend many hours a day on a computer.  This makes it completely worth
configuring this computer to fit my needs and desires.  Also this configurating
is allowed to take some work.  Just using TextEdit because it comes default on a
mac is just ridicilous, but the work needed to get emacs back to working state
was not good either.  And everything was much simplified by this work computer
already having lots of software I use installed.

The commplexity is clearly my fault, but I am not sure how to fix it yet.  One
thing I am considering is occasionally fully reconfiguring my computer (i.e.
start from a fresh install of the OS, and then setup everything again), then at
least I will know exactly what it takes to setup a new computer (and I'll be
sure to have all license information for software I have bought handy).

So indeed, everything is broken, and I broke some of it, but how do you fix it?

UPDATE: when I returned from visiting my parents the Yosemite install had
finished, this means it showed "About 2 minutes remaining" for between 5 and 7
hours (I don't know when it finished while I was away).