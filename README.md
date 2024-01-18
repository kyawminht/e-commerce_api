<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Project API Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        pre {
            background-color: #f4f4f4;
            padding: 10px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>

<body>

    <h2>Authentication</h2>
    <p>Authentication is performed using JWT (JSON Web Token).</p>

    <h3>Register</h3>
    <pre>
        <code>
            POST /auth/register
        </code>
    </pre>
    <h4>Request</h4>
    <p>Body Parameters:</p>
    <ul>
        <li><code>name</code> (string, required): User's name.</li>
        <li><code>email</code> (string, required): User's email.</li>
        <li><code>password</code> (string, required): User's password.</li>
    </ul>
    <h4>Response</h4>
    <p>Successful registration:</p>
    <ul>
        <li>Status Code: 201</li>
        <li>Body: User details along with a JWT token.</li>
    </ul>

    <!-- Repeat similar HTML structure for other sections -->

    <h2>Brands</h2>

    <h3>List All Brands</h3>
    <pre>
        <code>
            GET /brands
        </code>
    </pre>
    <h4>Request</h4>
    <p>Headers:</p>
    <ul>
        <li><code>Authorization</code> (string, required): Bearer token with admin privileges.</li>
    </ul>
    <h4>Response</h4>
    <p>List of brands.</p>

    <!-- Repeat similar HTML structure for other sections -->

    <h2>Categories</h2>

    <!-- Repeat similar HTML structure for Categories -->

    <h2>Locations</h2>

    <!-- Repeat similar HTML structure for Locations -->

    <h2>Products</h2>

    <!-- Repeat similar HTML structure for Products -->

    <h2>Orders</h2>

    <!-- Repeat similar HTML structure for Orders -->

</body>

</html>
