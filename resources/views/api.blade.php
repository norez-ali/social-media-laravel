<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #2c3e50;
        }
        input {
            padding: 8px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 8px 14px;
            margin: 5px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        pre {
            background: #f9f9f9;
            padding: 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            max-height: 300px;
            overflow-y: auto;
            font-size: 14px;
        }
    </style>
</head>
<body>
<h1>Laravel API Test with JS</h1>

<!-- Login -->
<div>
    <h3>Login</h3>
    <input type="email" id="email" placeholder="Email">
    <input type="password" id="password" placeholder="Password">
    <button onclick="login()">Login</button>
</div>

<!-- Logout -->
<div>
    <h3>Logout</h3>
    <button onclick="logout()">Logout</button>
</div>

<!-- Output -->
<h3>API Response</h3>
<pre id="output">Waiting for response...</pre>

<script>
    const API_BASE = "http://127.0.0.1:8000/api"; // API backend

    // ✅ Login
    function login() {
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;

        fetch(`${API_BASE}/login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify({ email, password })
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById("output").innerText = JSON.stringify(data, null, 2);

                if (data.token) {
                    localStorage.setItem("token", data.token); // Save token
                    // ✅ Clear input fields after login
                    document.getElementById("email").value = "";
                    document.getElementById("password").value = "";
                }
            })
            .catch(err => console.error(err));
    }

    // ✅ Logout
    function logout() {
        const token = localStorage.getItem("token");

        if (!token) {
            document.getElementById("output").innerText = "⚠️ No token found. Please login first.";
            return;
        }

        fetch(`${API_BASE}/logout`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            },
        })
            .then(res => res.json())
            .then(data => {
                document.getElementById("output").innerText = JSON.stringify(data, null, 2);
                localStorage.removeItem("token"); // Clear token
            })
            .catch(err => console.error(err));
    }
</script>
</body>
</html>
