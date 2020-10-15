# MONOCLUS / DB

This is a lightweight wrapper for PDO. It is meant so solve some obvious gaps PDO has now. It is NOT a replacement for PDO.

## Quick example:

    Connection::create()
        ->table('users')
        ->insert(['user_name'=>'tom',
                  'first_name'=>'Tom',
                  'last_name'=>'Sawyer']);
                  
## Obvious limitations

- It is not an ORM. Should you need one, try [Doctrine](https://www.doctrine-project.org/).
- Version 0.1 only works with MySQL.
- It is not a replacement for PDO

## Examples

### Connecting to the database

    use monoclus\db
    
    // Option 1: Create an object
    $conn = new Connection($dsn, $user, $pass);

    // Option 2: Use a builder
    Connection::create($dsn, $user, $pass);
    
    // Option 3: Create an object, but the parameters must be store in $_ENV
    $conn = new Connection();
    
    // Option 4: Use a builder with $_ENV parameters
    Connection::create();
    
    
### 

    Connection::create()
        ->throwExceptionOnError()

### Insert

    Connection::create()
        ->table('users')
        ->insert(['user_name'=>'tom',
                  'first_name'=>'Tom',
                  'last_name'=>'Sawyer']);

### Update

    Connection::create()
        ->table('users')
        ->filter(['id'=>4])
        ->update(['user_name'=>'tom',
                  'first_name'=>'Tom',
                  'last_name'=>'Sawyer']);

### Delete

    Connection::create()
        ->table('users')
        ->filter(['id'=>4])
        ->delete();

### All other cases

Use the standard PDO functions and, ideally, thy to use prepared statements.

https://www.php.net/manual/en/book.pdo.php

    $sql = 'SELECT name, colour, calories
            FROM fruit
            WHERE calories < :calories AND colour LIKE :colour';
    $sth = Connection::create()->prepare($sql);
    $sth->bindParam(':calories', $calories, PDO::PARAM_INT);
    $sth->bindValue(':colour', "%{$colour}%");
    $sth->execute();

or, to update more records:

    $sql = 'UPDATE fruit 
            SET calories = :calories + 5 
            WHERE colour = :colour';
    $sth = Connection::create()->prepare($sql);
    $sth->execute();
