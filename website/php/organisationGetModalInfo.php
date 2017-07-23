<?php
	include("config.php");
	session_start();

    $stmt = $db->prepare("SELECT * FROM organisation WHERE groupID=?");
    $stmt->execute(array(@$_GET['id']));

	echo '<div class="modal-dialog">
        <div class="modal-content">
            <div id="itemInfo" style="display: block;">
                <div class="modal-header background-color-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><modalTitle>&times;</modalTitle></button>';

                    if ($stmt->rowCount() > 0) {
                        $organisationResult = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo '<modalTitle class="myModalLabel">'.$organisationResult['name'].'</modalTitle>
                        </div>
                        <div class="modal-body">
                            <div class="center wrapper">
                                <br><table class="table table-striped table-bordered table-hover table-restrict-size table-padding fullItemDesc">
                                    <thead>
                                        <tr>
                                            <td colspan="2">
                                                <b>'.$organisationResult['name'].'<b>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <b>Description: </b>'.$organisationResult['Information'].'
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Current News: </b>'.$organisationResult['currentNews'].'
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <iframe class="maps-frame" src="https://www.google.com/maps/embed/v1/search?q='.str_replace(' ', '+', $organisationResult['address']).'+3350+Australia&zoom=16&key=AIzaSyDnIx1QkG-_64NuLSYxxQj4vkcdt9I5zV0"></iframe>
                                <br><button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true"">Close window</button>
                            </div>
                        </div>';
                    } else {
                        echo '<modalTitle class="myModalLabel">Organisation not found</modalTitle>
                        </div>
                        <div class="modal-body">
                            <div class="center wrapper">
                                <button type="button" class="btn btn-default testing" data-dismiss="modal" aria-hidden="true"">Close window</button>
                            </div>
                        </div>';
                    }

            echo'</div>
        </div>
    </div>';

?>