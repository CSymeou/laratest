## Laravel Test Application

This mini application was prepared as a test for Intergo.

Key points:
- I used bootstrap 4 as the css library through laravel/ui. [See here](https://www.techiediaries.com/laravel/how-to-install-bootstrap-in-laravel-6-7-by-example/).
- I also scaffolded Authorization and Authorization pages using the default auth scaffolding. [See here](https://www.techiediaries.com/laravel/how-to-install-bootstrap-in-laravel-6-7-by-example/).
- As I used the default auth scaffolding, there's actually also pages for Registration, Forgot Password, etc, although I'm not linking to any of those pages. I also have not produced any tests for the auth behavior.
- For icons I used the heroicons set. [See here](https://github.com/blade-ui-kit/blade-heroicons/).
- As the application was designed as an exercise and there were no requirements for multilingual versions, I hardcoded strings into the various views and components, and did not use language strings. In a real application I would typically always use language strings to prepare for potential future localisations.
- In the past I've used the Laravel Permissions package ([See here](https://spatie.be/docs/laravel-permission/v3/introduction)), to store roles and permissions in the database, and assocaite them with users. For this example I kept things simples, and am just defining $user->role as a field in the users table, and permissions as Gates in AuthServiceProvider.

## Domain Model

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

