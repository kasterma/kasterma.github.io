# create the itemlist for on the homepage.
# currently just gets the github items, but ready for more
# variety.

import datetime
import feedparser
import httplib2
import json
import os.path
import pprint
import random
import time
import urllib
import urllib
import xml.dom.minidom as minidom

pp = pprint.PrettyPrinter(indent=4)

GITHUBFEED = "https://github.com/kasterma.atom"

def make_make_item(text, imgsrc, dataline):
  def make_item(num):
    item = '<li class="item mbox' + str(num) + '">' + \
         '<table><tr><td style="vertical-align:top;">' + \
         '<img src="/images/' + imgsrc + \
         '" width="40" height="40" class="itemimg" />' + \
         '</td><td>' + \
         text + '<br />' + \
         dataline + \
         '</td></tr></table>' + \
         '</li>'
    return item
  return make_item


def github_get():
  feed = feedparser.parse(GITHUBFEED)

  github_items = []

  for item in feed['entries']:
    link_split = item['link'].split("/")
    if len(link_split) > 4:
      rep_name = "/" + link_split[4]
      link = "/".join(link_split[:5])

      text = item['title']
      date = datetime.datetime.strptime(item['published'][:-1], "%Y-%m-%dT%H:%M:%S")
      dataline = '<span class="time">' + \
                 '<a href="' + item['author_detail']['href'] + \
                 '">github.com/kasterma</a>' + \
                 '&nbsp;&nbsp;<a href="' + link + '">' + rep_name + '</a>&nbsp;' + \
                 date.strftime("%A, %d %B") + \
                 '</span>'


      github_items.append([date, 'github', make_make_item(text, 'github.png', dataline)])

  return github_items

github_items = github_get()

use_items = []
for idx in range(0,20):
  use_items.append(github_items[idx][2](idx))

print "\n".join(use_items)
