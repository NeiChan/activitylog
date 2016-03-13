<?php
error_reporting(0);

/**
 * Class Companies
 */

class Companies extends Controller
{
    /**
     * PAGE: index
     */
    public function index()
    {
        session_start();
        // getting all companies and amount of companies
        $companies              = $this->model->getAllCompanies($_SESSION["User"]);
        $amount_of_companies    = $this->model->getAmountOfCompanies($_SESSION["User"]);

        require APP . 'view/_templates/header.php';

       if($_SESSION["LoggedIn"] == true){
        require APP . 'view/companies/index.php';
       }else{
           echo '<h1><center>Please login into your Google account first.</center></h1>';
       }

        require APP . 'view/_templates/footer.php';
    }

    public function add()
    {
        session_start();
        if (isset($_POST["submit_add_company"])) {
            $this->model->addCompany($_POST["company"], $_SESSION["User"]);
        }
        header('location: ' . URL . 'companies/index');
    }

    public function delete($company_id)
    {
        if (isset($company_id)) {
            $this->model->deleteCompany($company_id);
        }
        header('location: ' . URL . 'companies/index');
    }

    public function edit($company_id)
    {
        if (isset($company_id)) {
            $company = $this->model->getCompany($company_id);

            require APP . 'view/_templates/header.php';
            require APP . 'view/companies/edit.php';
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL . 'companies/index');
        }
    }

    public function update()
    {
        if (isset($_POST["submit_update_company"])) {
            $this->model->updateCompany($_POST["company"], $_POST['company_id']);
        }
        header('location: ' . URL . 'companies/index');
    }
}
