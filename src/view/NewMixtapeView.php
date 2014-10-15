<?php
namespace view;

class NewMixtapeView {

    private $messages;

    public function getPostedMixtapeName() {
        return $_POST["mixtapeName"];;
    }
    public function getPostedMixtapeLinks() {
        return $_POST["mixtapeLinks"];;
    }

    public function __construct()
    {
        $this->messages = new \view\MessageView();
    }

    // Checks if the user has pressed the createMixtapeButton.
    public function onClickAddMixtape() {
        if(isset($_POST["createMixtapeButton"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // Handles the upload of a image for the mixtape
    public function uploadMixtapeImage() {
        /*
           NOTE FOR EXAMINATORS! This code is based on the examples from W3 Schools PHP Upload!
           http://www.w3schools.com/php/php_file_upload.asp
        */

        $target_dir = "src/gfx/playlistImages/";
        $target_dir = $target_dir . time() . "-" . basename( $_FILES["image"]["name"]);
        $uploadOk=1;

        if (($_FILES["image"] != "image/jpg")) {
            echo "Sorry, only .jpg files are allowed.";
            $uploadOk = 0;
        }
        else
        {
            throw new \Exception();
        }

        if($uploadOk != 1)
        {
            throw new \Exception();
        }
        else
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir))
            {
                return basename( $_FILES["image"]["name"]);
            }
            else
            {
                throw new \Exception();
            }
        }
    }

    public function validateMixtape() {
        if ($this->getPostedMixtapeName() == "")
        {
            $this->messages->save("Mixtape name is missing");
            return false;
        }
        elseif ($this->getPostedMixtapeLinks() == "")
        {
            $this->messages->save("No mixtape links added, mixtape can't be empty");
            return false;
        }
        else
        {
            $mixtapeLinksValidated = array();

            // Splits the values at "newline" and throws them into a array
            $mixtapeLinks = explode("\n", $this->getPostedMixtapeLinks());
            // Arrays whos indexes contains nothing are removed
            $emptyRemoved = array_diff($mixtapeLinks, array(''));

            // Trimming away unwanted whitespaces from the links (if they exist)
            foreach ($emptyRemoved as $mixtapeLink) {
                array_push($mixtapeLinksValidated, trim($mixtapeLink));
            }

            // Validates that the mixtape links truly are Spotify URI links (these are always 36 chars)
            foreach ($mixtapeLinksValidated as $mixtapeLink)
            {
                if(strlen($mixtapeLink) != 36)
                {
                    $this->messages->save("Mixtape contains non-Spotify URI links");
                    return $this->showPage();
                }
            }
        }

        return true;
    }

    public function showPage() {
        $mixtapeName = isset($_POST["mixtapeName"]) ? $_POST["mixtapeName"] : "";
        return "<div class='container'>
            <h1>Create a new mixtape</h1>
            <p>Creating a new mixtape is easy! Just give your mixtape a name, then highlight your songs of choice from spotify and choose copy URI, then paste it in the
            textarea down below. Check out <a href=''>this guide</a> if you are uncertain of how things work!</p>
            <p>&nbsp;</p>

             <form action='' method='post' name='newMixtapeForm' enctype='multipart/form-data'>
                <fieldset>
                <legend>Create your new mixtape</legend><p style='color: red;'>" . $this->messages->load() . "</p>
                <label><strong>Mixtape name: </strong></label>
                <input type='text' name='mixtapeName' class='form-control' value='$mixtapeName' /><br />
                <label><strong>Mixtape songs: </strong></label>
                <textarea class='form-control' rows='20' name='mixtapeLinks'></textarea><br />
                <label><strong>Choose a mixtape image: </strong></label>
                <input type='file' name='image'><br />
                <input type='submit' value='Create mixtape' name='createMixtapeButton' class='btn btn-default' />
                </fieldset>
            </form>
        </div>";
    }
}