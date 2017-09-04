# Login With Instagram
Login with Instagram and categorize your images in several categories ex: smile, sad, temple, friendship, photography etc.


### Prerequisites
* PHP 5.3 or higher
* cURL
* Registered Instagram App
* Registered Google Cloud Vision Project


## Getting Started

To use the Instagram API you have to register yourself as a developer at the [Instagram Developer Platform](http://instagr.am/developer/register/) and create an application. You will receive your `client_id` and `client_secret`..

To use the Google Cloud Vision API you have to set up your project at [Google console](https://console.cloud.google.com/). Follow google docs for [quickstart](https://cloud.google.com/vision/docs/quickstart). To get Service account's creadentials, Please follow this [doc](https://developers.google.com/identity/protocols/OAuth2ServiceAccount)


### Installing

Clone Repository 

```
git@github.com:Shakir-Khan/login-with-instagram.git
```
Install composer to install depedencies

```
curl -sS https://getcomposer.org/installer | php
```
Install depedencies

```
php composer.phar install
```

Change config files according to your credentials. 1. [database](https://github.com/Shakir-Khan/login-with-instagram/blob/develop/app/Config/database.php.default) 2. [google](https://github.com/Shakir-Khan/login-with-instagram/blob/develop/app/Config/google_credentials.json.default) 3. [instagram](https://github.com/Shakir-Khan/login-with-instagram/blob/develop/app/Config/instagram_credentials.json.default)


Create users table to store user log

```
CREATE TABLE users(
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(70), 
  name VARCHAR(100),
  bio TEXT,
  website VARCHAR(200), 
  instagram_id bigint,
  access_token VARCHAR(200),
  profile_picture VARCHAR(500),
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

Give recursive permission to webserver user to write log in app/tmp folder.

## Preview

![Image](https://image.ibb.co/k6Y1mv/Screenshot_from_2017_09_04_17_27_21.png)

## Contributing

Please read [CONTRIBUTING.md](https://github.com/Shakir-Khan/login-with-instagram/blob/master/CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests.


## Authors

* **Shakir Khan** [github](https://github.com/Shakir-Khan)

See also the list of [contributors](https://github.com/Shakir-Khan/login-with-instagram/graphs/contributors) who participated in this project.
