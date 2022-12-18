<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Statistics</title>
</head>
    <body>
    <div style="display: flex">
        <div style="margin-right: 50px">
            <table>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Count</th>
                    <th>Revenue</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['invoices'] as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['price'] }}</td>
                        <td>{{ $item['count'] }}</td>
                        <td>{{ $item['revenue'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <table>
                <thead>
                <tr>
                    <th>Пакеты</th>
                    <th>Per Price</th>
                    <th>Price</th>
                    <th>Count</th>
                    <th>Profit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['gifts'] as $gift)
                    <tr>
                        <td>{{ $gift['gift']['name']['ru'] }}</td>
                        <td>{{ $gift['per_price'] }} сум</td>
                        <td>{{ $gift['gift']['price'] }} сум</td>
                        <td>{{ $gift['count'] }}</td>
                        <td>{{ $gift['profit'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </body>
</html>
