<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="alert alert-info text-center mt-2">Application Dashboard</div>

    <table class="table table-bordered">
        <tr>
            <td>Sent Request</td>
            <td>Successfully Request</td>
            <td>Failed Request</td>
        </tr>

        <tr>
            <td id="all_request" class="text-center text-dark fw-bold">0</td>
            <td id="successfully_request" class="text-center text-success fw-bold">0</td>
            <td id="failed_request" class="text-center text-danger fw-bold">0</td>
        </tr>
    </table>
</div>


<script src="/js/bootsrap.min.js"></script>
<script src="/js/axios.min.js"></script>
<script src="/js/jquery.js"></script>
<script src="/js/app.js"></script>
</body>
</html>