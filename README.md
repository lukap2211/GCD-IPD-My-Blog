# GCD - Internet Programming and Databases
Internet Programming and Databases assignment: PHP/MySQL Project - Album Reviews 

## Application design: Overall Design
“Album Reviews” application is a database-backed blogging application for writing album reviews. 
It allows non-registered users to:
- view reviews
- search reviews
- filter reviews by:
    - year
    - stars
    - genre
    - user

Beside the actions for non-registered, registered users can:
- add/edit/delete user
- add/edit/delete genre
- add/edit/delete album review

Structure of the site  has 3 main sections: Header, Main Content, Sidebar
#### Header
Header section allows user to access users section (login/logout) in upper right corner, and access the home page from the menu underneath the main title

#### Main Content
Main Content section displays 10 latest inserted/edited album review listings (accessed from main menu “home”) by default or the content related to a selection from the right sidebar (album review listings, album review detail page, genre listings, genre detail page, users detail page, and add/edit/delete views for all three entities - albums, genres, users)

#### Sidebar
Sidebar on the right has Search box that returns results based on users search keyword. Search is performed over multiple fields in the database (album review, title, year, artist and genre). Search result page shows users search keyword in on the top of the page.
__Sidebar - Admin Area__
Underneath Search box, only signed users can see Admin Area section that allows signed users to: 
- Add Review
- View Genres
- Add Genre
- Add User
- Update Profile 

Beside the actions listed in the right sidebar, signed in users can also when on detail page of each entity (albums, reviews, users) access add/edit/delete pages for that particular entity.

All admin area and its related actions are visible only while user is logged (regulated by session)

__Sidebar - Filter by Stars__
Allows users to filter all albums reviews by stars. Filter result page shows users filter selection on the top of the page.

__Sidebar - Filter by Genres__
Allows users to filter all albums reviews by genres, displaying total count for each genre. Filter result page shows users filter selection on the top of the page.

__Sidebar - Filter by Year__
Allows users to filter all albums reviews by year, displaying total count for each year. Filter result page shows users filter selection on the top of the page.


### Application wide features

Each input form has build in validation and notification system. Green font/background for successful message, red font/background for error.

#### src

```shell
.
├── SQL
│   └── my_blog.sql
├── album.php
├── css
│   └── style.css
├── documentation
│   ├── database.pdf
│   ├── evaluation.pdf
│   └── overall\ design.pdf
├── genre.php
├── images
│   ├── bg.jpg
│   ├── black.png
│   ├── stars_1.png
│   ├── stars_2.png
│   ├── stars_3.png
│   ├── stars_4.png
│   ├── stars_5.png
│   └── white.png
├── include
│   ├── album_functions.php
│   ├── album_validate.php
│   ├── aside.php
│   ├── connect.php
│   ├── footer.php
│   ├── genre_functions.php
│   ├── genre_validate.php
│   ├── header.php
│   ├── login_form.php
│   ├── style.css
│   ├── user_functions.php
│   ├── user_validate.php
│   └── years.php
├── index.php
├── login.php
├── login_check.php
├── login_success.php
├── logout.php
├── test.php
└── user.php
```
