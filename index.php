<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            text-align: center;
        }
        div {
            width: 80%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div>
        <canvas id="myChart"></canvas>
    </div>
    <?php
        $conn = new mysqli("localhost", "root", "", "termometr");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $query = "SELECT data,temperatura,wilgotnosc FROM rekordy";
        $result = $conn->query($query);
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $conn->close();
        $json = json_encode($data);
    ?>
    <script>
        var data = <?php echo $json; ?>;
        
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(function(e) {
                    return e.data;
                }),
                datasets: [{
                    label: 'Temperatura °C',
                    data: data.map(function(e) {
                        return e.temperatura;
                    }),
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Wilgotnosc %',
                    data: data.map(function(e) {
                        return e.wilgotnosc;
                    }),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
