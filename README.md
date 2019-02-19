# Putting Local Metadata to Strategic Use: Visualizing 50 Years of Theses Metadata

## Hosting

Theses dashboard uses PHP and Python in the backend and HTML, CSS and Javascript with Jquery and D3 libraries in the frontend.
To host the dashboard, any simple webhost with Mysql compability is enough. Python script is used to scrape theses data from
the original digital collection website and can be run in any machine that Python is installed.

## Building

Anyone can build the theses dashboard website using the files in this repository can following these instructions :

- Copy the files to a webserver
- Create a MySQL user and a MySQL database.
- Change the "config.php" file under "system" folder.
- Import the sample sql file in the repository.

To update the theses :

- Edit the MySQL configuration in the scraper (theses.py file).
- Run the Python script.

