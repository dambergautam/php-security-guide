# Footprinting

## What is footprinting?
Footprinting or reconnaissance is a method of gathering information about your
target. You'll try and gather as much public information using tools as well as
observing any interesting pieces of information you come across.

This document will guide through some simple techniques in discovering obvious
issues. Like with any type of ethical hacking, please ensure you do have
permission to do this, however it's only gathering public information.

Following this process will help you understand the application from a hackers
perspective.

## Footprinting goals

Going through this process you'll want to try and gather the following:

- Network information
- OS information
- Organization information (i.e. CEO, employee info, contact numbers, etc)
- Network blocks
- Network services
- Application and web application data and configuration information
- System architecture
- Intrusion detection and prevention systems
- Employee names and experience (in order to choose a suitable victim)

## Network information gathering

The following commands will gather network info.

**Find IP**

`host <hostname>`

Example usage:

```
$ host google.com
google.com has address 216.58.199.78
google.com has IPv6 address 2404:6800:4006:806::200e
google.com mail is handled by 10 aspmx.l.google.com.
google.com mail is handled by 50 alt4.aspmx.l.google.com.
google.com mail is handled by 20 alt1.aspmx.l.google.com.
google.com mail is handled by 40 alt3.aspmx.l.google.com.
google.com mail is handled by 30 alt2.aspmx.l.google.com.
```

`dig <option> <hostname>`

Dig is a very useful tool. Here are some useful options:

`A` IP Address

`TXT` Text annotations

`MX` Mail exchanges

`NS` Name servers

`ANY` yep, any.

`-x` For reverse lookup to get the main hostnae associated with an IP

Basic example:

```
$ dig A google.com

; <<>> DiG 9.10.3-P4-Ubuntu <<>> A google.com
;; global options: +cmd
;; Got answer:
;; ->>HEADER<<- opcode: QUERY, status: NOERROR, id: 58303
;; flags: qr ra; QUERY: 1, ANSWER: 1, AUTHORITY: 0, ADDITIONAL: 1

;; OPT PSEUDOSECTION:
; EDNS: version: 0, flags:; udp: 4096
;; QUESTION SECTION:
;google.com.			IN	A

;; ADDITIONAL SECTION:
google.com.		81	IN	A	216.58.199.78

;; Query time: 2 msec
;; SERVER: 127.0.1.1#53(127.0.1.1)
;; WHEN: Tue Aug 01 21:34:45 AEST 2017
;; MSG SIZE  rcvd: 55
```

Reverse lookup example:

```
$ dig -x 216.58.199.78       

; <<>> DiG 9.10.3-P4-Ubuntu <<>> -x 216.58.199.78
;; global options: +cmd
;; Got answer:
;; ->>HEADER<<- opcode: QUERY, status: NOERROR, id: 57287
;; flags: qr ra; QUERY: 1, ANSWER: 1, AUTHORITY: 0, ADDITIONAL: 1

;; OPT PSEUDOSECTION:
; EDNS: version: 0, flags:; udp: 4096
;; QUESTION SECTION:
;78.199.58.216.in-addr.arpa.	IN	PTR

;; ADDITIONAL SECTION:
78.199.58.216.in-addr.arpa. 83743 IN	PTR	syd15s01-in-f78.1e100.net.

;; Query time: 4 msec
;; SERVER: 127.0.1.1#53(127.0.1.1)
;; WHEN: Tue Aug 01 21:38:40 AEST 2017
;; MSG SIZE  rcvd: 94
```

`ping <hostname>`

You can also find the IP by pinging it.

**Follow packet route**

A good way to learn about a network is to see how we connect to the site. This
way you can see all the transfers to get the domain you're after.

`traceroute <hostname>`

## Unwanted leaked information via Google Hacking

Why not use the power of google's crawler to find interesting information about
your target. This form of hacking is nothing new and has been around for a
while, but it's not known by the everyday user. Using google's powerful search
queries we can find interesting data.

**cache** Displays the version of a web page that Google contains in its cache
instead of displaying the current version. Syntax: `cache:<website name>`

**link** Lists any web pages that contain links to the page or site specified
in the query. Syntax: `link:<website name>`

**info** Presents information about the listed page. Syntax:
`info:<website name>`

**site** Restricts the search to the location specified.
Syntax: `<keyword> site:<website name>`

**allintitle** Returns pages with specifi ed keywords in their title. Syntax:
`allintitle:<keywords>`

**allinurl** Returns only resultwith the specifi c query in the URL. Syntax:
`allinurl:< keywords>`

## Find information about a website and discover subdomains

A useful site is https://www.netcraft.com/ which has a tool called "What's That
Site Running?" which can be found on the right column of the homepage.

This tool allows you to possibly view OS information and subdomains if any. It
helps you discover domains that might not be wanted to be known which could be
an alternate attack vector. However this does stem away from application
security.

## Social media (non web application specific)

If you know social media is used to help promote the site it might be a good
idea to search around these mediums to find more information about your target,
you might find links to one off forms or other one off items that might not be
well secured and can lead to a back door into the web application. It could
also lead to helping you understand a victim to build a strong phishing attack
to steal login creditials.
