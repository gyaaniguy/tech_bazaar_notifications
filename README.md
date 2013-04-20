tech_bazaar_notifications
=========================

Scrapes and shows various indian tech forums for buy-sell deals. My very first scraping program

****************
INSTRUCTIONS
****************

1. unzip and copy the folder(notification_give) to your hosting account
2. log into phpmyadmin and create a database named 'notification'
3. in your cpanel create/use username to work with created database
3. edit the variables in the file notification_give\includes\constants.php (DB_USER is the user you just associated with the just created database) 
4. edit the file notification_give\includes\fetch_functions.php and add your techenclave username and password to the variable $techenclave_user and $techencalve_pass . MAKE SURE YOUR TECHENCLAVE ACCOUNT HAS THE PERMISSION TO VIEW MARKET THREADS ON TECHENCLAVE.
5. run the script notification_give\create\create_table.php to create tables in the database.
6. import the file notification_give\all_addresses.sql to your database ,( using phpmyadmin) // this is just a database of bazaar threads already fetched by us.

We are done setting up. Now all we have to do is fetch the data from the forums. For this 

1. Go to : notification_give\index_proper.php to check if there anything shows . Take a mental note of the listings.
2. run \notification_give\search_for_changes.php wait for it complete. Ignore the output/warnings/Notice(my script ain't perfect). Now go back to index_proper.php and check if the results were updated.
3. if everything went ok . create a new cron job for the script \notification_give\search_for_changes.php (once every 3-6 hours)
4. in order to contain the number of entries in our database there is a script notification_give\delete\delete.php. its not required, but soon you will want to 
    keep the size of the databse in control. BE CAREFUL WITH THIS. THIS DELETES OLD ENTRIES FROM THE database, use only after taking backups of all the databases in your hosting account. 

Thats all there is to it. feel free to rename/style index_proper.php  

Note : i have disabled the email notifier feature, as practically no one was using it and it would make setting up things a bit more complicated.

For questions: use the forums, Pm me on thinkdigit OR nik.jain A t gmail.com

LASTLY: Please don't remove the line "Coded by Nikhil Jain"