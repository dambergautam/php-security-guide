# Scanning

Scanning is all about probing a target network and making it spew out useful
information such as open ports and other network information.

### hping3

This is an alternative to ping with more options.

To act like ping;

`hping3 -1 <domain name>`

To check if a firewall is blocking a ping request we can do the following:

`hping3 -c 1 -V -p 80 -s 5050 -A <domain name>`

-A for ACK

-V for verbose

-p following by a target port number

-s for the port of the source computer

If you can get a 100% packet loss then you know a firewall is in place or the
port might just not exist.

#### TCP flags

`SYN` Initiates a connection between two hosts to facilitate communication

`ACK` Acknowledges the receipt of a packet of information.

`URG` Indicates that the data contained in the packet is urgent and should
be processed immediately.

`PSH` Instructs the sending system to send all buffered data immediately.

`FIN` Tells the remote system that no more information will be sent. In
essence, this gracefully closes a connection.

`RST` Resets a connection

**Additional examples**

- Create an ACK packet and send it to port 80 on the victim:

`hping3 –A <target IP address> -p 80`

- Create a SYN scan against different ports on a victim:

`hping3 -8 50-56 –S <target IP address> -v`

- Create a packet with FIN, URG, and PSH flags set and send it to port 80 on
the victim:

`hping3 –F –P -U <target IP address> -p 80`

### nmap

The tool that is your swiss army knife that you'll always use is `nmap`. It's
advisable to use this tool often and learn about the different flags and what's
appropriate. Some flags can be quite aggressive that it will leave you exposed
on the logs which you might not want.

#### Basics:

**Scan for open ports**

`nmap -Pn <domain name or ip>`

**Full-Open Scan** (three way handshake which is be very "noisy" and will show on
logs)

`nmap -sT <ip address or range>`

**Stealth or Half-Open Scan**

`nmap -sS <ip address or range>`

**Xmas tree scan**

`nmap -sX -v <target Ip address>`

**FIN Scan**

`nmap -sF <target IP address>`

**NULL Scan**

`nmap -sN <target IP address>`

**OS Fingerprinting / Detection**

`nmap -O <target IP address>`
