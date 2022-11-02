# Bug tracking app

This is a simple PHP 7.3 application to improve TDD skills.

## Installation

```bash
composer install
```

## Execute tests

You can execute all the test with the next command:

```bash
vendor/bin/phpunit Tests --testdox
````

Or execute only one test file:

```bash
vendor/bin/phpunit Tests --testdox --filter <test file name>
```

## UML Class Diagram

```mermaid
classDiagram
  class QueryBuilderInterface {
    +prepare(query)
    +execute(statement)
  }
  class PDOQueryBuilder {
    +count()
    +get()
    +execute(statement)
    +lastInsertedId()
    +prepare(query)
  }
  class QueryBuilder {
    #bindings
    #placeholders
    #statement
    #connection
    #fields
    #operation
    #table
    +__construct(databaseConnection)
    +table(table)
    -parseWhere(conditions, operator)
    +where(column, operator, value)
    +create(data)
    +select(fields)
    +update(data)
    +raw(query)
    +find(id)
    +findOneBy(field, value)
    +first()
    +setStatementType(type)
    +count()
    +get()
    +execute(statement)
    +lastInsertedId()
    +prepare(query)
  }
  class MySQLiQueryBuilder {
    -results
    -resultSet
    +count()
    +get()
    +execute(statement)
    +lastInsertedId()
    +prepare(query)
    -parseBindingType()
    +parseBindings(params)
  }

  QueryBuilderInterface <|.. PDOQueryBuilder
  QueryBuilder <|-- PDOQueryBuilder
  QueryBuilder <|-- MySQLiQueryBuilder
  QueryBuilderInterface <|.. MySQLiQueryBuilder
```

```mermaid
classDiagram
  class AbstractConnection {
    #credentials
    #connection
    +__construct(credentials)
    -credentialsHaveRequiredKeys(providedKeys)
    #parseCredentials(credentials)*
  }
  class DatabaseConnectionInterface {
    +connect()
    +getConnection()
  }
  class PDOConnection {
    +connect()
    +getConnection()
    #parseCredentials(credentials)
  }
  class MySQLiConnection {
    +connect()
    +getConnection()
    #parseCredentials(credentials)
  }

  AbstractConnection <|-- PDOConnection
  AbstractConnection <|-- MySQLiConnection
  DatabaseConnectionInterface <|.. PDOConnection
  DatabaseConnectionInterface <|.. MySQLiConnection
```
