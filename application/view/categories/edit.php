<div class="container">
    <div>
        <h3>Edit a category</h3>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Edit category.</strong></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo URL; ?>categories/update" method="POST">
                    <label>Category</label>
                    <input autofocus type="text" name="category" value="<?php echo htmlspecialchars($category->titel, ENT_QUOTES, 'UTF-8'); ?>" required />
                    <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>" />
                    <input type="submit" name="submit_update_category" value="Update" />
                </form>
            </div>
        </div>
    </div>
</div>

