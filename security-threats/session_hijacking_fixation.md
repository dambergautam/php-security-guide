### Session Hijacking and Session fixation

#### Session Fixation

There are three common methods used to obtain a valid session identifier:
- Prediction
  It refers to guessing a valid session identifier. The session identifier is extremely random, and this is unlikely to be the weakest point in your implementation.

- Capture
  Capturing a valid session identifier is the most common type of session attack, and there are numerous approaches like GET, cookies.

- Fixation
  Fixation is the simplest method of obtaining a valid session identifier. While it's not very difficult to defend against, if your session mechanism consists of nothing more than `session_start()`, you are vulnerable.

#### Session Hijacking
Session hijacking refers to all attacks that attempt to gain access to another user's session. Like session fixation, if your session mechanism consists of `session_start()` then your are vulnerable.

Check if HTTPS request has been made with a different `User-Agent` (Which is highly unlikely):
```php
    session_start();

    if (isset($_SESSION['HTTP_USER_AGENT']))
    {
        if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT'])){
            exit;
        }
    }
    else{
        $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);
    }
```    

Make it more complicated by adding string
```php
    $agent = $_SERVER['HTTP_USER_AGENT'].'RANDOMTEXT';
    $fingerprint = md5($agent);
```


#### Solution
Unfortunately, there is no 100% secure way to prevent such abuse. You should design your application and its session management that
 - an attacker can't guess a valid session ID by using enough entropy
 - should be no other way for an attacker to obtain a valid session ID by vulnerabilities like xss.

**Secure Session tips**

- Set `session.use_trans_sid = 0` in /etc/php5/apache2/php.ini file.
- Ensure you always use a new self-generated session id on successful login attempt (`session_regenerate_id` -it will replace the current session ID with a new one).
- Specify `session.use_only_cookies = 1` to only use cookies to store the session id on the client side. Prevent attacks involved passing session ids in URLs.
- Use https throughout to ensure no one can sniff your session id.
- Store session id, remote IP information and compare for successive pages
- Marks the cookie as accessible only through the HTTP protocol (`session.cookie_httponly = 1`) to prevent xss.
- Specifies whether cookies should only be sent over secure connections (`session.cookie_secure =1`).



#### Some explanation

**Enable session strict mode `session.use_strict_mode = 1` from php.ini?**

- It will help to prevent, and uninitialized session id and session fixation
- It will regenerate session ID
- By default it is disabled, it is encouraged to enable.

**Why to set `session.use_trans_sid = 0`?**

- Setting 1, it will allow passing PHPSESSID in URL
- Setting 0, it will help to prevent session fixation


[Ref](http://www.wikihow.com/Create-a-Secure-Login-Script-in-PHP-and-MySQL#steps_4)
