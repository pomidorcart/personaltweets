## Personal Tweets

A Laravel based application supporting the following features:

-   Social Entity is implemented in Doctrine (Data Mapper Pattern)
-   Auth uses the User model in Eloquent (Active Record Pattern)
-   OAuth implementation of api.twitter.com
-   Fteching 10 most recent tweets using user_timeline endpoint
-   Paginated collection of tweets in blade view
-   Sortable List of social tweets by date in single Angular page view
-   Laravel, Nginx and Mysql services are Dockerised
-   Telescope for monitoring and logging [only exposed locally].

## Instalaltion

1. Start by cloning the repository [in your terminal]:

```
-> git clone https://github.com/pomidorcart/personaltweets.git

-> cd personaltweets
```

### Configure Laravel

```
-> cp .env.example .env
```

#### Setup MYSQL config

Leave already populated constants with default value. Enter username and password. Root password should differ from normal user. Later we will configure the mysql container to grant a non-root user access to personaltweets database. These enviroment settings for database will be used in docker-compose.yml to build the mysql server.

```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=personaltweets
DB_USERNAME=laraveluser
DB_PASSWORD=userPass
MYSQL_ROOT_PASSWORD=rootPass
```

#### Setup the Twitter Settings

Enter your Twitter keys. Screen name is required to get user time_line.

```
TWITTER_CONSUMER_KEY=
TWITTER_CONSUMER_SECRET=
TWITTER_ACCESS_TOKEN=
TWITTER_ACCESS_TOKEN_SECRET=
TWITTER_SCREEN_NAME=
TWITTER_ENDPOINT=https://api.twitter.com/1.1/
```

#### Setup the Telescope Gate

Enter your email address, this is optional if you are not planning to make this app public.

```
TELESCOPE_GATE_EMAIL=
```

```
-> docker-compose build && docker-compose up -d
```

Once the containers are up and running it is time to run lravel migration commands, check if containers are up and running by entering the following command

`-> docker ps`

You should be able to see three containers: personaltweetsapp, db and webserver.

Before migration, we now need to grant a non-root user access to personaltweets database.
Login to the db container and create a new user and finally exit the container by running the following commands [Optional, if you want to give lravel a root access to db]:

```
1. docker-compose exec db bash
2. mysql -u root -p
3. show databases;
4. GRANT ALL ON personaltweets.\* TO 'laraveluser'@'%' IDENTIFIED BY 'userPass';
5. FLUSH PRIVILEGES;
6. EXIT;
7. exit [Note: to exit the container]
```

### Migrate Eloquent Models

```
-> docker-compose exec personaltweetsapp php artisan migrate
```

### Migrate Doctrine Entity

```
-> docker-compose exec personaltweetsapp php artisan doctrine:schema:create
```

## Fetch Tweets and View

Call the follwoing endpoint to fetch the 10 most recent tweets from user timeline:

```
GET: http:localhost/api/social/fetch
```

Call the following endpoint to view the tweets from database constructed in blade template:

```
GET: http:localhost/messages
```

Call the following endpoint to view the tweets from database consutrcuted in single angular page:

```
GET: http:localhost/tweets.html
```

Following endpoint returns the tweets from DB in JSON format:

```
GET: http:localhost/api/social
```

## Test

To test run following command:

```
-> docker-compose exec personaltweetsapp php ./vendor/bin/phpunit
```
