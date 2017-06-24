<?php
    echo '<div class="center wrapper">
        <input type="text" id="searchValue" onkeyup="searchItemTables()" placeholder="Search for listing..">
        
            <div class="dropdown">
                <form class="form" id="formLogin" onsubmit="getAllListings('."'listingArea','/php/itemGetAll.php'".',true); return false;">
                    <button class="dropbtn dropdown-toggle" type="button" data-toggle="dropdown">Filter<span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-content">
                        <li>
                            <select id="tagFilterList" class="form-control" name="tagFilterList">
                                <option value="" selected="selected">All</option>
                            </select>
                        </li>
                        <li>
                            <input type="radio" name="statusFilter" id="statusFilter" value="" checked>All
                            <input type="radio" name="statusFilter" id="statusFilter" value="0">Available
                            <input type="radio" name="statusFilter" id="statusFilter" value="1">Wanted
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