<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        /* Sidebar styles (as provided in the previous response) */
        .sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        .sidebar a {
            padding: 16px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #ffc107;
        }
        /* Topbar styles */
        .topbar {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            margin-left : 350px;
        }

        .topbar a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>

<div class="topbar">
<a href="{{ route('admin.logout') }}">Logout</a>
</div>

<div class="sidebar">
    <a href="#drivers">Drivers</a>
    <a href="#teams">Teams</a>
</div>

<div style="margin-left: 250px; padding: 70px 20px 20px 20px;">\
    <h2>Welcome to the Admin Dashboard</h2>
</div>

</body>
</html>
