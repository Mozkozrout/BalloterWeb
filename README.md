# BalloterWeb
Web application intended for assistance with adjudicating academic debates. Keeps the record user profiles, motions and debate ballots and allows viewing and creating new motions and ballots with helpful interface

In order to run this up Node.js, PHP, yarn and composer are required<br>
as well as some sort of a LAMP stack web server with MySQL<br>

1.) Download this app<br>
2.) Use .env.example to create .env file and configure your DB connection in it<br>
3.) Open the terminal in Backend/balloterAPI<br>
4.) Run command composer install<br>
5.) Run command php artisan migrate<br>
6.) Run command php artisan db:seed<br>
7.) Run your web server in the Backend/public folder or run php -S localhost:8080 -t ./public<br>
Running PHP server might need tweaking of API endpoints<br>
8.) Open the terminal in Frontend/BalloterFront<br>
9.) Run command yarn install<br>
10.) Run command yarn quasar dev<br>

You can use a testing account or register your own<br>
### Testing credentials:<br>
username: test@test.cz<br>
password: Test1234!<br>


