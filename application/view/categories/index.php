<div class="container">
    <h3>Categories</h3>
    <div class="box">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Add all the categories.</strong></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo URL; ?>categories/add" method="POST">
                    <input type="text" name="category" value="" required />
                    <input type="submit" name="submit_add_category" value="Submit" />
                </form>
            </div>
        </div>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of categories</h3>
        <div>
            <h1><?php echo $amount_of_categories; ?></h1>
        </div>

        <h3>List of categories</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Category</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($categories as $category) { ?>
                <tr>
                    <td><?php if (isset($category->id)) echo htmlspecialchars($category->titel, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'categories/delete/' . htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'categories/edit/' . htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
