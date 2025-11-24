The site is online on this [link](https://raphael.zron.fr)
If you want to run the site on your own side, you need a file BDD.php in folder BDD. This file need to look like
```php
<?php
function connectDatabase(): PDO {
    return new PDO('mysql:host=localhost;dbname=portfolio', "root", "");
}
```