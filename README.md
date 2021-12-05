# Sayna-TestBack-NodeJS

## Description

A Laravel API that has a user Authentication with some other ability. 

## HOST
https://sayna-back-test.herokuapp.com/
## Installation

```bash
$ composer install
```

## Running the app

```bash
$ composer artisan serve

```

## All Endpoints

### The root [GET] [/]

+ Response 200 (rendering a greeting html page)

  Welcome Sayna !!

### Register [POST] [/api/register]

Use this in order to get registered

+ Request (application/json)

    ```json
        {
            "firstname" : "John",
            "lastname" : "Doe",
            "date_naissance" : "1998-12-15",
            "sexe" : "M",
            "email" : "john@doe.com",
            "password" : "12345678",
            "password_confirmation" : "12345678"
        }
    ```

+ Response 200 (application/json)

    + Body

    ```json
        {
        "error": false,
        "message": "L'utilisateur a été créé avec succès",
        "user": {
            "subscription": 0,
            "role": "subscriber",
            "firstname": "Abonned",
            "lastname": "Doe",
            "email": "test@gmail.com",
            "date_naissance": "1998-10-10",
            "sexe": "féminin",
            "updated_at": "2021-12-05T15:27:36.000000Z",
            "created_at": "2021-12-05T15:27:36.000000Z",
            "id": 13,
            "cart_id": 4
        }
        }
     ```

    + Response 400 (application/json) in case Required data missing

    + Body

    ```json
        {
        "error": true,
        "message": "un ou plusieurs données obligatoire sont manquants"
        }
     ```
    + Response 400 (application/json) in case email has already an account

    + Body

    ```json
        {
        "error": true,
        "message": "un ou plusieurs données obligatoire sont manquants"
        }
     ```


### Login [POST] [/api/login]

Use this for login

+ Request (application/json)

    ```json
        {
            "email": "john@doe.com",
            "password": "12345678"
        }
    ```

+ Response 200 (application/json)

    + Body

    ```json
        {
            "error": false,
            "message": "L'utilisateur a été authentifié avec succès",
            "user": {
                "id": 13,
                "firstname": "Abonned",
                "lastname": "Doe",
                "role": "subscriber",
                "email": "test@gmail.com",
                "email_verified_at": null,
                "subscription": 0,
                "date_naissance": "1998-10-10",
                "sexe": "féminin",
                "created_at": "2021-12-05T15:27:36.000000Z",
                "updated_at": "2021-12-05T15:27:36.000000Z",
                "cart_id": 4,
                "bill_id": null
            },
            "token": "1|cvSKgdLRB3KbPMTW55aDmq7XxtaEwHKnOLjbshfj"
        }
   ```
   + Response 400 (application/json)

    + Body

    ```json
        {
            "error": true,
            "message": "Email/password manquants"
        }
   ```
    + Response 400 (application/json)

    + Body

    ```json
        {
            "error": true,
            "message": "Email/password incorrect"
        }
   ```
     + Response 423 (application/json)

    + Body

    ```json
        {
            "error": true,
            "message": "trop de tentative sur l'email test@gmail.com  ... veuillez patientez" //5 attemp max ...wait for 2min
        }
   ```

### Get user [DELETE] [/api/user] [Need auth-token in header]

Delete a user account

+ Request (application/json)
    
    Don't forget to add auth-token in your header.

+ Response 200 (application/json)

    + Body

    ```json
        {
            "error": false,
            "message": "Votre compte a été supprimé avec succès"
            }
        }
   ```

### Update the bank card user [PUT] [/api/user/cart] [Need auth-token in header]

Use this to edit some field in your user profile

+ Request (application/json)
    
    Don't forget to add auth-token in your header.
    
    Those four field are required : cartNumber,month,year,default.
    In Postman,you need to use x-www-form-urlencoded in Body.

    ```json
        {
            "cartNumber": "456789-556812-5654584",
            "month": "janvier",
            "year": 2021,
            "default": "don't know"
        }
    ```    

+ Response 200 (application/json)

    + Body

    ```json
        {
            "error": false,
            "message": "Vos données ont été mises à jour"
        }
    ```
+ Response 402 (application/json)

    + Body

    ```json
        {
            "error": true,
            "message": "Informations bancaire incorrectes"
        }
    ```
+ Response 402 (application/json)

    + Body

    ```json
        {
            "error": true,
            "message": "La carte existe déjà"
        }
    ```
+ Response 402 (application/json)

    + Body

    ```json
        {
            "error": true,
            "message": "Vos droits d'accès ne permettent pas d'accéder à la ressource"
        }
    ```


    ```
### Get all songs [GET] [/api/songs] [Need auth-token in header]

    + Request (application/json)
    
        Don't forget to add auth-token in your header.

    + Response 200 (application/json)

        + Body

        ```json
            {
                 "error": false,
                "songs": [
                {
                    "id": 1,
                    "name": "Nui raza",
                    "url": "https://www.youtube.com/watch?v=xK-AvS-effs",
                    "cover": "original",
                    "type": "jazz",
                    "time": "03:50",
                    "created_at": null,
                    "updated_at": null
                }
            ]
            }

    + Response 402 (application/json)

    + Body

    ```json
        {
            "error": true,
            "message": "votre abonnement ne permet pas d'accéder à la ressource"
        }
    ```
        ```

### Get one song [GET] [/api/songs/{id}] [Need auth-token in header]

    + Request (application/json)

        Don't forget to add auth-token in your header.

    + Response 200 (application/json)

        + Body

        ```json
            {
                "error": false,
                "song": 
                {
                    "id": 1,
                    "name": "Nui raza",
                    "url": "https://www.youtube.com/watch?v=xK-AvS-effs",
                    "cover": "original",
                    "type": "jazz",
                    "time": "03:50",
                    "created_at": null,
                    "updated_at": null
                }
            }
        ``` 
### Get bill [GET] [/api/bills] [Need auth-token in header]
    + Request (application/json)

        Don't forget to add auth-token in your header.

    + Response 200 (application/json)

        + Body

        ```json
            {
                "error": false,
                "Bill": 
                {
                    "id": 1,
                    "id_stripe": "001",
                    "date_payment": "2021-12-05",
                    "montant_ht": "120.000",
                    "montant_ttc": "140.000",
                    "source": "Stripe",
                    "created_at": null,
                    "updated_at": null
                }
            }
        ``` 

    + Response 403 (application/json)

    + Body

    ```json
        {
            "error": true,
            "message": "Vos droits d'accès ne permettent pas d'accéder à la ressource"
        }
    ```
### HOPE YOU ENJOY IT :D

