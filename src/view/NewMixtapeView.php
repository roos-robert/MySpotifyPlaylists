<?php
namespace view;

class NewMixtapeView {
    public function showPage() {
        return "<div class='container'>
            <h1>Create a new mixtape</h1>
            <p>Creating a new mixtape is easy! Just give your mixtape a name, then highlight your songs of choice from spotify and choose copy URI, then paste it in the
            textarea down below. Check out <a href=''>this guide</a> if you are uncertain of how things work!</p>
            <p>&nbsp;</p>

             <form action='' method='post' name='newMixtapeForm'>
                <fieldset>
                <legend>Create your new mixtape</legend>
                <label><strong>Mixtape name: </strong></label>
                <input type='text' name='mixtapeName' class='form-control' value='' /><br />
                <label><strong>Mixtape songs: </strong></label>
                <textarea class='form-control' rows='20'></textarea><br />
                <input type='submit' value='Create mixtape' name='createMixtapeButton' class='btn btn-default' />
                </fieldset>
            </form>
        </div>";
    }
}