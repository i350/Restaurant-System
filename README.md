# Restaurant System

## About

In a system that has three main models; Product, Ingredient, and Order.
A Burger (Product) may have several ingredients:

- 150g Beef
- 30g Cheese
- 20g Onion

The system keeps the stock of each of these ingredients stored in the database. You can use the following levels for seeding the database:
- 20kg Beef
- 5kg Cheese
- 1kg Onion

When a customer makes an order that includes a Burger. The system needs to update the stock of each of the ingredients so it reflects the amounts consumed.
Also, when any of the ingredients stock level reaches 50%, the system should send an email message to alert the merchant they need to buy more of this ingredient.

### Requirements:
First, Write a controller action that:

1. Accepts the order details from the request payload.
2. Persists the Order in the database.
3. Updates the stock of the ingredients.
   Second, ensure that en email is sent once the level of any of the ingredients reach
   below 50%. Only a single email should be sent, further consumption of the same
   ingredient below 50% shouldn't trigger an email.
   Finally, write several test cases that assert the order was correctly stored and the
   stock was correctly updated.
   The incoming payload may look like this:

```
{
    "products": [
        {
            "product_id": 1,
            "quantity": 2,
        }
    ]
}
```

## Database Design
![](/home/islam/Desktop/WebDev/restaurant_system/db_design.png "Database Design")

## Setup
- Clone repository
- Install `Docker` in your machine
- Run the following commands in terminal:
    - `./vendor/bin/sail up`
    - `./vendor/bin/sail artisan migrate:fresh --seed`

## Use
- Login as user using the following credentials:
  <br>Email: `customer@email.com` , Password: `password`

## API
- Import the postman collection included in the repository `Restaurant System.postman_collection.json`.
- Hit the `Login` request to generate access token (No need to copy it to env vars, It will be updated automatically).
- Use the API endpoints available in "Customer Operations" folder.

## Email Notifications
You can view email notifications locally [here](http://localhost:8025).

## Tests
Run the following command inside docker terminal of `larave.test` container: 

`php artisan test`

## License
This project made by [Islam Mohamed Abdelfattah](mailto:IslamM.Abdelfattah@gmail.com) as a coding challenge, 
please don't use without personal approval.
