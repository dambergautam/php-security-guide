# Web Application Security [Parameter Tempering]

Hacker can manipulate data easily before sending to web server using hidden fields, URL or proxy softwares (eg. Burp). 
The application should not simply trust on user input value that can modify things like prices in web carts, session tokens and HTTP headers.

## Hidden Field Value Manipulation

Hidden, drop down, pre-selected, check-box field values are easily manipulated by the user using proxy software or simply downloading page and modifying field values & re-loading the page in the browser.

Solution 

1. Use session variable instead of using hidden form fields to store variables.
2. Or use encrypted values to compare if the field has been altered or not.

```php
- $digest_value = md5('input_field_name'.'input_field_value'.$salt);
- Add additional hidden field for digest value
- Finally, when form is submitted generate md5 of actual field value and compare against hidden digest value.
```

## URL Manipulation

URL Manipulation is more vulnerable than other type of vulnerability as it is easy to alter query string from URL address. 

```php
http://www.example.com/product?pid=12345&price=500

TO => http://www.example.com/product?pid=12345&price=1
```

Solution

- Best solution is to avoid putting parameters into a query string.
- In the case when parameters from client is needed, they should accompanied (escort) by a valid session token (Eg. above example of hidden field). 
- Use cryptographic protection for sensitive parameter in a URL.
- Use proper validation of input received (sanitize data, cross check user input in database, use JOIN TABLE)