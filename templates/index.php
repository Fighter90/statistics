<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="templates/js/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="templates/js/jqplot.json2.js"></script>
    <link rel="stylesheet" type="text/css" href="templates/css/jquery.jqplot.min.css"/>
    <script type="text/javascript">
        <?php
        $dataArray = array();

        if(!empty($dataRegistered) && !empty($dataAll)){
            foreach($dataRegistered as $period => $count){
                $conversion = ($count/$dataAll[$period])*100;
                $dataArray[] = "[$period, $conversion]";
            }
        }
        if($dataArray){
            $dataForChart = "[[".implode(", ", $dataArray)."]]";
        ?>
        $(document).ready(function () {
            var data = <?=$dataForChart?>;
            var plot1 = $.jqplot('chart1', data, {
                title: 'Конверсия по периодам',
                axesDefaults: {min: 0},
                seriesDefaults: {showMarker: true},
                axes: {
                    xaxis: {renderer: $.jqplot.LogAxisRenderer, label: 'Номер периода'},
                    yaxis: {renderer: $.jqplot.LogAxisRenderer, label: 'Конверсия (%)'}
                },
            });
        });
        <?php
            }else{
            ?>
                $(document).ready(function () {
                    $('#chart1').text('Нет данных для построения графика').height(20);
                });
        <?php
            }
         ?>
    </script>
</head>
<body>
<div id="chart1" style="height:600px; width:800px;"></div>
<br/>

<form action="" method="POST">
    Количество дней в периоде: <input type="text" name="days" value="<?= $days ?>"/><br/><br/>
    <input type="submit" value="Перестроить график"/>
</form>
</body>
</html>