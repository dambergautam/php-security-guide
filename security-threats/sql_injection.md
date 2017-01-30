### SQL injection

It is a vulnerability in the database layer of a PHP application. When user input is incorrectly filtered any SQL statements can be executed by the application. You can configure Apache and write secure code (validating and escaping all user input) to avoid SQL injection attacks.

```sql
$sql = "SELECT * from tbl_name1 where name = ' Smith'); Drop TABLE tbl_name2;-- '";
```

#### Solution

1. Use Prepared Statements, also known as parametrized queries.

    ```SQL
        $stmt = $pdo->prepare('SELECT * FROM blog_posts WHERE YEAR(created) = ? AND MONTH(created) = ?');
        if ($stmt->execute([$_GET['year'], $_GET['month']])) {
          $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    ```
2. Sanitize input

    Useful functions: `trim`, `array_filter`, `filter_var`, `mysqli_real_escape_string`, `strip_tags`, and `htmlspecialchars`.

    ```php
        filter_var("not a tag < 5", FILTER_SANITIZE_STRING); //Output: not a tag
        array_filter($_POST, 'trim_value');    // the data in $_POST is trimmed
    ```

3. Input should still be validated which is not same thing as sanitation.

    In most case `filter_var()` is useful here.
    ```php
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        if (empty($email)) {
            throw new \InvalidArgumentException('Invalid email address');
        }
    ```

4. In case of parametrizing column or table identifiers -

    **Option 1:** Perform White list validation that explicitly only allows a few accepted values.

    ```php
        if(in_array($_POST['orderby'], array('name', 'address')){
          //true
        }else{
          //Warning
        }
    ```

    or

    ```php
        switch ($_POST['orderby']) {
            case 'name':
            case 'exifdate':
            case 'uploaded':
               // These strings are trusted and expected
               $qs .= ' ORDER BY ' . $_POST['orderby'];
               if (!empty($_POST['asc'])) {
                   $qs .= ' ASC';
               } else {
                   $qs .= ' DESC';
               }
               break;
            default:
               // Some other value was passed. Let's just order by photo ID in descending order.
               $qs .= ' ORDER BY photoid DESC';
        }
    ```

    **Option 2:** If you can't restrict identifiers, you must resort to escaping.
    - Just dont escape SQL meta characters (eg. `'`)
    - Filter out every char that isn't allowed

    ```SQL
        --Only allow table name that begin with an upercase or lowercase letter followed by any number of alphanumeric chars and underscore
        if (!preg_match('/^[A-Za-z][A-Za-z0-9_]*$/', $table)) {
            throw new AppSpecificSecurityException("Possible SQL injection attempt.");
        }
    ```
