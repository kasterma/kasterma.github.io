# twitter_auth.py
#
# Bart Kastermans, www.bartk.nl
#
# script to get tokens from twitter.  Directly based on simplegeo's
# examples on github (directly based on here means almost a direct
# copy and paste).

import oauth2
import urlparse
import sys
import json

secrets_filename = "twitter_key_secret.txt"
secrets_file = open ("twitter_key_secret.txt", "r")
secrets = json.load (secrets_file)
secrets_file.close ()

# the following came from registering with twitter
# not consumer_key and consumer_secret should be stored in
# file key_secret.txt

if 'consumer_key' not in secrets.keys ():
    print "Consumer key missing in file %s." % secrets_filename
    print "consumer_key and consumer_secret must be entered"
    print "manually into that file."
    sys.exit ()
consumer_key = secrets ['consumer_key']
if 'consumer_secret' not in secrets.keys ():
    print "Consumer secret missing in file %s." % secrets_filename
    print "consumer_secret must be manually entered into that file."
    sys.exit ()
consumer_secret = secrets ['consumer_secret']

request_token_url = "https://api.twitter.com/oauth/request_token"
access_token_url = "https://api.twitter.com/oauth/access_token"
authorize_url = "https://api.twitter.com/oauth/authorize"

consumer = oauth2.Consumer (consumer_key, consumer_secret)
client = oauth2.Client (consumer)

# Step 1: Get a request token. This is a temporary token that is used for 
# having the user authorize an access token and to sign the request to obtain 
# said access token.

resp, content = client.request(request_token_url, "GET")
if resp['status'] != '200':
    raise Exception("Invalid response %s." % resp['status'])

request_token = dict(urlparse.parse_qsl(content))

print "Request Token:"
print "    - oauth_token        = %s" % request_token['oauth_token']
print "    - oauth_token_secret = %s" % request_token['oauth_token_secret']
print 

# Step 2: Redirect to the provider. Since this is a CLI script we do not 
# redirect. In a web application you would redirect the user to the URL
# below.

print "Go to the following link in your browser:"
print "%s?oauth_token=%s" % (authorize_url, request_token['oauth_token'])
print 

# After the user has granted access to you, the consumer, the provider will
# redirect you to whatever URL you have told them to redirect to. You can 
# usually define this in the oauth_callback argument as well.
accepted = 'n'
while accepted.lower() == 'n':
    accepted = raw_input('Have you authorized me? (y/n) ')
oauth_verifier = raw_input('What is the PIN? ')

# Step 3: Once the consumer has redirected the user back to the oauth_callback
# URL you can request the access token the user has approved. You use the 
# request token to sign this request. After this is done you throw away the
# request token and use the access token returned. You should store this 
# access token somewhere safe, like a database, for future use.
token = oauth2.Token(request_token['oauth_token'],
    request_token['oauth_token_secret'])
token.set_verifier(oauth_verifier)
client = oauth2.Client(consumer, token)

resp, content = client.request(access_token_url, "POST")
access_token = dict(urlparse.parse_qsl(content))

print "Access Token:"
print "    - oauth_token        = %s" % access_token['oauth_token']
print "    - oauth_token_secret = %s" % access_token['oauth_token_secret']
print
print "You may now access protected resources using the access tokens above." 
print

secrets ['oauth_token'] = access_token ['oauth_token']
secrets ['oauth_token_secret'] = access_token ['oauth_token_secret']

secrets_file = open (secrets_filename, "w")
json.dump (secrets, secrets_file, indent=2)
secrets_file.close ()

print "These tokens have been written to %s." % secrets_filename
