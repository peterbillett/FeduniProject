# FeduniProject
Connect Me Ballarat Installation Manual

Step-by-step guide for website installation
This document contains information pertaining to the installation of the Connect Me Ballarat website. This project was developed by the combined efforts of the City of Ballarat and Federation University, Mt Helen Campus.  

The concept, vision and ownership of the Connect Me Ballarat project belong to the City of Ballarat staff. 
The client team consisted of: 
Martijn Schroder and Matthew Swards

The development of the Connect Me Ballarat project was conducted by the Federation University, My Helen.
The production team consisted of: 
Peter Billett, Gerard May, Tim McKnight, Baljit Kaur and Tim Russell

Special thanks
Cameron Foale – Project Coordinator
Kathleen Keogh – Project Supervisor
All stakeholders and survey responders who provided project direction and feedback


Table of Contents
Glossary
Version History
Document Summary
Project Packaging Format
Installation Instructions
Configuration Requirements
Usage Guidelines

Glossary
PHP:	PHP Hypertext Preprocessor.  A scripting language commonly used for database development and querying.
Database:		A table, or series of tables, which contain(s) data.
Data:			A value that can be used to obtain information from.
Script:			Special code that executes once certain criteria has been achieved.
Open-source:	Code that has been made publically available to use, but for legal reasons, cannot be used to generate funds or have credit taken for its development. 
OS:	Operating System. Software that handles basic computer functions. Common operating systems include: Windows, Linux, OS X, etc.
Target Audience:	An identified demographic that the product is being primarily developed for.
XAMPP:	Open-source web server software. Allows for the development and management of databases. 

Project Packaging Format
The website files (including the database) are all located here on github. To use the files, you will need to download them then unzip the files (right-click the folder and select ‘unzip’). The files will also be supplied by a link to the github project.
Installation Instructions
Step 1 – Downloading XAMPP
Visit the website ‘Apache Friends’ at the address https://www.apachefriends.org/download.html. Once there, download the latest version of available.
Some of the options may include the following: 
For Windows, try 7.1.10 / PHP 7.1.10 (32 bit) (120MB)
For Linux, try 7.1.10 / PHP 7.1.10 (64 bit) (137MB)
For OS X, try XAMPP-VM / PHP 7.1.10 (64 bit) (308MB) 
Make sure to check the requirements for the OS listed on the same page. There is a list for various OS versions that are compatible with XAMPP. Alternative programs may be used however the project has only been tested using XAMPP. The configuration files may need to be adjusted if different programs are used.

Step 2 – Installing XAMPP
After downloading the XAMPP program, open it to launch the start-up wizard. 
Click the ‘Next’ button.
Make sure that all components are selected then click the ‘Next’ button.
For ‘Installation folder’, select the ‘C:\’ drive (appears as default). 
Unclick ‘Learn more about Bitnami for XAMPP’ then click the ‘Next’ button.
Finally click the next button again to begin installation. 
You may get prompted with a warning regarding Apache HTTP Server trying to access various networks. Uncheck ‘Public networks’, but check ‘Private networks’. Then select ‘Allow Access’ to continue.
Once the installation has finished click the ‘Finish’ button.

Step 3 – Launching XAMPP
*The first time you start XAMPP select which language for XAMPP then click save.*
Bring up the XAMPP Control Panel. 
Next to ‘Apache’, click Start.
Next to ‘MySQL’, click Start.
You may be prompted by your firewall to allow access to mysql. Make sure private networks is selected but public networks is off then click ‘Allow access’.
You may minimise or close the control panel after this step. These settings will remain enabled until manually deactivated. 

Step 4 – Setting up website files
Delete all of the files currently in the XAMPP htdocs directory (default install location is ‘C:\xampp\htdocs’).
Unzip the ‘FeduniProject’ zip file.
Copy all files/folders in the FeduniProject folder (Except the Database folder) into the XAMPP htdocs directory.

Step 5 – Importing the database to XAMPP
In your browser, enter the address: localhost/phpmyadmin.
This will take you to a page that allows you to create/manage databases.
On the top menu of the , you will see a list of tabs. Select ‘Import’.
Click choose file and direct it to the file titled ‘Database.sql’, which is located in the folder titled ‘Database’ from the ‘FeduniProject’ zip file.
In the bottom left-hand corner of window will be a ‘Go’ button. Press it. This will upload the database onto the website.

Step 6 – Finalisation
To test that the website is working, in your browser type in the address bar: localhost
Then click enter and you should see that the website can now be accessible locally through that.
To enable remote connection to the website you will need to configure your network port-forwarding and DNS settings to direct your web domain to the correct computer/server running the website.
If the site does not start, then please try restart the installation process. 3.
Configuration Requirements
You must have a stable internet connection in order to access and host the website.
Hosting the website requires a static IP address or something to update the DNS records if the IP address is dynamic.
Site members holders will need an email address in order to create an account on the website.
You will need to install XAMPP and have it running in order to use the database. This will also require a corresponding OS as outlined, which is outlined on the website ‘Apache Friends’ at the address https://www.apachefriends.org/download.html. An alternate program may be used instead of XAMPP but has no guarantee of working or setup instructions.
You will need the Apache HTTP Server and mysql enabled.
You will need all the files located within the ‘FeduniProject’ folder to be saved in the correct location for the site to load correctly.
The correct database table setup must be used (importing the database file sets this up) but the data in the database may be removed or added to at will. Any changes to the database may cause conflicts with the website and will need to be tested.
You will need a designated Website Administrator to manage the website installation and maintenance. 

Usage Guidelines
This website has been developed with the intent of providing local volunteer organisations within the Ballarat region a quick and easy to use medium for initiating communication, for the purpose of sharing resources between each other. As the target audience for this website is the not-for-profit organisations in Ballarat, this website must also be used for not-for-profit means.
Under no circumstances should this website be used to generate funds, as this website uses code that has been sourced from open-source communities.
