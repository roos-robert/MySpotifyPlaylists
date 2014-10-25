<?php
namespace view;

use model\MixtapeModel;
use model\MixtapeRowList;

class NewMixtapeView {
    private $messages;
    private $userModel;

    // Fields to handle dependencies, note in this class that some of the getters takes over this functionality.
    private static $mixtapeName = "mixtapeName";

    public function getPostedMixtapeName() {
        return $_POST[self::$mixtapeName];;
    }
    public function getPostedPicPath() {
        return $_POST["picPath"];;
    }
    public function getPostedMixtapeID() {
        return $_POST["mixtapeID"];;
    }
    public function getPostedMixtapeLinks() {
        return $_POST["mixtapeLinks"];;
    }

    public function __construct()
    {
        $this->userModel = new \model\UserModel();
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

    // Checks if the user has pressed the updateMixtapeButton.
    public function onClickUpdateMixtape() {
        if(isset($_POST["updateMixtapeButton"]))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    // Checks if the user has pressed a button for updating a mixtape
    public function mixtapeUpdateChosen() {
        if (isset($_GET["update"]))
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
           NOTE FOR EXAMINATORS! This code (row 51-54) is based on the examples from W3 Schools PHP Upload!
           http://www.w3schools.com/php/php_file_upload.asp
        */

        $target_dir = "src/gfx/playlistImages/";
        $randomName = time() . "-" . basename( $_FILES["image"]["name"]);
        $target_dir = $target_dir . $randomName;
        $uploadOk = 1;

        // File size is set to max 200kb.
        if($_FILES["image"]["size"] > 212000)
        {
            $uploadOk = 0;
        }
        else
        {
            // Checks that the file beeing uploaded truly is a .gif/.jpg/.png picture.
            $imageData = @getimagesize($_FILES["image"]["tmp_name"]);
            if($imageData === FALSE || !($imageData[2] == IMAGETYPE_GIF || $imageData[2] == IMAGETYPE_JPEG || $imageData[2] == IMAGETYPE_PNG)) {
                $uploadOk = 0;
            }
        }

        if($uploadOk != 1)
        {
            throw new \Exception();
        }
        else
        {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir))
            {
                return basename($randomName);
            }
            else
            {
                throw new \Exception();
            }
        }
    }

    // Validates the input for the mixtape that is to be added.
    public function validateMixtape() {
        if ($this->getPostedMixtapeName() == "")
        {
            $this->messages->save("Mixtape name is missing");
            return false;
        }
        if (strlen($this->getPostedMixtapeName()) > 50)
        {
            $this->messages->save("Mixtape name is too long, max 50 chars");
            return false;
        }
        if(strpbrk($this->getPostedMixtapeName(), '<>""./') || strpbrk($this->getPostedMixtapeLinks(), '<>""/'))
        {
            $this->messages->save("Mixtape name and/or mixtape songs contains illegal characters");
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
                    return false;
                }
            }
        }

        return true;
    }

    // This is shown instead of showPage after a mixtape has successfully been added.
    public function showMixtapeAdded() {
        return "
        <div class='container'>
            <h1>Success!</h1>
             <p>The mixtape has been added, you can now find it under the section 'My Mixtapes'!</p>
        </div>";
    }

    // This is shown when a exisiting mixtape is to be updated.
    public function showPageUpdateMixtape(MixtapeModel $mixtape, MixtapeRowList $mixtapeRows) {
        if($this->userModel->getLoginStatus() === false)
        {
            header('Location: index.php');
            exit;
        }
        else
        {
            $content = "
                    <div class='jumbotron'>
                      <div class='container'>
                        <img src='src/gfx/Logo.png' width='500' height='200' alt='Mixtapeify' />
                      </div>
                    </div>
            <div class='container'>
                <h1>Update the mixtape </h1>
                <p>Updating a new mixtape is easy! Just give your mixtape a name, then highlight your songs of choice from spotify and choose copy URI, then paste it in the
                textarea down below. Check out <a href='?action=home&about=show'>this guide</a> if you are uncertain of how things work!</p>
                <p>&nbsp;</p>

                 <form action='' method='post' name='newMixtapeForm' enctype='multipart/form-data'>
                    <fieldset>
                    <legend>Update your mixtape</legend><p style='color: red;'>" . $this->messages->load() . "</p>
                    <label><strong>Mixtape name: </strong></label>
                    <input type='text' name='mixtapeName' class='form-control' value='" . $mixtape->getName() . "' /><br />
                    <label><strong>Mixtape songs (max 200): </strong></label>
                    <textarea class='form-control' rows='20' name='mixtapeLinks'>";

                    // Loops out all of the mixtapes row into the textarea.
                    foreach ($mixtapeRows->toArray() as $mixtapeRow) {
                        $content .= $mixtapeRow->getSong() .  "\n";
                    };

            $content .= "</textarea><br />
                    <label><strong>Choose a new mixtape image (max 200kb, OPTIONAL!): </strong></label>
                    <p><img src='src/gfx/playlistImages/" . $mixtape->getPicture() . "' width='50' alt='Current mixtape image' title='Current mixtape image' /></p>
                    <input type='hidden' name='picPath' value='" . $mixtape->getPicture() . "' />
                    <input type='hidden' name='mixtapeID' value='" . $mixtape->getMixtapeID() . "' />
                    <input type='file' name='image'><br />
                    <input type='submit' value='Update mixtape' name='updateMixtapeButton' class='btn btn-default' />
                    </fieldset>
                </form>
            </div>
            <p>&nbsp;</p>";

            return $content;
        }
    }

    // This is shown when a new mixtape is to be added.
    public function showPage() {
        if($this->userModel->getLoginStatus() === false)
        {
            header('Location: index.php');
            exit;
        }
        else
        {
            $mixtapeName = isset($_POST[self::$mixtapeName]) ? $_POST[self::$mixtapeName] : "";
            return "
            <div class='jumbotron'>
                      <div class='container'>
                        <img src='src/gfx/Logo.png' width='500' height='200' alt='Mixtapeify' />
                      </div>
                    </div>
            <div class='container'>
                <h1>Create a new mixtape</h1>
                <p>Creating a new mixtape is easy! Just give your mixtape a name, then highlight your songs of choice from spotify and choose copy URI, then paste it in the
                textarea down below. Check out <a href='?action=home&about=show'>this guide</a> if you are uncertain of how things work!</p>
                <p>&nbsp;</p>
                 <form action='' method='post' name='newMixtapeForm' enctype='multipart/form-data'>
                    <fieldset>
                    <legend>Create your new mixtape</legend><p style='color: red;'>" . $this->messages->load() . "</p>
                    <label><strong>Mixtape name: </strong></label>
                    <input type='text' name='mixtapeName' class='form-control' value='$mixtapeName' /><br />
                    <label><strong>Mixtape songs (max 200): </strong></label>
                    <textarea class='form-control' rows='20' name='mixtapeLinks'></textarea><br />
                    <label><strong>Choose a mixtape image (max 200kb): </strong></label>
                    <input type='file' name='image'><br />
                    <input type='submit' value='Create mixtape' name='createMixtapeButton' class='btn btn-default' />
                    </fieldset>
                </form>
            </div><p>&nbsp;</p>";
        }
    }
}