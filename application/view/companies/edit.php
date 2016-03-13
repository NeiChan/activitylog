<div class="container">
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Edit a Company</strong></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo URL; ?>companies/update" method="POST">
                    <label>Company</label>
                    <input autofocus type="text" name="company" value="<?php echo htmlspecialchars($company->titel, ENT_QUOTES, 'UTF-8'); ?>" required />
                    <input type="hidden" name="company_id" value="<?php echo htmlspecialchars($company->id, ENT_QUOTES, 'UTF-8'); ?>" />
                    <input type="submit" name="submit_update_company" value="Update" />
                </form>
            </div>
        </div>

    </div>
</div>

