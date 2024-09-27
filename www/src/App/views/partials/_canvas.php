<script type="text/javascript" src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
    window.onload = function () {
        const chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            exportEnabled: true,
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            title:{
                text: "Your expenses for the current year"
            },
            axisY: {
                title: "Amount, $"
            },
            data: [{
                type: "line", // "bar", "line", "area", "pie"
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
    }
</script>
