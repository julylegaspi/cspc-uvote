<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users</title>

    <style>
        table.customTable {
            width: 100%;
            background-color: #FFFFFF;
            border-collapse: collapse;
            border-width: 2px;
            border-color: #A6A6A6;
            border-style: solid;
            color: #4F4F4F;
        }

        table.customTable td,
        table.customTable th {
            border-width: 2px;
            border-color: #A6A6A6;
            border-style: solid;
            padding: 5px;
        }

        table.customTable thead {
            background-color: #FFFFFF;
        }
    </style>
</head>

<body>
    <table class="customTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ Crypt::decryptString($user->encrypted_password) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
