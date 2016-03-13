<div class="container">
    <h2>Add all the companies that tracks your activity.</h2>
    <div class="box">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Add a Company</strong></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo URL; ?>companies/add" method="POST">
                    <input type="text" name="company" value="" required />
                    <input type="submit" name="submit_add_company" value="Submit" />
                </form>
            </div>
        </div>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of companies</h3>
        <div>
            <h1><?php echo $amount_of_companies; ?></h1>
        </div>

        <h3>List of companies</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Company</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($companies as $company) { ?>
                <tr>
                    <td><?php if (isset($company->id)) echo htmlspecialchars($company->titel, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'companies/delete/' . htmlspecialchars($company->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'companies/edit/' . htmlspecialchars($company->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
