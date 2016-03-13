<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    /**
     * @EXCEL IMPORTER/EXPORT
     */



    /**
     * @USER
     */


    public function getUserID($email)
    {
        $sql = "SELECT id FROM log_users WHERE email = :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email);

        $query->execute($parameters);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getUser($email)
    {
        $sql = "SELECT id, email FROM log_users WHERE email = :email LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function insertUser($email, $created_at)
    {
        $sql = "INSERT INTO log_users (email, createdAt) VALUES (:email, :createdAt)";
        $query = $this->db->prepare($sql);
        $parameters = array(':email' => $email, ':createdAt' => $created_at);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }


    /**
     * @ACTIVITIES
     */

    public function getAllActivities($userid)
    {
        $sql = "SELECT * FROM log_locations WHERE user_id = :userid ORDER BY l_date DESC, l_time DESC";
        $query = $this->db->prepare($sql);
        $parameters = array(':userid' => $userid);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getActivity($activity_id, $userid)
    {
        $id = $activity_id;
        $user = $userid;
        $save_data = array();

        $save_data["main"]      = $this->getActivityItem($id, $user);
        $save_data["datatypes"] = $this->getActivityDataTypes($id, $user);
        $save_data["companies"] = $this->getActivityCompanies($id, $user);
        return $save_data;
    }

    public function getActivityItem($activity_id, $userid)
    {
        $sql = "SELECT id, titel, description, l_date, l_time, l_lat, l_long, category_id
                FROM log_locations
                WHERE id = :activityid AND user_id = :userid LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':activityid' => $activity_id, ':userid' => $userid);
        $query->execute($parameters);

        return $query->fetch();
    }

    public function getActivityDataTypes($locationid, $userid)
    {
        $location_id = $locationid;
        $user = $userid;

        $datatypes = $this->getActivityDataTypesID($location_id, $user);

        $save_data = array();
        $length = count($datatypes);

        for ($i = 0; $i < $length; $i++) {
            $save_data[] = $this->getDatatype($datatypes[$i]->datatype_id);
        }

        return $save_data;
    }

    public function getActivityCompanies($locationid, $userid)
    {
        $location_id = $locationid;
        $user = $userid;

        $companies = $this->getActivityCompaniesID($location_id, $user);

        $save_data = array();
        $length = count($companies);

        for ($i = 0; $i < $length; $i++) {
            $save_data[] = $this->getCompany($companies[$i]->company_id);
        }

        return $save_data;
    }

    public function getActivityDataTypesID($locationid, $userid)
    {
        $sql = "SELECT datatype_id FROM log_locations_datatypes WHERE location_id = :locationid AND user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(':locationid' => $locationid, ':userid' => $userid);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getActivityCompaniesID($locationid, $userid)
    {
        $sql = "SELECT company_id FROM log_locations_companies WHERE location_id = :locationid AND user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(':locationid' => $locationid, ':userid' => $userid);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function addActivity($form, $userid)
    {
          $locationID = $this->addIntoLocations($form["title"], $form["description"], $form["date"], $form["time"], $form["location"]["lat"], $form["location"]["long"], $userid, $form["categories"]);

          if($locationID)
          {
              foreach($form["datatypes"] as $datatype)
              {
                  $this->addIntoLocationsDatatypes($datatype, $locationID, $userid);
              }

              foreach($form["companies"] as $company)
              {
                  $this->addIntoLocationsCompanies($company, $locationID, $userid);
              }
          }
    }

    public function addIntoLocations($title, $description, $ldate, $ltime, $lat, $long, $userid, $categoryid)
    {
        $sql = "INSERT INTO log_locations (titel, description, l_date, l_time, l_lat, l_long, user_id, category_id) VALUES (:titel, :description, :ldate, :ltime, :lat, :long, :userid, :categoryid)";
        $query = $this->db->prepare($sql);
        $parameters = array(':titel' => $title, ':description' => $description, ':ldate' => $ldate, ':ltime' => $ltime, ':lat' => $lat, ':long' => $long, ':userid' => $userid, ':categoryid' => $categoryid,);

        $query->execute($parameters);
        $id = $this->db->lastInsertId();

        return $id;
    }

    public function addIntoLocationsCompanies($companyid, $locationid, $userid)
    {
        $sql = "INSERT INTO log_locations_companies (company_id, location_id, user_id) VALUES (:companyid, :locationid, :userid)";
        $query = $this->db->prepare($sql);
        $parameters = array(':companyid' => $companyid, ':locationid' => $locationid, ':userid' => $userid);

        $query->execute($parameters);
    }

    public function addIntoLocationsDatatypes($datatypeid, $locationid, $userid)
    {
        $sql = "INSERT INTO log_locations_datatypes (datatype_id, location_id, user_id) VALUES (:datatypeid, :locationid, :userid)";
        $query = $this->db->prepare($sql);
        $parameters = array(':datatypeid' => $datatypeid, ':locationid' => $locationid , ':userid' => $userid);

        $query->execute($parameters);
    }

    public function getAmountOfActivities($userid)
    {
        $sql = "SELECT COUNT(id) AS amount_of_activities FROM log_locations WHERE user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(":userid" => $userid);
        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_activities;
    }

    public function updateActivity($form, $user_id)
    {
        $sql = "UPDATE log_locations SET titel = :titel, description = :descr, l_date = :ldate, l_time = :ltime, l_lat = :llat, l_long= :llong, category_id = :categoryid WHERE id = :formid AND user_id = '$user_id'";
        $query = $this->db->prepare($sql);
        $parameters = array(':titel' => $form["title"], ':descr' => $form["description"], ':ldate' => $form["date"], ':ltime' => $form["time"], ':llat' => $form["location"]["lat"], ':llong' => $form["location"]["long"], ':categoryid' => $form["categories"], ':formid' => $form["id"]);

        // delete all companies from activity
        $this->deleteActivityCompanies($form["id"]);

        // re-enter them in the database
        foreach($form["companies"] as $companyid){
            $this->addIntoLocationsCompanies($companyid, $form["id"], $user_id);
        }

        // delete all datatypes from activity
        $this->deleteActivityDataTypes($form["id"]);

        // re-enter them in the database
        foreach($form["datatypes"] as $dataID){
            $this->addIntoLocationsDatatypes($dataID, $form["id"], $user_id);
        }

        // Main executioner for updating the location
        $query->execute($parameters);
    }

    public function deleteActivityCompanies($location_id)
    {
        $sql = "DELETE FROM log_locations_companies WHERE location_id = :locationid";
        $query = $this->db->prepare($sql);
        $parameters = array(':locationid' => $location_id);
        $query->execute($parameters);
    }

    public function deleteActivityDataTypes($location_id)
    {
        $sql = "DELETE FROM log_locations_datatypes WHERE location_id = :locationid";
        $query = $this->db->prepare($sql);
        $parameters = array(':locationid' => $location_id);
        $query->execute($parameters);
    }

    public function deleteActivity($location_id, $user_id)
    {
        $sql = "DELETE FROM log_locations WHERE id = :locationid";
        $query = $this->db->prepare($sql);
        $parameters = array(':locationid' => $location_id);

        $this->deleteActivityCompanies($location_id, $user_id);
        $this->deleteActivityDataTypes($location_id, $user_id);
        $query->execute($parameters);
    }


    /**
     * @CATEGORIES
     */


    /**
     * Get all companies from database
     */
    public function getAllCategories($userid)
    {
        $sql = "SELECT id, titel FROM log_categories WHERE user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(':userid' => $userid);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getCategoryByTitel($title, $user_id)
    {
        $sql = "SELECT id, titel, user_id FROM log_categories WHERE titel = :title AND user_id = :userid LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':title' => $title, ':userid' => $user_id);

        $query->execute($parameters);
        return $query->fetch();
    }

    public function getCategory($category_id)
    {
        $sql = "SELECT id, titel, user_id FROM log_categories WHERE id = :categoryid LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':categoryid' => $category_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function addCategory($category, $userid)
    {
        $sql = "INSERT INTO log_categories (titel, user_id) VALUES (:titel, :userid)";
        $query = $this->db->prepare($sql);
        $parameters = array(':titel' => $category, ':userid' => $userid);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public function deleteCategory($category_id)
    {
        $sql = "DELETE FROM log_categories WHERE id = :category_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':category_id' => $category_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public function updateCategory($category, $category_id)
    {
        $sql = "UPDATE log_categories SET titel = :category WHERE id = :categoryid";
        $query = $this->db->prepare($sql);
        $parameters = array(':category' => $category, ':categoryid' => $category_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

    public function getAmountOfCategory($categoryid, $userid)
    {
        $sql = "SELECT COUNT(id) AS amount_of_category FROM log_locations WHERE category_id = :categoryid AND user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(":categoryid" => $categoryid, ":userid" => $userid);
        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_category;
    }

    public function getAmountOfCategories($userid)
    {
        $sql = "SELECT COUNT(id) AS amount_of_categories FROM log_categories WHERE user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(":userid" => $userid);
        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_categories;
    }




    /**
     * @DATATYPES
     */


    /**
     * Get all companies from database
     */
    public function getAllDatatypes($userid)
    {
        $sql = "SELECT id, titel FROM log_dataTypes WHERE user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(':userid' => $userid);
        $query->execute($parameters);

        return $query->fetchAll();
    }

    public function getDatatypeByTitel($title, $user_id)
    {
        $sql = "SELECT id, titel, user_id FROM log_dataTypes WHERE titel = :title AND user_id = :userid LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':title' => $title, ':userid' => $user_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getDatatype($datatype_id)
    {
        $sql = "SELECT id, titel, user_id FROM log_dataTypes WHERE id = :datatypeid LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':datatypeid' => $datatype_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function addDatatype($datatype, $userid)
    {
        $sql = "INSERT INTO log_dataTypes (titel, user_id) VALUES (:titel, :userid)";
        $query = $this->db->prepare($sql);
        $parameters = array(':titel' => $datatype, ':userid' => $userid);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public function deleteDatatype($datatype_id)
    {
        $sql = "DELETE FROM log_dataTypes WHERE id = :datatype_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':datatype_id' => $datatype_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public function updateDatatype($datatype, $datatype_id)
    {
        $sql = "UPDATE log_dataTypes SET titel = :datatype WHERE id = :datatypeid";
        $query = $this->db->prepare($sql);
        $parameters = array(':datatype' => $datatype, ':datatypeid' => $datatype_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

    public function getAmountOfDatatypes($userid)
    {
        $sql = "SELECT COUNT(id) AS amount_of_datatypes FROM log_dataTypes WHERE user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(":userid" => $userid);
        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_datatypes;
    }


    /**
     * @COMPANIES
     */


    /**
     * Get all companies from database
     */
    public function getAllCompanies($userid)
    {
        $sql = "SELECT id, titel FROM log_companies WHERE user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(':userid' => $userid);
        $query->execute($parameters);

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
        return $query->fetchAll();
    }

    public function getCompanyByTitel($title, $user_id)
    {
        $sql = "SELECT id, titel, user_id FROM log_companies WHERE titel = :title AND user_id = :userid LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':title' => $title, ':userid' => $user_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function getCompany($company_id)
    {
        $sql = "SELECT id, titel, user_id FROM log_companies WHERE id = :companyid LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':companyid' => $company_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    public function addCompany($company, $userid)
    {
        $sql = "INSERT INTO log_companies (titel, user_id) VALUES (:titel, :userid)";
        $query = $this->db->prepare($sql);
        $parameters = array(':titel' => $company, ':userid' => $userid);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public function deleteCompany($company_id)
    {
        $sql = "DELETE FROM log_companies WHERE id = :company_id";
        $query = $this->db->prepare($sql);
        $parameters = array(':company_id' => $company_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

        $query->execute($parameters);
    }

    public function updateCompany($company, $company_id)
    {
        $sql = "UPDATE log_companies SET titel = :company WHERE id = :companyid";
        $query = $this->db->prepare($sql);
        $parameters = array(':company' => $company, ':companyid' => $company_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();
        $query->execute($parameters);
    }

    public function getAmountOfCompanies($userid)
    {
        $sql = "SELECT COUNT(id) AS amount_of_companies FROM log_companies WHERE user_id = :userid";
        $query = $this->db->prepare($sql);
        $parameters = array(":userid" => $userid);
        $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
        return $query->fetch()->amount_of_companies;
    }
}
