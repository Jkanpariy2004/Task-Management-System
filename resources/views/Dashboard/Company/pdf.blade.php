<!-- resources/views/pdf/export.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Exported Data</h2>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->c_name }}</td>
                    <td>{{ $item->c_email }}</td>
                    <td>{{ $item->c_phone_no }}</td>
                    <td>{{ $item->c_address }}</td>
                    <td>{{ $item->city }}</td>
                    <td>{{ $item->country }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
