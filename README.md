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


## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
