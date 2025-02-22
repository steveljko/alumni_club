### About
The goal of the *Alumni Club* project is to establish a platform that enables alumni to connect and maintain relationships with one another. This platform is designed to cultivate a sense of community among graduates, facilitate networking opportunities, and offer resources for ongoing personal and professional development. This initiative is part of my university's commitment to fostering connections among students even after they have completed their studies.

### Project Overview

#### 1. Authentication
This project is designed with security in mind, ensuring that only authorized individuals can register new users. Due to specific requirements, administrators are responsible for creating new user accounts. An initial password is generated and sent via email. Upon first login, users are prompted to reset their one-time password (initial password).

#### 2. Authorization & Roles
The system defines three distinct account types, each tailored to specific roles within the organization:
- **Administrators**: Have full access to all features, manage user accounts, configure settings, and oversee operations through a comprehensive dashboard.
- **Alumni**: Can connect, share content, and collaborate with others on the platform.

#### 3. Share Previous Work History
This feature allows users to showcase their professional backgrounds and experiences within the platform. Users can create detailed profiles that include previous job titles, companies worked for, duration of employment, and key responsibilities or achievements in each role.

#### 4. Post and share upcoming events and recently available jobs
There are three types of posts, each serving a unique purpose within the platform:
1. **Default**: General posts that users can create to share updates, thoughts, or information with the community.
2. **Event**: Specifically designed to promote and organize events within the community. Users can create event posts that include details such as the event title, date, time, location, and a description.
3. **Job**: Intended for sharing job opportunities within the organization or community. Users can create job posts that detail the job title, description, and deadlines. This feature allows alumni and other members to stay informed about job openings and connect with potential employers.

### How to Run?

#### 1. Install Dependencies
First, install the required dependencies and copy the environment file:
```
composer install
cp .env.example .env
```

#### 2. Configure Mailtrap
To set up email functionality, register for a Mailtrap account and update your .env file with the following configuration:
```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<your_mailtrap_inbox_username>
MAIL_PASSWORD=<your_mailtrap_inbox_password>
MAIL_ENCRYPTION=tls
```

#### 3. Run Application
Start the application using Sail:
```
./vendor/bin/sail up --build
```

#### 4. Migrate and seed database
After the application has successfully built and is running, migrate and seed the database, and run Vite:
```
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail artisan storage:link
./vendor/bin/sail npm run dev
```

#### Additional Notes
1. Ensure that Docker is installed and running on your machine, as Sail relies on Docker.
