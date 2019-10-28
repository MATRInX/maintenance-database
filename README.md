# MAINTENANCE DATABASE

This is my first repository created almost three years ago during my first steps in web app development.
In my previous work we had some web app - maintenance database to collect all informations about machines which we maintain, all breakdowns and other information necessary in daily duties.
In that time I have started to learn Angular 1.6 so i decided to upgrade this app with Angular.
This app was an PHP app without any Front-end part so my addition was first frontend part of this app.

## Instalation

If you want to check how it's work on your local machine just clone this repository:

```git
git clone git@github.com:MATRInX/maintenance-database.git
```

To be able to run this app you have to install some php local server with MySQL database.
In order to run this app you have to start php server with MySQL database on it.
You will find in main directory sql file to create and fill database with example data.
Then just copy all files to server and start the app.

## Usages

This app is fully working network app with full functionality to collect data about your machine park in your company. This is very old app and their analyze is not so easy because of it backend and old-fashioned character.
If you want to use it it's not a problem I can show you how to use it on your local network :smile:

## Pros and cons

I will try to prepare on each of my repository area where I will try to assess my app and check what was totally wrong and what was nice for me during my learning path.

\+ I have added angular framework to very old php app!!<br>
\+ It was my first experience with working web app,<br>
\+ I learned a lot about web app development during work on this modification - I have found that this is something what I want to do in my future,

\- Really big mess in main folder - there is no folder only for frontend and backend - it's really easy to get lost in main folder,<br>
\- It's really hard to find php part of app and frontend part with javascript, html and css code,<br>
\- In my repository there are some files Microsoft Visual Studio environment - in repository these files are un necessary,<br>
\- All javascript and css files are included to app statically - in that time I was not using webpack yet,<br>
\- Files are divided in most cases by extension and file type not logic what would be too much better,<br>
\- In app.config.js file I have created two level menu const - second nesting level is array which is not flexible and easy for modification,<br>
\- In almost each component I have used call of angular.module('fileStoreApp') - it should be call only once and exported by some const name,<br>
\- All components and other angular parts are not designed to be reused once again,

## Summary

This app is not perfect - it's very old and very hard to maintain but it was my first step to modern web app development. I am very happy that I was able to prepare this modification and that it's working till today! Also this app was first project where I ahve used angular framework which I was learning in that time.

## License
[MIT](https://choosealicense.com/licenses/mit/)