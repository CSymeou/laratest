## Laravel Test Application

This mini application was prepared as a test for Intergo.

Key points:
- I used bootstrap 4 as the css library through laravel/ui. [See here](https://www.techiediaries.com/laravel/how-to-install-bootstrap-in-laravel-6-7-by-example/).
- I scaffolded Authorization and Authorization pages using the laravel/ui bootstrap 4 auth scaffolding. [See here](https://www.techiediaries.com/laravel/how-to-install-bootstrap-in-laravel-6-7-by-example/).
- As I used the default auth scaffolding, there's actually also pages for Registration, Forgot Password, etc, although I'm not linking to any of those pages. I also have not produced any tests for the auth behavior.
- For icons I used the heroicons set. [See here](https://github.com/blade-ui-kit/blade-heroicons/).
- As the application was designed as an exercise and there were no requirements for multilingual versions, I hardcoded strings into the various views and components, and did not use language strings. In a real application I would typically always use language strings to prepare for potential future localisations.
- In the past I've used the Laravel Permissions package ([See here](https://spatie.be/docs/laravel-permission/v3/introduction)), to store roles and permissions in the database, and associate them with users. For this example I kept things simple, and am just defining $user->role as a field in the users table, and permissions as Gates in AuthServiceProvider.

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

I've made a remote deployment at  [http://laratest.blupath.co.uk](https://www.techiediaries.com/laravel/how-to-install-bootstrap-in-laravel-6-7-by-example/).

You can clone this repository on your own local dev environment to test the app out. You will need to set up an .env file to define your database connection. You can download my example .env from here. 

You can also get the application as a docker image from christossymeou/laratest. You can find a docker-compose.yml file from here.

Further down this document I have also set instructions for deployment on an nginx server with Docker.

## Domain Model

You can find a simple visual representation of the Domain Model here.

I used 3 Models:

- User: 
  - Represents a user in the application. 
  - Has a role property that determines the user role. The roles available are admin / leader / user
  - Can belong to a team. Team user belongs to determined by team_id value. Nullable: User can belong to no team.
  - Can be a leader of a teamn. Determined by leader_id value on Team object.
  - Relationships:
    - One to Many: with Task
    - One to One: with Team (for team leader)
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
    - One to One: with User (for team leader)
    - One to Many: with User (for team member)

## Database

You can find a simple visual representation of the database structure here.

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

