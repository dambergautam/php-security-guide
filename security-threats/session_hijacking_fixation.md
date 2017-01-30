### Session Hijacking and Session fixation

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
