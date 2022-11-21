<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        th,
        td,
        textarea {
            padding: 10px 20px;
            font-size: 20px;
            border: 1px solid #ddd;
        }
        td{
            max-width: 410px;
        }

        .container {
            text-align: center;
        }

        table{
            margin: auto;
            border-collapse: collapse;
        }

        textarea{
            width: 350px;
            height: 550px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="text-align: center">Bạn có một thư cần hỗ trợ từ người dùng</h2>
        <table>
            <tr>
                <th>Email khách hàng</th>
                <td>{{ $supports['email'] }}</td>
            </tr>
            <tr>
                <th>Nội dung hỗ trợ</th>
                <td><textarea readonly>{{ $supports['msg'] }}</textarea></td>
            </tr>
        </table>        
    </div>

</body>

</html>
