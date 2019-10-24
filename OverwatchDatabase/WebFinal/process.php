<?php
    include 'php-image-resize-master\lib\ImageResize.php';
    use \Gumlet\ImageResize;
    //IMAGE CHECK
    $img = "";
    print_r($_FILES['image']);
    function file_upload_path($original_filename, $upload_subfolder_name = 'images')
    {
        $current_folder = dirname(__FILE__);
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }
    
    function file_is_an_image($temporary_path, $new_path)
    {
        $allowed_mime_types = ['image/png'];
        $allowed_file_extensions = ['png'];
        $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type = $_FILES['image']['type'];
    
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);
        return $file_extension_is_valid && $mime_type_is_valid;
    }
    
    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
    $upload_error_detected = isset($_FILES['image']) && ($_FILES['image']['error'] > 0);
    
    if ($image_upload_detected) {
        $image_filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
        $image_fileExtention = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $new_image_path = file_upload_path($_FILES['image']['name']);
        
        if (file_is_an_image($temporary_image_path, $new_image_path)) {
            move_uploaded_file($temporary_image_path, $new_image_path);
            $img = $image_filename;

            $medImage = new ImageResize(file_upload_path($image_filename . "." . $image_fileExtention));
            $medImage->resize(100,90);
            $medImage->save(file_upload_path($image_filename . "." . $image_fileExtention));
        }
    }

    //Sanatizing posted values
    $heroName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_SPECIAL_CHARS);
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $realName = filter_input(INPUT_POST, 'realName', FILTER_SANITIZE_SPECIAL_CHARS);
    $occupation = filter_input(INPUT_POST, 'occupation', FILTER_SANITIZE_SPECIAL_CHARS);
    $age = filter_input(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
    $base = filter_input(INPUT_POST, 'base', FILTER_SANITIZE_SPECIAL_CHARS);
    $affiliation = filter_input(INPUT_POST, 'affiliation', FILTER_SANITIZE_SPECIAL_CHARS);

    //running sql qurires depending on request
    if($_POST['command'] == "Create")
    {
        require('connect.php');
        $query = "INSERT INTO hero (Name, Image, Role) values (:hero, :img, :hero)";
        $statement = $db->prepare($query);
        $statement->bindValue(':hero', $heroName);
        $statement->bindValue(':img', $img);
        $statement->bindValue(':role', $role);
        $statement->execute();

        $select_query = 'SELECT * FROM hero ORDER BY HeroId DESC LIMIT 1';
        $statement2 = $db->prepare($select_query);
        $statement2->execute();
        $status = $statement2->fetch();

        $detailInsert = "INSERT INTO detail ( HeroId, RealName, Occupation, Age, BaseOfOperation, Affiliation) VALUES (:id, :realName, :occupation, :age, :base, :affiliation)";
        $statement3 = $db->prepare($detailInsert);
        $statement3->bindValue(':id', $status['HeroId']);
        $statement3->bindValue(':realName', $realName);
        $statement3->bindValue(':occupation', $occupation);
        $statement3->bindValue(':age', $age);
        $statement3->bindValue(':base', $base);
        $statement3->bindValue(':affiliation', $affiliation);
        $statement3->execute();
        header("Location: characterList.php");
        exit;
    }
    elseif($_POST['command'] == "Update")
    {
        require('connect.php');
        $query = "UPDATE hero SET Name = :hero, Image = :img, Role = :role WHERE HeroId = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':hero', $heroName);
        $statement->bindValue(':role', $role);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':img', $img);
        $statement->execute();

        $detailUpdate = "UPDATE detail SET RealName = :realName, Occupation = :occupation, Age = :age, BaseOfOperation = :base, Affiliation = :affiliation WHERE HeroId = :id";
        $statement2 = $db->prepare($detailUpdate);
        $statement2->bindValue(':realName', $realName);
        $statement2->bindValue(':occupation', $occupation);
        $statement2->bindValue(':age', $age);
        $statement2->bindValue(':base', $base);
        $statement2->bindValue(':affiliation', $affiliation);
        $statement2->bindValue(':id', $id, PDO::PARAM_INT);
        $statement2->execute();
        
        //Delete image if the box is checked
        if (isset($_POST['imagedel'])) {
            $imgquery = "UPDATE hero SET Image = :nullImage WHERE HeroID = :heroid ";;
            $stat = $db->prepare($imgquery);
            $stat->bindValue(':nullImage', '');
            $stat->bindValue(':heroid', $id, PDO::PARAM_INT);
            $stat->execute();
        }

        header("Location: characterList.php");
        exit;
    }
    elseif($_POST['command'] == "Delete")
    {
        require('connect.php');
        $query = "DELETE FROM hero WHERE HeroId = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        header("Location: characterList.php");
        exit;
    }

    
?>