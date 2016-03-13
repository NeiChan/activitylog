<script type="text/javascript">

    /*
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.charts.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
            ['Mushrooms', 3],
            ['Onions', 1],
            ['Olives', 1],
            ['Zucchini', 1],
            ['Pepperoni', 2]
        ]);

        // Set chart options
        var options = {'title':'How Much Pizza I Ate Last Night',
            'width':400,
            'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    */
</script>

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Excel importer</strong></div>
                <div class="panel-body">
                    <p><strong>Use this only when your account is clean!</strong></p>
                    <p>To make the process faster, you can use the importer. The system will fix the rest for you :)</p>
                    <p>Download the sample and put your data in it : <a href="<?php echo $url; ?>/example/sample.xlsx">Download here</a></p>
                    <form name="import" action="<?php echo URL; ?>home/importExcel" method="post" enctype="multipart/form-data">
                        <fieldset class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <input name="file" type="file" class="form-control-file" id="exampleInputFile">
                            <small class="text-muted">Import the excel file here and press on submit.</small>
                        </fieldset>
                        <input type="submit" name="import_excel_file" value="Submit" />
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><strong>Data exporter</strong></div>
                <div class="panel-body">
                    Work in progress..
<!--                    <p>Do you want all your data? Click on the button to generate it.</p>-->
<!--                    <form name="export" action="--><?php //echo URL; ?><!--home/exportExcel" method="post">-->
<!--                        <input type="submit" name="submit" value="Export data" />-->
<!--                    </form>-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail">
                <img class="img-rounded" src="http://loremflickr.com/320/240/cat">
                <div class="caption text-center">
                    <h3>Activities</h3>
                    <h4 style="font-size: 2em; "><?php echo $amount_of_activities; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail">
                <img class="img-rounded" src="http://loremflickr.com/320/240/cute">
                <div class="caption text-center">
                    <h3>Categories</h3>
                    <h4 style="font-size: 2em; "><?php echo $amount_of_categories; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail">
                <img class="img-rounded" src="http://loremflickr.com/320/240/dog">
                <div class="caption text-center">
                    <h3>Data Types</h3>
                    <h4 style="font-size: 2em; "><?php echo $amount_of_datatypes; ?></h4>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="thumbnail">
                <img class="img-rounded" src="http://loremflickr.com/320/240/apple">
                <div class="caption text-center">
                    <h3>Companies</h3>
                    <h4 style="font-size: 2em; "><?php echo $amount_of_companies; ?></h4>
                </div>
            </div>
        </div>
    </div>
    <h4>Please be patient.... Charts are coming soon!</h4>
    <div id="chart_div"></div>
</div>