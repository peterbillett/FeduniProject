<?php
    echo '<div class="center wrapper">
        <input type="text" id="searchValue" onkeyup="searchTables()" placeholder="Search for listing..">';
        include('../legendBar.php');
        echo '<div class="dropdown">
            <form class="form" id="formLogin" onsubmit="getAllListings('."'listingArea','/php/itemGetAll.php'".',true); return false;">
                <button class="dropbtn dropdown-toggle" type="button" data-toggle="dropdown">Filter<span class="caret"></span></button>
                <ul class="dropdown-menu dropdown-content">
                    <li>
                        <select id="tagFilterList" class="form-control" name="tagFilterList">
                            <option value="" selected="selected">All</option>
                        </select>
                    </li>
                    <li>
                        <label><input type="radio" name="statusFilter" value="" checked>All</label>
                        <label><input type="radio" name="statusFilter" value="0">Available</label>
                        <label><input type="radio" name="statusFilter" value="1">Wanted</label>
                    </li>
                    <li>
                        <input type="submit" value="Submit">
                    </li>
                </ul>
            </form>
        </div>

        <div id="listingArea"></div>
    </div>';
?>