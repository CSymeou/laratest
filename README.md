## Laravel Test Application

This mini application was prepared as a test for Intergo.

You can view the app from [http://laratest.blupath.co.uk](http://laratest.blupath.co.uk) (I've not gone through the trouble of serving this over HTTPS.

Initial points:
- I used bootstrap 4 as the css library through laravel/ui. [See here](https://www.techiediaries.com/laravel/how-to-install-bootstrap-in-laravel-6-7-by-example/).
- I scaffolded authorization backend and pages using the laravel/ui bootstrap 4 auth scaffolding. [See here](https://www.techiediaries.com/laravel/how-to-install-bootstrap-in-laravel-6-7-by-example/).
- As I used the default auth scaffolding, there's actually also pages for Registration, Forgot Password, etc, although I'm not linking to any of those pages from within the app. I've not setup any settings for sending emails, so even if you manually try to access those pages, functionality is not likely to work. I also have not produced any tests for the auth behavior, again, given I'm using the default scaffolding.
- For icons I used the heroicons set. [See here](https://github.com/blade-ui-kit/blade-heroicons/).
- As the application was designed as an exercise and there were no requirements for multilingual versions, I hardcoded strings into the various views and components, and did not use language strings. In a real application I would typically always use language strings to prepare for potential future localisations.
- In the past I've used the Laravel Permissions package ([See here](https://spatie.be/docs/laravel-permission/v3/introduction)), to store roles and permissions in the database, and associate them with users. For this example I kept things simple, and am just defining $user->role as a field in the users table, and permissions as Gates in AuthServiceProvider.
- Have defined all my tests as Feature tests.

## About the functionality

There are 3 user roles in the application:
 - Administrator
 - Leader
 - User

The functioanlity available to each is different, so you will need to log in as all 3 users to review the full app.

 - Administrator:
   - Has access to Home Screen: Views all tasks and users. Can create, edit, delete, tasks and users.
   - Has access to Teams Screen: Views all teams. Can navigate to details screen for each team, to see users in the team and associated tasks.
   - Cannot have tasks assigned to them
   - Their own details cannot be update, nor can they be deleted.
 - Leader:
   - Has access to Home Screen: Views all tasks and users. Can create, edit, delete, tasks and users.
   - Has access to My Team Screen: Views all users in the team they lead. Can unassign / assign tasks to team members. Can remove / add users from the etam.
   - Cannot have tasks assigned to them
   - Their own details cannot be update, nor can they be deleted.
 - User:
   - Has access to Home Screen: Views all tasks and users. Can create, edit, delete, tasks and users.
   - Has access to My Tasks Screen: Views all tasks assigned to them. Can update task progress.

<strong>Note: </strong> I've not added functionality for changing the roles of users to leader or administrator, etc. When you create a new user, they'll all be given the user role. If you want to login to the application as a leader or administrator, please use the test data below.

The application is seeded with details of users and tasks to facilitate testing. Below are the email / password combinations for all seeded users.

  - Administrator:
    - admin@admin.com / admin
  - Team leaders:
    - leader1@leader.com / leader
    - leader2@leader.com / leader
    - leader2@leader.com / leader
  - Users:
    - user1@user.com / user
    - user2@user.com / user    
    - user3@user.com / user
    - user4@user.com / user
    - user5@user.com / user
    - user6@user.com / user
    - user7@user.com / user
    - user8@user.com / user
    - user9@user.com / user    

## Accessing the application

I've made a remote deployment at [http://laratest.blupath.co.uk](http://laratest.blupath.co.uk).

You can clone this repository on your own local dev environment to test the app out. You will need to set up an .env file to define your database connection. You can download my example .env from [here](https://www.dropbox.com/sh/qr1113xgfblm2uf/AABsV0M9JHjatbA82QT1yPJxa?dl=0). 

You can also get the application as a docker image by pulling the public image christossymeou/laratest. You can find a docker-compose.yml file from here.

Further down this document I have also set instructions for deployment on an nginx server with Docker.

## Domain Model

See also a simple visual representation of the DB [here](https://www.dropbox.com/sh/qr1113xgfblm2uf/AABsV0M9JHjatbA82QT1yPJxa?dl=0).

I used 3 Models:

- User: 
  - Represents a user in the application. 
  - Has a role property that determines the user role. The roles available are admin / leader / user
  - Can belong to a team. Team user belongs to determined by team_id value. Nullable: User can belong to no team.
  - Can be a leader of a teamn. Determined by leader_id value on Team object.
  - Relationships:
    - One to Many: with Task
    - One to Many: with Team (for team leader - in theory a user can be a leader of many teams, though the data I've seeded in the application does not reflect that.)
    - Many to One: with Team (for team member)
- Task:
  - Represents a user task
  - Each task has a progress value associated with it which defaults at 0.
  - Can be assigned to a single user. Determined by assignee_id on model.
  - Relationships:
    - Many to One: with User
- Team:
  - Represents a team of users
  - Could probably do without this for this app, and make do with a many to one relationship between users to represent leader -> teammembers, but I think conceptually having a team model makes the domain model more easy to understand
  - Each team has a leader, determined by leader_id value on team object.
  - Relationships:
    - Many to One: with User (for team leader)
    - One to Many: with User (for team member)

<strong>Note:</strong> I did consider creating 3 seperate models for User, Leader, Admin, and having them inherit from the base User model, but decided against it for such a simple app. I'm instead just using scopes on the User model to separate between the 3 different types of user.

## Database

You can find a simple visual representation of the database structure [here](https://www.dropbox.com/sh/qr1113xgfblm2uf/AABsV0M9JHjatbA82QT1yPJxa?dl=0).

There are 3 simple tables

 - Users:
   - id: Unsigned Big Int
   - team_id: Unsigned Big Int
   - name: String
   - email: String | Unique
   - email_verified_at: timestamp
   - password: string
   - role: string(16) | default: user
   - remember_token: string
   - created_at: timestamp
   - updated_at: timestamp
 - Tasks:
   - id: Unsigned Big Int
   - name: String
   - progress: tinyInt | nullable | default(0)
   - assignee_id: Unsigned Big Int | nullable
   - created_at: timestamp
   - updated_at: timestamp
 - Teams:
   - id: Unsigned Big Int
   - leader_id: Unsigned Big Int

## Deploying remotely

The following are instructions to deploy the app in a nginx server using Docker. You can adapt the following for other server configurations.

1) Fire up a new nginx server with whichever cloud services provider you are using (I've moved from using AWS to Digital Ocean). Use an image with Docker preinstalled if one is available.

2) SSH into the server

3) If Docker is not already installed, go ahead and install it. For Digital Ocean instances, you can follow the directions [here](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04). I won't copy and paste them to save space.

4) Navigate to the server documents root. For ngingx:
    <pre>
    cd /var/www
    </pre>

5) Create a new folder for the application, and a new subfolder to hold the database data.
    <pre>
    mkdir laratest
    cd laratest
    mkdir db-data
    </pre>

6) create a docker-compose.yml file to startup the app and database.
    <pre>
    touch docker-compose.yml
    nano docker-compose.yml
    </pre>    

7) Copy the following in the docker-compose.yml file, save and close. 
<strong>Important note:</strong> In the ports configuration for the 'web' service, I am mapping port 8081 of the host, to port 8080 of the docker container. If you are using port 8081 in this server instance, select a different port. Also in the APP_URL env variable, make sure you define whichever URL you will want to access the app from. 
<pre>
version: '2.2'
services:
  web:
    image: christossymeou/laratest
    container_name: laratest
    restart: always
    links:
      - db
    ports:
      - 8081:8080
    environment:
      - APP_NAME="TRAINING MVC"
      - APP_ENV=production
      - APP_KEY=base64:qKYKN6W0mP6wZRmdAs+b/GPYgOcajaa2tomB647U+hw=
      - APP_DEBUG=false
      - APP_URL=http://laratest.blupath.co.uk
      - LOG_CHANNEL=stack
      - LOG_LEVEL=debug
      - DB_CONNECTION=mysql
      - DB_HOST=db
      - DB_PORT=3306
      - DB_DATABASE=laratest
      - DB_USERNAME=root
      - DB_PASSWORD=password
      - BROADCAST_DRIVER=log
      - CACHE_DRIVER=file
      - SESSION_DRIVER=file
      - SESSION_LIFETIME=120
      - SESSION_ENCRYPT=false
      - QUEUE_CONNECTION=sync
      - MEMCACHED_HOST=127.0.0.1
      - REDIS_HOST=127.0.0.1
      - REDIS_PASSWORD=null
      - REDIS_PORT=6379
      - MAIL_MAILER=smtp
      - MAIL_HOST=mailhog
      - MAIL_PORT=1025
      - MAIL_USERNAME=null
      - MAIL_PASSWORD=null
      - MAIL_ENCRYPTION=null
      - MAIL_FROM_ADDRESS=null
      - AWS_KEY_ID=
      - AWS_SECRET_ACCESS_KEY=
      - AWS_DEFAULT_REGION=us-east-1
      - AWS_BUCKET=
      - PUSHER_APP_ID=
      - PUSHER_APP_KEY=
      - PUSHER_APP_SECRET=
      - PUSHER_APP_CLUSTER=mt1
    tty: true

  db:
    image: mysql:5.7
    container_name: db
    ports:
      - 3306:3306
    volumes:
      - ./db-data:/var/lib/mysql
    restart: always
    environment:
      - MYSQL_ROOT_PASSWORD=password
</pre>

8) Once you've saved the file and are back in the command line, it's time to bring the service up. 
<pre>
docker-compose up -d
</pre>

9) Now we need to set up the database. We only need to do this once. Since we're mapping the host folder ./laratest/db-data to the database container, even if the container drops, the data will perists next time we restart it.
First we need to connect to the db container:
<pre>
    docker exec -it db bash
