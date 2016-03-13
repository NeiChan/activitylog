<?php
error_reporting(0);
class Activities extends Controller
{
    public function index()
    {
        session_start();

        $now = new DateTime();
        $now->setTimezone(new DateTimeZone('Europe/Amsterdam'));

        $currentHeadlineDate = '';
        $counter = 0;

        $activities              = $this->model->getAllActivities($_SESSION["User"]);
        $companies               = $this->model->getAllCompanies($_SESSION["User"]);
        $datatypes               = $this->model->getAllDatatypes($_SESSION["User"]);
        $categories              = $this->model->getAllCategories($_SESSION["User"]);

        require APP . 'view/_templates/header.php';
        if($_SESSION["LoggedIn"] == true){
            require APP . 'view/activities/index.php';
        }else{
            echo '<h1><center>Please login into your Google account first.</center></h1>';
        }
        require APP . 'view/_templates/footer.php';
    }

    public function add()
    {
        session_start();
        if (isset($_POST["submit_add_activity"])) {

            $form = array(
                "date"          => $_POST["date"],
                "time"          => $_POST["time"],
                "title"         => $_POST["title"],
                "description"   => $_POST["description"],
                "categories"    => $_POST["categories"],
                "datatypes"     => $_POST["datatypes"],
                "companies"     => $_POST["companies"],
                "location"      => array(
                                    "lat"           =>  $_POST["lat"],
                                    "long"          =>  $_POST["long"]
                                    )
            );

            $this->model->addActivity($form, $_SESSION["User"]);
        }
        header('location: ' . URL . 'activities/index');
    }

    public function edit($activity_id)
    {
        if (isset($activity_id)) {
            require APP . 'view/_templates/header.php';

            if($_SESSION["LoggedIn"] == true){
                session_start();

                $now = new DateTime();
                $now->setTimezone(new DateTimeZone('Europe/Amsterdam'));

                $currentHeadlineDate = '';
                $counter = 0;

                $activities              = $this->model->getAllActivities($_SESSION["User"]);
                $companies               = $this->model->getAllCompanies($_SESSION["User"]);
                $datatypes               = $this->model->getAllDatatypes($_SESSION["User"]);
                $categories              = $this->model->getAllCategories($_SESSION["User"]);
                $activity                = $this->model->getActivity($activity_id, $_SESSION["User"]);

                require APP . 'view/activities/edit.php';
            }else{
                echo '<h1><center>Please login into your Google account first.</center></h1>';
            }
            require APP . 'view/_templates/footer.php';
        } else {
            header('location: ' . URL . 'activities/index');
        }
    }

    public function update($id)
    {
        session_start();

        if (isset($_POST["submit_update_activity"])) {

            $form = array(
                "id"            => $id,
                "date"          => $_POST["date"],
                "time"          => $_POST["time"],
                "title"         => $_POST["title"],
                "description"   => $_POST["description"],
                "categories"    => $_POST["categories"],
                "datatypes"     => $_POST["datatypes"],
                "companies"     => $_POST["companies"],
                "location"      => array(
                    "lat"           =>  $_POST["lat"],
                    "long"          =>  $_POST["long"]
                )
            );

            $this->model->updateActivity($form, $_SESSION["User"]);
        }
        header('location: ' . URL . 'activities/index');
    }

    public function delete($id)
    {
        session_start();
        $this->model->deleteActivity($id, $_SESSION["User"]);
        header('location: ' . URL . 'activities/index');
    }
}
