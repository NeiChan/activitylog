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

    public function importExcel()
    {
        session_start();

        /** PHPExcel_IOFactory */
        //include 'PHPExcel/IOFactory.php';
        include 'PHPExcel.php';
        //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

        if (isset($_POST["import_excel_file"])) {
            $userid = $_SESSION["User"];
            $inputFileName = $_FILES["file"]["tmp_name"];
            $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);

            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            /**
             * A = Date
             * B = Time
             * C = Title
             * D = Description
             * E = Category
             * F = Data Types
             * G = Companies
             * H = Location
             */

            $form_list = array();
            $datatypes_list = array();
            $companies_list = array();

            foreach ($sheetData as $index => $data) {
                if ($index == 1):
                    continue;
                else:
                    // Find Location Coordinates (Latitude, Longitude)
                    $address = urlencode($data["H"] . ' Nederland');
                    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . $address . '&sensor=false');
                    $output = json_decode($geocode);

                    $lat = $output->results[0]->geometry->location->lat;
                    $long = $output->results[0]->geometry->location->lng;

                    $date = explode('/', $data["A"]);
                    $newDate = $date[2] . '-' . sprintf("%02d", $date[0]) . '-' . $date[1];

                    $form = array(
                        "date" => $newDate,
                        "time" => $data["B"],
                        "title" => $data["C"],
                        "description" => $data["D"],
                        "categories" => $data["E"],
                        "datatypes" => "",
                        "companies" => "",
                        "location" => array(
                            "lat" => $lat,
                            "long" => $long
                        )
                    );

                    $datatypes = array_map("trim", explode(",", $data["F"]));
                    $form["datatypes"] = $datatypes;

                    $companies = array_map("trim", explode(",", $data["G"]));
                    $form["companies"] = $companies;

                    array_push($form_list, $form);

                    // Put all the datatypes in a new list.
                    foreach ($datatypes as $data) {
                        if (!in_array(strtolower(trim($data)), array_map('strtolower', $datatypes_list), true)) {
                            array_push($datatypes_list, trim($data));
                        }
                    }

                    // Put all the companies in a new list.
                    foreach ($companies as $company) {
                        if (!in_array(strtolower(trim($company)), array_map('strtolower', $companies_list), true)) {
                            array_push($companies_list, trim($company));
                        }
                    }
                endif;
            }

            // Create datatypes
            foreach ($datatypes_list as $data) {
                if ($this->model->getDatatypeByTitel($data, $userid)) {
                } else {
                    $this->model->addDatatype($data, $userid);
                }
            }

            // Create companies
            foreach ($companies_list as $company) {
                if ($this->model->getCompanyByTitel($company, $userid)) {
                } else {
                    $this->model->addCompany($company, $userid);
                }
            }


            // Create the activities
            foreach ($form_list as $form) {
                // Insert and find category
                $getCategory = $this->model->getCategoryByTitel($form["categories"], $userid);
                if ($getCategory) {
                    $form["categories"] = $getCategory->id;
                } else {
                    // Since it doens't exist, insert the category.
                    $this->model->addCategory($form["categories"], $userid);

                    // Loop through and find the category by title again.
                    $getCategoryID = $this->model->getCategoryByTitel($form["categories"], $userid);
                    $form["categories"] = $getCategoryID->id;
                }

                $form_datatypes = $form["datatypes"];
                for ($i = 0; $i < count($form_datatypes); $i++) {
                    $getDatatypes = $this->model->getDatatypeByTitel($form_datatypes[$i], $userid);
                    if ($getDatatypes) {
                        $form["datatypes"][$i] = $getDatatypes->id;
                    }
                }

                $form_companies = $form["companies"];
                for ($i = 0; $i < count($form_companies); $i++) {
                    $getCompanies = $this->model->getCompanyByTitel($form_companies[$i], $userid);
                    if ($getCompanies) {
                        $form["companies"][$i] = $getCompanies->id;
                    }
                }

                $this->model->addActivity($form, $userid);
                header('location: ' . URL . 'home/index');
            }
        }
    }

    public function exportExcel()
    {
        session_start();
        $userid = $_SESSION["User"];
        $user = $this->model->getUserByID($userid);
        $email = $user->email;
        /** PHPExcel_IOFactory */
        include 'PHPExcel.php';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator($email)
            ->setLastModifiedBy($email)
            ->setTitle("MEC Tracking Log of ".$email."")
            ->setSubject("MEC Tracking Log of ".$email."")
            ->setDescription("MEC Tracking Log of ".$email."");

        $all_activities = $this->model->getAllActivities($userid);

        // Add Titles
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'date (dd/mm/yy)')
            ->setCellValue('B1', 'time')
            ->setCellValue('C1', 'title')
            ->setCellValue('D1', 'description')
            ->setCellValue('E1', 'category')
            ->setCellValue('F1', 'datatypes')
            ->setCellValue('G1', 'companies')
            ->setCellValue('H1', 'location');

        /** Loop through all the activities and put it in the cells */
            $count = 2;
            foreach($all_activities as $activity)
            {
                $date_explode = explode('-',$activity->l_date);
                $date = $date_explode[2].'-'.$date_explode[1].'-'.$date_explode[0];
                $time = $activity->l_time;
                $title = $activity->titel;
                $description = $activity->description;
                $category = $this->model->getCategory($activity->category_id);

                // Add some data
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow('0', $count, $date)
                    ->setCellValueByColumnAndRow('1', $count, $time)
                    ->setCellValueByColumnAndRow('2', $count, $title)
                    ->setCellValueByColumnAndRow('3', $count, $description)
                    ->setCellValueByColumnAndRow('4', $count, $category->titel);

                // Get the addresses from the latitude and longitude
                $latitude = $activity->l_lat;
                $longitude = $activity->l_long;
                $geolocation = $latitude.','.$longitude;

                $request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&key=AIzaSyBdImcQ9RZXL2a2tILaW95pKYusoMWK6-M';
                $file_contents = file_get_contents($request);
                $json_decode = json_decode($file_contents);
                /****************************************************************/
                $activity_id = $activity->id;

                // Get all activity data types
                $datatypes = $this->model->getActivityDataTypes($activity_id, $userid);
                $datatypes_output = '';
                foreach($datatypes as $datatype){
                    $datatypes_output .= $datatype->titel . ', ';
                }

                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('5', $count, $datatypes_output);
                /****************************************************************/

                // Get all activity companies
                $companies = $this->model->getActivityCompanies($activity_id, $userid);
                $companies_output = '';
                foreach($companies as $company){
                    $companies_output .= $company->titel . ', ';
                }

                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('6', $count, $companies_output);
                /****************************************************************/

                $converted_address = $json_decode->results[0]->formatted_address;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow('7', $count, $converted_address);
                $count++;
            }
        /** End Foreach */

        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="MEC_Tracking_Log_By_'.$email.'.xlsx"');
        header('Cache-Control: max-age=0');

        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
        header('location: ' . URL . 'home/index');
    }
}
