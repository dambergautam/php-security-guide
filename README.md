# Web Application Security

## Introduction

This document will list possible security threats to the Web application, explanation and preventive measures.

1. [SQL injection](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/sql_injection.md)
2. [File Upload](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/file_upload.md)
3. [Session Hijacking and Session fixation](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/session_hijacking_fixation.md)
4. [Remote file inclusion](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/remote_file_inclusion.md)
5. [XSS](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/xss.md)
6. [eval()](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/eval.md)
7. [Cross-Site Request Forgery (CSRF)](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/csrf.md)
8. [Clickjacking](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/clickjacking.md)
9. [Parameter Tempering](https://github.com/dambergautam/php-security-guide/blob/master/security-threats/parameter_tempering.md)

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
