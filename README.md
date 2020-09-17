# Inventory and Shopping Manager

## About the application

The application is an inventory and shopping list manager as a service. It provides the following features: 
- Personalised Inventory and micromanagement
- Database item management
- Add, update and delete items
- Create shopping lists with items from the database
- Save and view previous shopping lists

This is a university dissertation project and is in the works and hold potential to expand

## How to run

The database/SQL folder contains data used for project as initial setup. The project also connects to a database named 'dissertation' (all hosting information saved in the .env file)

To run the project, install all packages with:
##### composer install

Once all packages have been installed, run the following two separate commands on two separate command lines/terminals
##### npm run watch
##### php artisan serve

## Beta features

The application also holds some beta features that are in testing mode:
- Predictable Shopping List Generator
- View Financial history
- Sorting by categories
- Admin access

## API Endpoints

The application has endpoint access to use the features mentioned above. They are:
###### Database Manager

- /getItems: Get all database items
- /postSearchItems: Gets all items related to search element
- /putUpdateItem: Update an item in the database
- /deleteItem: Delete an item in the database

###### Inventory Manager

- /getUserInventory: Get all items in user inventory
- /getPrevBoughtItemUser: Get all previously bought items by the user
- /getExpiringItems: Get all items that have expired since last purchase
- /postAddItemUserInventory: Increase item stock in current inventory
- /postRemoveItemUserInventory: Decrease item stock in current inventory

###### Shopping List Manager

- /getHistory: Gets all shopping history of the user
- /postShoppingList: Save a shopping list for a user

## Security Vulnerabilities

If you discover a security vulnerability within the project, please send an e-mail to Navaneeth Sadasivan via [navaneeth.sadasivan@gmail.com](mailto:navaneeth.sadasivan@gmail.com). All security vulnerabilities will be promptly addressed.

## Thank you for your contribution
