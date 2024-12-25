# Project management
1. ### Install PostgreSQL.
2. ### Start PostgreSQL server.
3. ### Create DB via the interface PostgreSQL.
   - Enter the interface postgresSQL: `psql postgres`;
   - Create database: `CREATE DATABASE products` ;
4. ### Create user via the interface PostgreSQL.
   - Create user: `CREATE USER admin WITH PASSWORD 'password'`;
   - Grant database permissions: `GRANT ALL PRIVILEGES ON DATABASE products TO admin`;
   - (Optional) Check the rights: `\du`;
   - (Optional) Make another user the owner of the database: `ALTER DATABASE products OWNER TO newAdmin;`
5. ### Create table via the interface PostgreSQL.
   - Connect to DB: `psql -U admin -d products`
   - Create table:
```sql
 CREATE TABLE products (
     id SERIAL PRIMARY KEY,
     title VARCHAR(255),
     quantity INT,
     price FLOAT,
 );
 ```
   - (Optional) Check the rights: `\dt`;
   - (Optional) Check structure table: `\d products`;
6. ### Create local server.
   - Go to your project directory;
   - Create server `php -S localhost:8080`;
7. ### Composer.
   - Run command `composer install` 
8. ### Using the API. 
https://documenter.getpostman.com/view/40553759/2sAYJ4jLz1



