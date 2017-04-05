    <?php

    class DatabaseAPI
    {
        public function addUser($IsAdmin, $Username, $Password, $Firstname, $Surname, $Gender, $Postcode, $TelephoneNo) {
            $db = Database::getDB();

            // hash pw, then pass it through
            $Password = md5($Password);
            $query = "INSERT INTO `user` (`IsAdmin`, `Username`, `Password`, `Firstname`, `Surname`, `Gender`, `Postcode`,
            `TelephoneNo`) VALUES ($IsAdmin, '$Username', '$Password', '$Firstname', '$Surname', '$Gender', '$Postcode', '$TelephoneNo')";
            $sql = $db->prepare($query);
            $sql->execute();
        }

        public function addRequest($UserID, $ItemID, $Status, $Description) {
            $db = Database::getDB();

            $query = "INSERT INTO `requests` ('UserID', 'ItemID', 'Status', 'Description')
            VALUES ($UserID, $ItemID, '$Status', '$Description')";
            $sql = $db->prepare($query);
            $sql->execute();
        }

        public function addItem($ItemName, $Category, $UserID, $FoundPlace, $Colour, $Photo, $Description) {
            $db = Database::getDB();

            $query = "INSERT INTO `item` (`ItemName`, `Category`, `UserID`, `FoundPlace`, `Colour`, `Photo`, `Description`)
            VALUES ('$ItemName','$Category', $UserID, '$FoundPlace', '$Colour', '$Photo', '$Description')";

            $sql = $db->prepare($query);
            $sql->execute();
        }

        public function checkUsernameExists($Username) {
            $db = Database::getDB();
            $query = "SELECT COUNT(UserID) FROM user WHERE Username = '$Username'";

            $sql = $db->prepare($query);
            $sql->execute();

            $count = $sql->fetchColumn();

            return $count > 0 ? true : false;
        }

        public function verifyPassword($Password, $Username) {
            $db = Database::getDB();

            $query = "SELECT COUNT(UserID) FROM user WHERE Password = '$Password' AND Username = '$Username'";

            $sql = $db->prepare($query);
            $sql->execute();

            $count = $sql->fetchColumn();

            return $count > 0 ? true : false;
        }

        public function getUserUserID($Username) {
            $db = Database::getDB();
            $query = "SELECT UserID FROM user WHERE Username = '$Username'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserAdminStatus($UserID) {
            $db = Database::getDB();
            $query = "SELECT IsAdmin FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserUsername($UserID) {
            $db = Database::getDB();
            $query = "SELECT Username FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserPasswordWithID($UserID) {
            $db = Database::getDB();
            $query = "SELECT Password FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserPasswordWithUsername($Username) {
            $db = Database::getDB();
            $query = "SELECT Password FROM user WHERE Username = '$Username'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserPassword($UserID) {
            $db = Database::getDB();
            $query = "SELECT Password FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserFirstname($UserID) {
            $db = Database::getDB();
            $query = "SELECT Firstname FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserSurname($UserID) {
            $db = Database::getDB();
            $query = "SELECT Surname FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserGender($UserID) {
            $db = Database::getDB();
            $query = "SELECT Gender FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserPostcode($UserID) {
            $db = Database::getDB();
            $query = "SELECT Postcode FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getUserTelephoneNo($UserID) {
            $db = Database::getDB();
            $query = "SELECT TelephoneNo FROM user WHERE UserID = '$UserID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function setRequestStatus($Status, $RequestID) {
            $db = Database::getDB();
            $query = "UPDATE requests SET Status = '$Status' WHERE RequestID = $RequestID";

            $sql = $db->prepare($query);
            $sql->execute();
        }

        public function hasUserRequested($UserID, $RequestID) {
            $db = Database::getDB();
            $query = "SELECT COUNT(RequestID) FROM requests WHERE UserID = '$UserID' AND RequestID = '$RequestID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $count = $sql->fetchColumn();

            return $count > 0 ? true : false;
        }

        public function getRequestUserID($RequestID) {
            $db = Database::getDB();
            $query = "SELECT UserID FROM requests WHERE RequestID = '$RequestID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getRequestItemID($RequestID) {
            $db = Database::getDB();
            $query = "SELECT ItemID FROM requests WHERE RequestID = '$RequestID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getRequestStatus($RequestID) {
            $db = Database::getDB();
            $query = "SELECT Status FROM requests WHERE RequestID = '$RequestID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getRequestDescription($RequestID) {
            $db = Database::getDB();
            $query = "SELECT Description FROM requests WHERE RequestID = '$RequestID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getRequestDate($RequestID) {
            $db = Database::getDB();
            $query = "SELECT DateCreated FROM requests WHERE RequestID = '$RequestID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getItemName($ItemID) {
            $db = Database::getDB();
            $query = "SELECT ItemName FROM item WHERE ItemID = '$ItemID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getItemCategory($ItemID) {
            $db = Database::getDB();
            $query = "SELECT Category FROM item WHERE ItemID = '$ItemID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getItemUserID($ItemID) {
            $db = Database::getDB();
            $query = "SELECT UserID FROM item WHERE ItemID = '$ItemID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getItemFoundPlace($ItemID) {
            $db = Database::getDB();
            $query = "SELECT FoundPlace FROM item WHERE ItemID = '$ItemID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getItemColour($ItemID) {
            $db = Database::getDB();
            $query = "SELECT Colour FROM item WHERE ItemID = '$ItemID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getItemPhoto($ItemID) {
            $db = Database::getDB();
            $query = "SELECT Photo FROM item WHERE ItemID = '$ItemID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getItemDescription($ItemID) {
            $db = Database::getDB();
            $query = "SELECT Description FROM item WHERE ItemID = '$ItemID'";

            $sql = $db->prepare($query);
            $sql->execute();

            $result = $sql->fetch();
            return $result;
        }

        public function getItems() {
            $db = Database::getDB();
            $query = "SELECT * FROM item";

            $sql = $db->prepare($query);
            $sql->execute();

            $results = $sql->fetchAll();
            return $results;
        }

        public function getUsers() {
            $db = Database::getDB();
            $query = "SELECT * FROM user";

            $sql = $db->prepare($query);
            $sql->execute();

            $results = $sql->fetchAll();
            return $results;
        }

        public function getRequests(){
            $db = Database::getDB();
            $query = "SELECT * FROM requests";

            $sql = $db->prepare($query);
            $sql->execute();

            $results = $sql->fetchAll();
            return $results;
        }
    }