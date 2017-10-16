<?php
    echo '<div class="center wrapper">
        <input type="text" id="searchValue" onkeyup="searchTables()" placeholder="Search for listing..">'; //On keypress the content in this text input filters the shown items (hides page breaks so all items are shown at the start but re-hides it when emptyed so the pages reappear)
        include('../legendBar.php'); //Gets the legend collapse (shows the key for items)
        //Create a dropdown to filter the items (item status and or tag)
        //The tag can be selected from a drop down and the item staus is a radio button.
        //Clicking filter refreshes the displayed items with the selected settings
        //There is also a toggle button the changes how the items are dispayed (expanded or just the title)
        echo '<div class="dropdown">
            <form class="form" id="formLogin">
                <button class="dropbtn dropdown-toggle" type="button" data-toggle="dropdown">Filter/Settings<span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-content">
                    <li>
                        <select id="tagFilterList" class="form-control" name="tagFilterList">
                            <option value="" selected="selected">All</option>
                        </select>
                    </li>
                    <li>
                        <label><input type="radio" name="statusFilter" value="" checked>All</label>
                        <label><input type="radio" name="statusFilter" value="0">Available</label>
                        <label><input type="radio" name="statusFilter" value="1">Reserved</label>
                    </li>
                    <li>
                    <button class="btn btn-default" onclick="getAllListings(null); return false">Filter</button>
                    <button class="btn btn-default" onclick="toggleItemInfo(); return false">Toggle view</button>
                    </li>
                </ul>
            </form>
        </div>
        <div></div>

        <div id="listingArea"></div>
    </div>';
    //Listing area is where the items will go
?>