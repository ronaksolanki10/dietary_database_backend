
# Dietary Database (Backend)

A project is about to build a Backend to manage Dietary Database for nursing home residents with swallowing difficulties

## Author

- [@ronaksolanki10](https://github.com/ronaksolanki10)


## Tech Stack

**Programming Language:** PHP

**Framework:** No Framework, written in Core PHP

**Databse:** MySql


## Installation

Below is the steps to install the project

1. Clone the project
```bash
  git clone https://github.com/ronaksolanki10/dietary_database_backend.git
```
2. Install dependencies

```bash
  composer install
```
3. Create ```.env``` file with below variables

```
DB_HOST=<YOUR_DB_HOST>
DB_DATABASE=<YOUR_DB_NAME>
DB_USERNAME=<YOUR_DB_USERNAME>
DB_PASSWORD=<YOUR_DB_PASSWORD>

JWT_SECRET=<YOUR_GENERATED_SECRET_KEY>
JWT_EXPIRY=3600
JWT_ALGO=HS256

IDDSI_LEVELS=0,1,2,3,4,5,6,7
FOOD_CATEGORIES="chicken,pork,fish,veg"
```

4. Set database credentials and JWT_SECRET accordingly in ```.env``` file

5. Import database tables and pre-inserted users using ```.sql``` file located at root named ```database.sql```

## Feedback

If you have any feedback or query, please feel free to reach out to me at ronaksolanki1310@gmail.com


## Support

For support, email ronaksolanki1310@gmail.com

