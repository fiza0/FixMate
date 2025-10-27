## 1. `users` Table
Stores user accounts for both homeowners and handymen.

| Column         | Type                                     | Description |
|----------------|------------------------------------------|-------------|
| id             | BIGINT (Primary Key, Auto Increment)      | Unique user identifier |
| name           | VARCHAR(255)                              | Full name |
| email          | VARCHAR(255), Unique                      | Login email |
| phone          | VARCHAR(50)                               | Contact number |
| password       | VARCHAR(255)                              | Hashed password |
| role           | ENUM(`homeowner`, `handyman`, `admin`)     | Defines user type |
| profile_photo  | VARCHAR(255), Nullable                     | Profile picture URL |
| verified       | BOOLEAN, Default: false                    | Only applies to handymen (verification status) |
| created_at     | TIMESTAMP                                 | |
| updated_at     | TIMESTAMP                                 | |

**Relationships**
- A `handyman` user may have one profile entry in `handyman_profiles`.

---

## 2. `handyman_profiles` Table
Stores additional details specific to handymen.

| Column          | Type                                      | Description |
|-----------------|-------------------------------------------|-------------|
| id              | BIGINT (Primary Key, Auto Increment)       | |
| user_id         | BIGINT (Foreign Key → users.id)            | References the handyman user |
| skill_category  | ENUM(`plumber`, `electrician`, `carpenter`, `mechanic`, `painter`, `general`) | Type of work offered |
| bio             | TEXT, Nullable                             | Brief description of skills |
| min_rate        | DECIMAL(8,2)                               | Starting price or hourly rate |
| max_rate        | DECIMAL(8,2), Nullable                     | Maximum estimated rate |
| average_rating  | DECIMAL(3,2), Default: 0.00                | Updated from reviews |
| location        | VARCHAR(255)                               | City / estate |
| created_at      | TIMESTAMP                                  | |
| updated_at      | TIMESTAMP                                  | |

**Relationships**
- Handyman profile **belongs to** one `user`.

---

## 3. `bookings` Table
Represents scheduled service requests.

| Column        | Type                                                       | Description |
|---------------|------------------------------------------------------------|-------------|
| id            | BIGINT (Primary Key, Auto Increment)                       | |
| homeowner_id  | BIGINT (Foreign Key → users.id)                            | User who requested service |
| handyman_id   | BIGINT (Foreign Key → users.id)                            | Assigned handyman |
| service_type  | VARCHAR(255)                                               | Type of job requested |
| description   | TEXT                                                       | Job details |
| scheduled_at  | DATETIME                                                   | Appointment time |
| status        | ENUM(`requested`, `accepted`, `in_progress`, `completed`, `cancelled`) | Booking workflow status |
| estimated_cost | DECIMAL(8,2), Nullable                                    | Quoted price before job |
| final_cost    | DECIMAL(8,2), Nullable                                     | Actual final cost (if discussed offline) |
| created_at    | TIMESTAMP                                                  | |
| updated_at    | TIMESTAMP                                                  | |

**Relationships**
- A booking **belongs to** a homeowner and a handyman.
- A booking **may have** one review.

---

## 4. `reviews` Table
Stores feedback from homeowners after work is completed.

| Column      | Type                                      | Description |
|-------------|-------------------------------------------|-------------|
| id          | BIGINT (Primary Key, Auto Increment)       | |
| booking_id  | BIGINT (Foreign Key → bookings.id)         | Ensures review is linked to an actual job |
| reviewer_id | BIGINT (Foreign Key → users.id)            | Usually the homeowner |
| rating      | INT (1–5)                                  | Star rating |
| comment     | TEXT, Nullable                             | Optional written feedback |
| created_at  | TIMESTAMP                                  | |

**Relationships**
- A review **belongs to** a booking.

---
