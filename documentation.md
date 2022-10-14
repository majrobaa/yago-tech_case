The url to reach the application:
https://fanan.mrzdevelopment.com/

On every page load the application used the following steps:
1. First of all, the index php include the preloader file: 'includes/preload.php'
    - It includes the neccessary files for the code
        - 'includes/config.php' - Contains the basic constants for the application
        - 'class/navigate.php' - This class will be the core of the application. It will handle every event.
    - It is also call the 'session_start' function to be able to use the '$_SESSION' variable in the future
    - It set the autoloader for the classes. It set which file should be included on a class instantiation 
        - Use the class name and include the file from the class folder. Ex: new utils() -> 'class/utils.php' will be included 
		
2. The index.php will create a navigate object

3. The object's constructor will set the basic local variables for the project. 
    - Create a utils object which contains the average functions for the application
    - Set the userdata based on the $_GET parameters
    - Load the chosen user datas
	
4. The index.php file call the navigation object's render function which handle all the neccessary events that the application need.
    - It will include the needed HTML contents
    - If neccessary it will handle the POST requests
        - In case of admin side it will handle the user settings update
        - In case of user side it will show the stored datas about the user and set the Label Expenses field
    - If neccessary it will send an email to the client with an url to open their stored data and saved insurances

5. For the reminder the code will send an email for the users email address with the url where the page is hosted:
   - https://fanan.mrzdevelopment.com