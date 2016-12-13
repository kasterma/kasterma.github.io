---
layout: post
title:  "Running John the Ripper"
date:   2016-12-13
---

In trying to set up a cloud-config with working passwords there was a comment:

    #   passwd: The hash -- not the password itself -- of the password you want
    #           to use for this user. You can generate a safe hash via:
    #               mkpasswd --method=SHA-512 --rounds=4096
    #           (the above command would create from stdin an SHA-512 password hash
    #           with 4096 salt rounds)
    #
    #           Please note: while the use of a hashed password is better than
    #               plain text, the use of this feature is not ideal. Also,
    #               using a high number of salting rounds will help, but it should
    #               not be relied upon.
    #
    #               To highlight this risk, running John the Ripper against the
    #               example hash above, with a readily available wordlist, revealed
    #               the true password in 12 seconds on a i7-2620QM.
    #
    #               In other words, this feature is a potential security risk and is
    #               provided for your convenience only. If you do not fully trust the
    #               medium over which your cloud-config will be transmitted, then you
    #               should use SSH authentication only.
    #
    #               You have thus been warned.

This of course needed to be tried.  Here is a quick outline of how to run this

    docker run -ti ubuntu bash
    apt-get update
    apt-get install -y john
    apt-get install -y whois   # for mkpasswd
    mkpasswd --method=SHA-512 --rounds=4096 > passhash
    # when it asks for password, give it the one you want to try
    john passhash

Timings (running on a small vm): test (0s), bart (5s), monkey (0s), Monkey (8s),
m0nkey (s).
