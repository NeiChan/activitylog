<?php
error_reporting(0);

class Categories extends Controller
{
    /**
     * PAGE: index
     */
    public function index()
    {
        session_start();
        // getting all companies and amount of companies
        $categories              = $this->model->getAllCategories($_SESSION["User"]);
        $amount_of_categories    = $this->model->getAmountOfCategories($_SESSION["User"]);

        require APP . 'view/_templates/header.php';

        if($_SESSION["LoggedIn"] == true){
            require APP . 'view/categories/index.php';
        }else{
            echo '<h1><center>Please login into your Google account first.</center></h1>';
        }

        require APP . 'view/_templates/footer.php';
    }

    public function add()
    {
        session_start();
        if (isset($_POST["submit_add_category"])) {
            $this->model->addCategory($_POST["category"], $_SESSION["User"]);
        }
        header('location: ' . URL . 'categories/index');
    }

    public function delete($category_id)
    {
        if (isset($category_id)) {
            $this->model->deleteCategory($category_id);
        }
        header('location: ' . URL . 'categories/index');
    }

    public function edit($category_id)
    {
        if (isset($category_id)) {
            $category = $this->model->getCategory($category_id);

            require APP . 'view/_templates/header.php';
            require APP . 'view/categories/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL . 'categories/index');
        }
    }

    public function update()
    {
        if (isset($_POST["submit_update_category"])) {
            $this->model->updateCategory($_POST["category"], $_POST['category_id']);
        }
        header('location: ' . URL . 'categories/index');
    }
}
