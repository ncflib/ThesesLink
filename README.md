# Putting Local Metadata to Strategic Use: Visualizing 50 Years of Theses Metadata

## How is it built ?

Theses dashboard uses PHP and Python in the backend and HTML, CSS and Javascript with Jquery and D3 libraries in the frontend. D3.js is a powerful Javascript library that brings data to life using HTML, SVG, and CSS and heavily used in the simulation page. Python script is used to scrape theses data from the original digital collection website ( http://ncf.sobek.ufl.edu/theses ) and can be run in any machine that Python is installed.

## What are we visualizing ?

Theses dashboard visualizes the relationship between divisions, AOCs ( majors ) and theses. It is helpful to see theses data in AOC level to 

## Building

Anyone can build the theses dashboard website using the files in this repository can following these instructions :

- Copy the files to a webserver
- Create a MySQL user and a MySQL database.
- Change the "config.php" file under "system" folder.
- Import the sample sql file in the repository.

To update the theses :

- Edit the MySQL configuration in the scraper (theses.py file).
- Run the Python script.

