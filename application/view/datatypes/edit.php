<div class="container">
    <div>
        <h3>Edit a data type</h3>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Edit data type</strong></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo URL; ?>datatypes/update" method="POST">
                    <label>Datatype</label>
                    <input autofocus type="text" name="datatype" value="<?php echo htmlspecialchars($datatype->titel, ENT_QUOTES, 'UTF-8'); ?>" required />
                    <input type="hidden" name="datatype_id" value="<?php echo htmlspecialchars($datatype->id, ENT_QUOTES, 'UTF-8'); ?>" />
                    <input type="submit" name="submit_update_datatype" value="Update" />
                </form>
            </div>
        </div>
    </div>
</div>

