# Web Application Security

## Introduction

This document will list possible security threats to the Web application, explanation and preventive measures.

1. SQL injection
2. File Upload
3. Session Hijacking and Session fixation
4. Remote file inclusion
5. XSS
6. eval()
7. Sea-surf Attack (CSRF)
8. Clickjacking

***
### 1. SQL injection

It is a vulnerability in the database layer of a PHP application. When user input is incorrectly filtered any SQL statements can be executed by the application. You can configure Apache and write secure code (validating and escaping all user input) to avoid SQL injection attacks. A common practice in PHP is to escape parameters using the function called `mysql_real_escape_string()` before sending the SQL query.

### 2. File Upload

It allows your visitor to place files (upload files) on your server. This can result in various security problems such as delete your files, delete a database, get user details and much more. You can disable file uploads using PHP or write secure code (like validating user input and only allow image file types such as png or gif).

### 3. Session Hijacking and Session fixation

#### Explanation

#### Solution

**Secure Session tips**

- Set `session.use_trans_sid = 0` in /etc/php5/apache2/php.ini file.
- Ensure you always use a new self-generated session id on successful login attempt.
- Try setting `session.use_only_cookies = 1` and check if all works fine.
- Use https throughout to ensure no one can sniff your session id.
- Store session id, remote IP information and compare for successive pages

**Enable session strict mode `session.use_strict_mode = 1` from php.ini?**

- It will help to prevent, and uninitialized session id and session fixation
- It will regenerate session ID
- By default it is disabled, it is encouraged to enable.

**Why to set `session.use_trans_sid = 0`?**

- Setting 1, it will allow passing PHPSESSID in URL
- Setting 0, it will help to prevent session fixation

### 4. Remote file inclusion

An attacker can open files from remote server and execute any PHP code. This allows them to upload a file, delete a file and install backdoors. You can configure PHP to disable remote file execution.

### 5. XSS

Cross-site scripting is a vulnerability in PHP web applications, which attackers may exploit to steal users&#39; information. You can configure Apache and write more secure PHP scripts (validating all user input) to avoid XSS attacks.

### 6. eval()

Evaluate a string as PHP code. This is often used by an attacker to hide their code and tools on the server itself. You can configure PHP to disable `eval()`.

### 7. Sea-surf Attack (CSRF)

This attack forces an end user to execute unwanted actions on a web application in which he/she is currently authenticated. A successful CSRF exploit can compromise end user data and operation in case of normal user. If the targeted end user is the administrator account, this can compromise the entire web application.

### 8. Clickjacking

***

## How to know if a site is Vulnerable?

Following are free software that will scan and list potential threats to the system as per the software coding standard and server configuration.

1. Vega
2. OWASP ZAP
3. XSSer, BeEF and SQL Map _-Test XSS, Script injection, and MySQL injection_


## Best Practices for Web Application Security
- Disable certain usernames from being used like &#39;test&#39;, &#39;test123&#39;, &#39;admin&#39;, and &#39;root&#39;
- Use automated test code (Eg. PHP QuickCheck)
- Be mindful while creating project structure. Make sure to put upload dir outside of Webroot to prevent public access.
- Use Package or Library available in packagist.org instead of creating a new one.
- Maintain user login table (log in date, time, IP).
- Run the manual test in a certain period of time or after a significant update.
- Disable unused PHP module (eg. `shell_exec`, `system`, `passthru` ) from php.ini for performance and security.
- Put a .htaccess with the following content in upload directory to prevent the execution of PHP file. Instead, it will download the file.

  ```php
  php_flag engine off
  ```
- Always set uploaded file permission to a minimum or non-executable (0644).
- Scramble uploaded file names and extensions

## PHP Backdoors

PHP hidden scripts such as c99, c99madshell, and r57 for bypassing all authentication and access the server on demand are called PHP Backdoors script. This will give them almost every access like download, upload, control to the server, database, and mail server.

To prevent this follow all preventive measure and search for those script in your server time to time.
```sh
 grep -iR 'c99' /var/www/html/
 grep -iR 'r57' /var/www/html/
 find /var/www/html/ -name \*.php -type f -print0 | xargs -0 grep c99
 grep -RPn "(passthru|shell_exec|system|base64_decode|fopen|fclose|eval)" /var/www/html/
```

## Resources

[![OWASP](https://www.owasp.org/images/thumb/f/fe/Owasp_logo.jpg/300px-Owasp_logo.jpg)](https://owasp.org) <br />
Follow **OWASP** secure coding practices and their checklist for testing for any vulnerabilities ( [https://www/owasp.org](https://www/owasp.org)).

<br />
<br/>

[![PHP Security Consortium](http://phpsec.org/images/phpsc-logo.gif)](http://phpsec.org) <br />
**PHPSC** ( [http://phpsec.org/](http://phpsec.org/)) group of PHP experts dedicated to promoting secure programming practices within the PHP community. Members of the PHPSC seek to educate PHP developers about security through a variety of resources, including documentation, tools, and standards.