</pre>

10) Once we are in the container, we need to connect to mysql and create a database named laratest (assuming you kept the DB_DATABASE env variable above).
<pre>
    mysql -u root -p
</pre>

11) At the password prompt, type: password and enter (Assuming you've kept 'password' as the MYSQL password in the docker-compose.yml configuration, as provided above). You should now be connected to MYSQL. Go on to create the database, then exit from mysql.

<strong>Note: </strong> Obviously in a real world application we'd be using a more secure password.
<pre>
CREATE DATABASE laratest;
exit
</pre>

12) Exit from the db container
<pre>
exit
</pre>

13) You should now be back to the host server. Now, we need to create and populate the database tables. First, connect to the docker container hosting our application. 
<pre>
docker exec -it laratest bash
</pre>

14) You should now be in the web application container. Run the migrations and seeders. If prompted to verify that you want to run this command as app is in production, type yes.
<pre>
    php artisan migrate
    php artisan db:seed
</pre>

15) The docker setup is now ready. Now we need to setup nginx to point to our application. We'll do this by setting up a reverse proxy to direct traffic to our application to port 8081, and thus to our application. First we need to go to define a relevant nginx configuration.

<pre>
    cd /etc/nginx/sites-available/
    touch laratest.conf
    nano laratest.conf
</pre>

