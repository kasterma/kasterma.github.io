---
layout: post
title: Seeing the full effect of a yum install
---

In taking care of the security for our docker setup, one of the instructions is
to set up auditing for all docker related files.  To do this I wanted a reliable
method to see which files were used by docker.  The following is my solution.

First the general strategy for seeing the effect on the filesystem of a command
`ZZZ`.

1. Start the image and (for convenience) give it a name XXX (`docker run --name XXX <image>`)..
2. Do everything you do not want to include in the diff (e.g. install
  dependencies but not package itself, see below).
3. Save the state of the filesystem to a tar-file: `docker export XXX -o XXX-before.tar`
4. Run the command `ZZZ`.
5. Save the state of the filesystem to a tar-file: `docker export XXX -o XXX-after.tar`
6. `mkdir XXX-before; tar xf XXX-before.tar -C XXX-before`
7. `mkdir XXX-after; tar xf XXX-after.tar -C XXX-after`
8. compare the directories with whatever tools you like (e.g. for using
  Kaleidoscope: `ksdiff XXX-before XXX-after`)

On top of this I needed a method to install everything needed by docker, but not docker:

    yum deplist docker | grep provider | sort | uniq | awk '{print $2}' | grep -v 'docker' | xargs yum -y install
