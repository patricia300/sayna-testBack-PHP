# sayna-testBack-PHP

Descrption 

APi with register and login ....update Bank Card ...song list for subscriber user ....see bill for subscriber user

Register a user
route : /api/register METHOD:POST
required data :

{
    "firstname":"Jodn",
    "lastname":"Doe",
    "email":"test@gmail.com",
    "password":"test123456",
    "password_confirmation":"test123456",
    "date_naissance":"1998-10-10",
    "sexe":"féminin" //another option : masculin or autre
    
}

Login User
route : /api/login METHOD:POST
Required data :
{
  "email":"test@gmail.com"
  "password":"test123456"
}

Delete User 
Required token to delete your own user account
route : api/user  METHOD:DELETE

Update Card Information 
route : /api/user/cart METHOD:PUT  Required token to authorize
Required data : in postman..you need to use the x-www-form-urlencoded to function
 {
    "cartNumber": "456789-556812-5654584",
    "month": "janvier",
    "year": 2021,
    "default": "dont"
}

Getting song required token to get songs
route : api/songs or one song api/songs/1  METHOD:GET

Getting bill for user subscriber 
route : api/bills







