<!doctype html>
<html>
    <head>
        <?php
        include("config.php");
     
        if(isset($_POST['but_upload'])){
            $maxsize = 5242880; // 5MB
                       
            $name = $_FILES['file']['name'];
            $target_dir = "videos/";
            $target_file = $target_dir . $_FILES["file"]["name"];

            // Select file type
            $videoFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Valid file extensions
            $extensions_arr = array("mp4","avi","3gp","mov","mpeg");

            // Check extension
            if( in_array($videoFileType,$extensions_arr) ){
                
                // Check file size
                if(($_FILES['file']['size'] >= $maxsize) || ($_FILES["file"]["size"] == 0)) {
                    echo "File too large. File must be less than 5MB.";
                }else{
                    // Upload
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$target_file)){
                        // Insert record
                        $query = "INSERT INTO videos(name,location) VALUES('".$name."','".$target_file."')";

                        mysqli_query($con,$query);
                        echo "Upload successfully.";
                    }
                }

            }else{
                echo "Invalid file extension.";
            }
        
        }
		
$dir = "videos/";
$videoW = 320;
$videoH = 240;

if (is_dir($dir))
{
    if ($dh = opendir($dir)){

        while (($file = readdir($dh)) !== false){

            if($file != '.' && $file != '..'){

                echo 
                "
                    <div style='display: block'>
                        <video width=\"$videoW\" height=\"$videoH\" controls>
                          <source src=\"". $dir . $file ."\" type=\"video/mp4\">
                          <source src=\"". $dir . $file ."\" type=\"video/ogg\">
                        </video>
                    </div>
                ";

            }

        }

        closedir($dh);

      }
}
//deleted the file
if(isset($_POST['delete'])){
	$file=$_POST['fname'];
	$pathtodir = getcwd();
	$dir = $pathtodir.'/videos/';
	unlink($dir."".$file);
	echo '<div class="alert alert-success" role="alert">
	Success, Your file has been deleted.
	</div>';
	echo "<meta http-equiv='refresh' contect='0'>";
}

        ?>
    </head>
    <body>
        <form method="post" action="" enctype='multipart/form-data'>
            <input type='file' name='file' />
            <input type='submit' value='Upload' name='but_upload'>
        </form>
<form action='deletefile.php' method='POST'>
<button type='submit' name='submit'>Deleted file</button>
</form>
    </body>
</html>
