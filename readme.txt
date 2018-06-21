=== Sync-The-Appointments-With-Google-Calendar ===
Requirements:
PHP 5.2.8 or above
Database: MySQL 5 or greater
License: SynapseIndia, version 1

== Description ==
Created events(Appointments) on the website can be synced with the Google Calendar.
Currently appointments are not showing dynamically. If you need to create the appointments, it can be done from database.

== More features in future ==
We will provide the option to add the appointments on the website dynamically and create different types of appointments with the color setting.

=== Steps to install the Google Calendar ==
Step 1) Set CAKEPHP version < 3.0 (Recommended 2.8) as attached in the zip file.

Step 2) Create the Database and mention the host, db login, db password and db name in the database.php file under the config folder. Import the attached database.

Step 3) Create the Project ID and get the client ID and API Key on the developer Google. Use these credentials that allows us to monitor our application's API usage in the Google Cloud Platform Console.

Step 4) Enable the Google Calendar and Google plus services in Google console.

Step 5) Replace the Google console key in core.php file under the config folder.
    Configure::write('App.siteUrl', 'place_site_url_here');
    Configure::write('App.google_app_browser_key', 'place API key here');
    Configure::write('App.google_oauth_client_id', 'place auth client id here');
    
Step 6) If set up is done successfully then access the URL: domain_name/Google-calendar/vets/agenda

Step 7) Test Appointments are created in the database in appointments table.
