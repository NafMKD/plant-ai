# Plant AI

## Project Scope:
The project's objective is to create and launch a web application-based solution designed to provide accurate and timely diagnosis of plant diseases impacting Ethiopian farmers. This solution will leverage AI-driven image recognition and generative AI to identify diseases from images of plant leaves and deliver personalized recommendations for disease management.

## It will be able to have the following functionalities.
- Image Processing
- Disease Identification
- Disease Classification
- Personalized Recommendations
- User Profiles
- Language Support
- Crop Cultivation Assistance
  - Crop Selection
  - Crop Information
  - Step-by-Step Guidance

## Technical Stack:
**Programming Languages**: JavaScript (for front-end development), Python (for back-end development)<br>
**Front-end Frameworks/Libraries**: HTML, CSS , JS<br>
**Back-end Frameworks/Libraries**: Django<br>
**Tools**: Git (for version control), Sqlite3(for database management), Docker (for containerization),

## Installation
### Step 1
clone this repository
``` bash 
git clone https://github.com/NafMKD/plant-ai.git
cd plant-ai
```
### Step 2
Install dependencies
```bash
composer install 
```
###  Step 3
Create ``.env`` file and copy everything from ``.env.example`` to ``.env`` file
for linux
```bash
cat .env.example >> .env
```
and generate ``APP_KEY``
```bash
php artisan key:generate
```
### Step 4
Create `database.sqlite` file in  `database/` folder and migrate the tables
```bash
php artisan migrate
```
>_optional_, you can also seed the users table<br>
**email** : `user@gmail.com`<br>
**password** : `12345678`
>```bash
>php artisan db:seed
>```
### Step 5
Start the server and explore!
```bash
php artisan serve
```

## Contributors
- [Chala Olani]()
- [Kuma Telila]()
- [Mohammed Ali]()
- [Nafiyad Menberu]()
