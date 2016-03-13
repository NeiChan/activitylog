<?php
error_reporting(0);

class Home extends Controller
{
    public function index()
    {
        session_start();

        $amount_of_activities   = $this->model->getAmountOfActivities($_SESSION["User"]);
        $amount_of_categories   = $this->model->getAmountOfCategories($_SESSION["User"]);
        $amount_of_datatypes    = $this->model->getAmountOfDatatypes($_SESSION["User"]);
        $amount_of_companies    = $this->model->getAmountOfCompanies($_SESSION["User"]);

        //load categories and results with activities


        // load views
        require APP . 'view/_templates/header.php';
        if($_SESSION["LoggedIn"] == true){
            require APP . 'view/home/index.php';
        }else{
            echo '<h1><center>Please login into your Google account first.</center></h1>';
        }
        require APP . 'view/_templates/footer.php';
    }
}
