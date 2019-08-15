# TodoApp

This is my Todo App. My Todo app allows users to add, edit, remove tasks on their respective to do list tables.

# How to set up
1. clone the repository.
2. create a mysql database named todo and use it;
3. run all the sql files inside the "tables" directory in this order:
	-	create_roles.sql
	-	create_users.sql
	-	create_tasks.sql
	-	create_taskItems.sql
4. run 'php 127.0.0.1:3000 -t `pwd`' on the root of the project folder
5. go to localhost:3000 using a web browser.
6. done.

## 2 kinds of users
- Admin - can CRUD all users' tasks and user info.
- User - can CRUD his own respective tasks.

## Features/Functionalities
- User Registration Form
- Email verify registration.
- User Login/Authentication
- Users can CRUD their own to-do list.
- Admins can view all users and their tasks.
- Admins can add/update/delete all users' tasks.
- Admins can reset all user's passwords.
- Admin can also CRUD their own to-do list.

## ERD
![enter image description here](https://lh3.googleusercontent.com/_7cFY6Wzu_0W7Nz9SRQZpPRlHITE1ZR9_4PM2TK0sKTNgR3tuU_r1YdQZ1Zs5yjvddNzfqb5C4A "ERD")
## UI

### Login Form
![enter image description here](https://lh3.googleusercontent.com/_uSw3oCvTcwED8xsrPccJZ8EmZ709aYclRH0pd6_xuZ251Zq83pcAN834zO2fMCixuOQmLCVxKs "Login Form")
### Registration Form
![enter image description here](https://lh3.googleusercontent.com/Wpe8fowsT86eso9rgeEl79zUdH7zmlrcc-7QsjkzWbg_irr-9C62-jgEwmR2vqfu7NEDQ7l1lNk)
### Index Page
![enter image description here](https://lh3.googleusercontent.com/K2siglvF64G2hxTftZ9bAAgavVbNSuwXRh-SV6JjLN8njhTLsgfudp5WFFWN-87xNzZ20zwZnY0)
