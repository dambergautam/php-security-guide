### File Upload

It allows your visitor to place files (upload files) on your server. This can result in various security problems such as delete your files, delete a database, get user details and much more. You can disable file uploads using PHP or write secure code (like validating user input and only allow image file types such as png or gif).

#### Solution

1. Disable PHP execution in selected directories
    
    Put a .htaccess with the following content in upload directory to prevent the execution of PHP file. Instead, it will download the file.

    ```php
    php_flag engine off
    ```

    **OR**

    Following can be added to your virtual host configuration (on most servers, you won't be able to use it in your .htaccess file): 

    ```php
    <Directory /var/www/example.com/uploads>
        php_admin_value engine Off
    </Directory>
    ```
 
    Test: Create PHP file with some content in it inside uploads directory -you should be seeing PHP source exactly as it the file.

2. Move upload directory outside of web-root which will not allow direct access to images. 
    
    **How it work?**
    
    Since, it is out of scope to access from URL we need to create either symlinks or alias from apache virtual host file. Moreover, we can add additional access restrictions like setting only valid file type to be accessible and preventing files access directly via URL in particular image directory.

    **Apache virtual host file** 

    ```php
    Alias /images /opt/fellowship/images
    <Directory "/opt/fellowship/images">
          Order deny,allow
          Deny from all

          #Only following file types will be accessible.
          <filesmatch "\.(gif|jpe?g|jpg|png|bmp|ico|pdf|docx|doc)$">
                  Allow from all
          </filesmatch>

          #Disable PHP execution in images(including sub-directories) directory
          php_admin_value engine Off

          #Prevent files from direct URL access
          #Options Includes FollowSymLinks MultiViews
    </Directory>
    ```

    **Usage fellowship/app/index.php**
    
    ```html
    <img src="/images/banner.png" />
    ```
