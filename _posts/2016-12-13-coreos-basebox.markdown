---
layout: post
title:  "Creating a CoreOS Container Linux base box for Vagrant"
date:   2016-12-10 15:00
tags: inprogress
---

Though there is a Vagrant base box for CoreOS I wanted to see the steps needed
to create such a box so that I could possibly customize it.

[CoreOS](https://coreos.com/)

The steps to follow:

- download the [iso](https://coreos.com/os/docs/latest/booting-with-iso.html)
- create a cloud-config.yaml (see below)
- in VirtualBox create a new vm
  - linux; other linux 64 bit
  - upgrade memory to 2048 MB
  - create virtual hard disk now (type VDI, Dynamically allocated, any name)
  - find where you downloaded the iso to, and boot
  - select coreos iso and boot; land in a prompt
  - 'sudo passwd core' to add a password to this acct; note this is a temporary
    password only used for a couple of the following steps
  - set up port forwarding from the host to guest port 22
     - network, advanced, port forwarding (I set up host: 2222, guest: 22)
     - run `ssh -p 2222 core@localhost` to test this works with the password
       just set up
  - On the host `scp -P 2222 cloud-config.yaml core@localhost:` to copy the
    cloud config to the guest.
  - On the guest validate cloud-config with `coreos-cloudinit --validate --from-file cloud-config.yaml`
  - Then install with `sudo coreos-install -d /dev/sda -C stable -c ~/cloud-config.yaml`.
    This will download a fresh image.
  - sudo halt or poweroff the virtual machine (halt didn't halt enough)
  - remove iso image from the box (Storage Remove)
  - boot; passwords don't seem to be set correctly

# Cloud config

{% highlight yaml %}
#cloud-config

hostname: coreos0

ssh_authorized_keys:
  - ssh-rsa XXX

users:
  - name: kasterma
    groups:
     - sudo
     - docker
    ssh-authorized-keys:
     - ssh-rsa XXX
  - name: vagrant
    groups:
      - sudo
    passwd: XXX
  - name: root
    passwd: XXX

coreos:
  units:
    - name: etcd2.service
      command: start
    - name: fleet.service
      command: start
  etcd2:
    # generate a new token for each unique cluster from https://discovery.etcd.io/new?size=3
    # specify the initial size of your cluster with ?size=X
    discovery: https://discovery.etcd.io/XXX

{% endhighlight %}
