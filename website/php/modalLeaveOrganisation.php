<?php
    session_start();
    echo '<div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header background-color-blue">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
                <span class="modalTitle">Leave organisation</span>
            </div>

            <div id="leaveOrganisationMessage" class="modal-body testing">';
            if (isset($_SESSION['userID'])){
                echo 'WARNING: Are you sure you want to leave your organisation?<br>
                </div>
                <div class="modal-footer testing">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" onclick="leaveOrganisation()">Yes leave organisation</button>
                </div>';
            } else {
                echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <p>YOU MUST BE LOGGED IN TO LEAVE YOUR ORGANISATION</p>
                </div>
                </div>
                <div class="modal-footer testing">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>';
            }
        echo '</div>
    </div>';
?>