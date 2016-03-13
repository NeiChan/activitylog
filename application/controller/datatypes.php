<?php
error_reporting(0);

class Datatypes extends Controller
{
    /**
     * PAGE: index
     */
    public function index()
    {
        session_start();
        // getting all companies and amount of companies
        $datatypes              = $this->model->getAllDatatypes($_SESSION["User"]);
        $amount_of_datatypes    = $this->model->getAmountOfDatatypes($_SESSION["User"]);

        require APP . 'view/_templates/header.php';

        if($_SESSION["LoggedIn"] == true){
            require APP . 'view/datatypes/index.php';
        }else{
            echo '<h1><center>Please login into your Google account first.</center></h1>';
        }

        require APP . 'view/_templates/footer.php';
    }

    public function add()
    {
        session_start();
        if (isset($_POST["submit_add_datatype"])) {
            $this->model->addDatatype($_POST["datatype"], $_SESSION["User"]);
        }
        header('location: ' . URL . 'datatypes/index');
    }

    public function delete($datatype_id)
    {
        if (isset($datatype_id)) {
            $this->model->deleteDatatype($datatype_id);
        }
        header('location: ' . URL . 'datatypes/index');
    }

    public function edit($datatype_id)
    {
        if (isset($datatype_id)) {
            $datatype = $this->model->getDatatype($datatype_id);

            require APP . 'view/_templates/header.php';
            require APP . 'view/datatypes/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL . 'datatypes/index');
        }
    }

    public function update()
    {
        if (isset($_POST["submit_update_datatype"])) {
            $this->model->updateDatatype($_POST["datatype"], $_POST['datatype_id']);
        }
        header('location: ' . URL . 'datatypes/index');
    }
}