16) Copy the following in the laratest.conf file. <strong>Important note:</strong>In the server_name line, change to the domain that you would like to access the app from. You'll need to use a domain name thatyou have access to the DNS settings for. For example, I'm using laratest.blupath.co.uk, you may want to use laratest.intergo.co.uk. Also, in the proxy_pass line, if you've defined a host port other than 8081 to the app container, you will need to use that one.

All we are saying here is, any traffic that comes in for this specific subdomain, map to port 8081 (or whichever port you've selected). And since in the docker-compose configuration we've mapped that port to the container port, any request to this domain will reach our dockerised application.

<pre>
server {

        listen 80;
        listen [::]:80;

        server_name laratest.blupath.co.uk;
        location / {
                proxy_pass http://0.0.0.0:8081;
                proxy_set_header Accept-Encoding "";
                proxy_set_header Host $host;
                proxy_set_header X-Real-IP $remote_addr;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                proxy_set_header X-Forwarded-Proto $scheme;
        }
}
</pre>

17) Next create a symlink to this configuration from sites-available to sites-enabled

<pre>
    sudo ln -s /etc/nginx/sites-available/laratest.conf /etc/nginx/sites-enabled/laratest.conf
</pre>

18) Finally, restart the nginx server to make use of the new configurations

<pre>
    sudo service nginx restart
</pre>

19) The deployment is setup. The final step is to update your DNS settings so that the subdomain you've set up for the app points to the server. Disconnect from the server instance. Make a note of the server IP address. Then in the DNS for your domain, create a new A record to point the chosen subdomain to the IP of the server. In my case, I'm pointing laratest.blupath.co.uk to the IP of my DigitalOcean instance.

20) Navigate to the defined domain in your web browser. App should be and running.
