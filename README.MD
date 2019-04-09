# PHP-Rest_api [CRUD]
This is completely in raw php using OOP and class based features.

Run PHP server from this directory
`> php -S localhost:3000`

### __Routes__
Route | Links | Type |
------|-------| ----- |
Create | http://localhost:3000/create_user.php | POST
Read   | http://localhost:3000/read_all_user.php <br>http://localhost:3000/read_one_user.php?id=id  | GET
Update | http://localhost:3000/update_user.php | PUT/POST
Delete | http://localhost:3000/delete_user.php | DELETE/POST
Search | http://localhost:3000/search.php?s=query-string | GET
Pagination | http://localhost:3000/read_paging.php | GET 


### Database Structure __MYSQL with PDO__

- User
    1. id [auto increment]
    2. username [unique]
    2. password [unique]
    2. created_at [default timestamp]

In Search route id and username can be searched. Update route can handle both username and password update or anyone update.
```javascript
{
    id:1,
    username:"any name",
    password:"xxxxxxxx"
}
```

## TODO
- [ ] Password hashing
- [ ] Email Verify
- [ ] Password Recovery
- [ ] Security  and Bug Fixing

Inspired From : [codeofaninja](https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html)
