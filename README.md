Your Project API Documentation

Authentication is performed using JWT (JSON Web Token).

## Register
```http
POST /auth/register
Request

Body Parameters:
name (string, required): User's name.
email (string, required): User's email.
password (string, required): User's password.
Response

Successful registration:
Status Code: 201
Body: User details along with a JWT token.
<!-- Repeat similar HTML structure for other sections -->
Brands
List All Brands
http
Copy code
GET /brands
Request

Headers:
Authorization (string, required): Bearer token with admin privileges.
Response

List of brands.

Categories

Locations
List All Locations
http
Copy code
GET /locations
Request

Headers:
Authorization (string, required): Bearer token.
Response

List of locations.

Products

Orders
