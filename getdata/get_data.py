from oauth2client.client import OAuth2WebServerFlow
from oauth2client.tools import run
from oauth2client.file import Storage

import apiclient.discovery
import datetime
import feedparser
import gplus_settings
import httplib2
import json
import oauth2
import os.path
import pprint
import pprint
import pprint
import pprint
import random
import time
import urllib
import urllib
import xml.dom.minidom as minidom

pp = pprint.PrettyPrinter(indent=4)

GITHUBFEED = "https://github.com/kasterma.atom"
GPLUSID = "102085185756507251350"

def make_make_item(text, imgsrc, dataline):
  def make_item(num):
    item = '<li class="item mbox' + str(num) + '">' + \
         '<table><tr><td style="vertical-align:top;">' + \
         '<img src="/images/' + imgsrc + \
         '" width="40" height="40" class="itemimg" />' + \
         '</td><td>' + \
         '<b>' + text + '</b><br />' + \
         dataline + \
         '</td></tr></table>' + \
         '</li>'
    return item
  return make_item


def gplus_get():
  """ get activities from gplus.

  directly based on example code provided by google.
  """
  httpUnauth = httplib2.Http()
  serviceUnauth = apiclient.discovery.build('plus',
                                            'v1',
                                            http=httpUnauth,
                                            developerKey=gplus_settings.API_KEY)

  request = serviceUnauth.activities().list(userId=GPLUSID, collection='public')
  activities = request.execute(httpUnauth)['items']

  gplus_items = []

  if len(activities) > 0:
    for item in activities:
      text = item['object']['content'].split(".")[0] + '.'
      date = datetime.datetime.strptime(item['published'][:-5], "%Y-%m-%dT%H:%M:%S")
      dataline = '<a href="https://plus.google.com/102085185756507251350/about">' + \
                 '+Bart Kastermans</a>' + \
                 '&nbsp;&nbsp;<a href="' + item['url'] + '">this post</a>&nbsp;' + \
                 '<span class="time">' + \
                 date.strftime("%A, %d %B at %H:%M") + \
                 '</span>'

      gplus_items.append([date, 'gplus', make_make_item(text, 'gplus.png', dataline)])

  return gplus_items


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
      dataline = '<a href="' + item['author_detail']['href'] + \
                 '">github.com/kasterma</a>' + \
                 '&nbsp;&nbsp;<a href="' + link + '">' + rep_name + '</a>&nbsp;' + \
                 '<span class="time">' + \
                 date.strftime("%A, %d %B at %H:%M") + \
                 '</span>'


      github_items.append([date, 'github', make_make_item(text, 'github.png', dataline)])

  return github_items


def twitter_get():
  secrets_filename = "twitter_key_secret.txt"
  secrets_file = open (secrets_filename, "r")
  secrets = json.load (secrets_file)
  secrets_file.close ()

  # obtained by registering with twitter and put in secrets_filename

  consumer_key = secrets ['consumer_key']
  consumer_secret = secrets ['consumer_secret']

  # the following two are the results of running twitter_auth.py
  # which saves the data into secrets_filename

  oauth_token        = secrets ['oauth_token']
  oauth_token_secret = secrets ['oauth_token_secret']

  consumer = oauth2.Consumer (key = consumer_key,
                              secret = consumer_secret)
  token = oauth2.Token (oauth_token, oauth_token_secret)
 
  client = oauth2.Client (consumer, token)

  home_timeline_url_json = "https://api.twitter.com/1/statuses/user_timeline/kasterma.json"

  res_json = client.request (home_timeline_url_json, "GET")

  statuslist_json = json.loads (res_json [1])

  twitter_items = []

  for status in statuslist_json:
    text = status['text']
    date = datetime.datetime.strptime(status['created_at'][:-10] + status['created_at'][-5:], "%a %b %d %H:%M:%S %Y")
    dataline = '<a href="https://twitter.com/kasterma">@kasterma</a>' + \
               '&nbsp;&nbsp;<a href="https://twitter.com/#!/kasterma/status/' + \
               status['id_str'] + '">this tweet</a>&nbsp;' +\
               '<span class="time">' + \
               date.strftime("%A, %d %B at %H:%M") + \
               '</span>'
    twitter_items.append([date, 'twitter', make_make_item(text, 'twitter.png', dataline)])

  return twitter_items

def take_items(all_items, total_no, gplus_atleast, github_atleast, twitter_atleast):
  all_items.sort()
  gplus_no = 0
  github_no = 0
  twitter_no = 0
  taken_no = 0
  items_idx = len(all_items) - 1
  items = []
  while taken_no < total_no and items_idx >= 0:
    cur_item = all_items[items_idx]
    items_idx -= 1
    cur_type = cur_item[1]
    if cur_type == 'twitter' and twitter_no < twitter_atleast:
      twitter_no += 1
      taken_no += 1
      items.append(cur_item[2](taken_no))
      continue
    if cur_type == 'github' and github_no < github_atleast:
      github_no += 1
      taken_no += 1
      items.append(cur_item[2](taken_no))
      continue
    if cur_type == 'gplus' and gplus_no < gplus_atleast:
      gplus_no += 1
      taken_no += 1
      items.append(cur_item[2](taken_no))
      continue
    if taken_no < total_no - ((gplus_atleast - gplus_no) +
                              (github_atleast - github_no) +
                              (twitter_atleast - twitter_no)):
      taken_no += 1
      items.append(cur_item[2](taken_no))
      
  return items

gplus_items = gplus_get()
github_items = github_get()
twitter_items = twitter_get()

all_items = gplus_items + github_items + twitter_items
use_items = take_items(all_items, 12, 2, 2, 2)

print "\n".join(use_items)
