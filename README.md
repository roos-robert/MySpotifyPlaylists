Mixtapeify
==================

## About

A small project in PHP MVC for handling backing up Spotify playlists. Fetches data through the Spotify API to present the correct titles, artists and track length. Also presents functionality for directly playing a song by calling the spotify desktop or mobile app.

## Running app

You can find a running demo of this app at: http://dev2.roosweb.se/Mixtapeify/

## Installation

The app runs on most webservers with PHP5 and MySQL compatibility.

1. Download the entire repro as a .zip
2. Unzip to a folder in your localhost, or webhost root/folder
3. Setup the database, in the Resources->Database folder the .sql for the DB-structure can be found.  
    3.1. Create a new database, for example named "spotifyMixtapes".  
    3.2. Run the code from the .sql file in for example myPHPAdmin to create the structure  
    3.3. From the Setting-sample.php create a Settings.php file containing the path and login information for your database   
4. The application is up, installed and ready to go!

## External resources used in this application

1. Twitter Bootstrap: http://getbootstrap.com

## Further documentation

In the folder "_Documentation" all the documentation for the project can be found, such as testing and UCs. Most of the documents are hosted on Google Drive, which means you will find the links for these documents in .md files.
