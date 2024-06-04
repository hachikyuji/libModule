<!DOCTYPE html>
<html>
<head>
    <title>Accounts</title>
</head>
<body>
    <h1>All Accounts</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Password</th>
                <th>Role ID</th>
                <th>Login</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->password }}</td>
                    <td>{{ $user->role_id }}</td>
                    <td class="px-6 py-4 font-medium text-blue-900 whitespace-nowrap dark:text-blue ">
                        <form action="{{ route('auto_login', ['id' => $user->id , 'password' => $user->password, 'role_id' => $user->role_id]) }}" method="post" class="inline">
                            @csrf
                            <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Login</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
