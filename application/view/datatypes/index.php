<div class="container">
    <h2>Add all the Data Types (What personal information do they receive from you?) that you need.</h2>
    <div class="box">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Add a datatype.</strong></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo URL; ?>datatypes/add" method="POST">
                    <input type="text" name="datatype" value="" required />
                    <input type="submit" name="submit_add_datatype" value="Submit" />
                </form>
            </div>
        </div>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of datatypes</h3>
        <div>
            <h1><?php echo $amount_of_datatypes; ?></h1>
        </div>

        <h3>List of datatypes</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Data type</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($datatypes as $datatype) { ?>
                <tr>
                    <td><?php if (isset($datatype->id)) echo htmlspecialchars($datatype->titel, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'datatypes/delete/' . htmlspecialchars($datatype->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'datatypes/edit/' . htmlspecialchars($datatype->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
