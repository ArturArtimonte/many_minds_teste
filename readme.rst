###################
CodeIgniter and MariaDB project
###################


This is a web application built using CodeIgniter and MariaDB. It allows users to create orders and products, as well as edit existing ones. The code is not fully tested and some changes to the database may be necessary.

*******************
Installation
*******************

To install the application, follow these steps:

1. Run the init.sql file to create the database.
2. Copy the application files to your web server.
3. Modify the database.php file to connect to your database.
4. Run the application in your web browser.

*******************
Usage
*******************
The application allows users to create orders and products, as well as edit existing ones. Users can also alter permissions in the alter user table.

*******************
Security
*******************
The application does not currently have access tokens or other security measures. Some security features may be implemented in the future.

*******************
To-do
*******************
**Some possible improvements for the application include:**

1. Standardizing layout/routes/structure.
2. Implementing Docker. /// DONE
3. Adding security measures.

**Features**

1. Add validation to prevent users from creating an order without any products. An alert message could be displayed asking the user to create a product on the /orders page.
2. Fix the Home button on the /orders page to redirect to the correct route.
3. Add maximum character limit validation to all input fields throughout the system to prevent layout issues on subsequent pages.
4. Add a "Back to Home" button on all pages to make the system more user-friendly.
5. Fix the /alter_collaborator page to correctly edit collaborator information.
6. Improve field validation on the /create_colab and /alter_collaborator pages.
7. Add inventory quantity validation when creating a new order.

*******************
Notes
*******************
This project was created as a case study and exam, and as such, we approached the same problems from various angles. Some functions that could be the same are made in two different ways, first for study purposes, second to demonstrate, and third to measure performance. As a result, there may be some inconsistency in the code. Additionally, there are some errors in the frontend that will be corrected in the future.

*******************
Bug Fixes:
*******************

1. The Home button on the /orders page does not redirect to the correct route.
2. The /alter_collaborator page is not correctly editing collaborator information.

*******************
License
*******************
This project is licensed under the MIT license. Feel free to use anything that you need without any problems
