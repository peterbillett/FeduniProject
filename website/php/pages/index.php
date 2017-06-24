<?php
    echo '<div id="text-carousel" class="carousel slide" data-ride="carousel">

	    <!-- Slides -->
	    <div class="row">
	        <div class="col-xs-offset-3 col-xs-6">
	            <div class="carousel-inner">
	                <div class="item active">
	                	<button type="button" class="no-button no-select-link" onclick="getItemModal(3)" data-toggle="modal" data-target="#modal-modalDetails">
            				<h4> Coaches </h4>
                            Looking for people to help out with coaching under 12 basketball. Please ensure you have working with children qualifications before applying.
            				<br>End date/time: 2017-04-14 00:00:00
                            <br>Organisation: YMCA Ballarat
                        </button>
	                </div>
	                <div class="item">
	                	<button type="button" class="no-button no-select-link" onclick="getItemModal(5)" data-toggle="modal" data-target="#modal-modalDetails">
            				<h4> Sausages </h4>
            				10kg of sausages. Please contact for more information.
                            <br>End date/time: 2017-04-10 00:00:00
                            <br>Organisation: Harvest Ministry of Food
	                    </button>
	                </div>
                </div>
	        </div>
	    </div>

    	<!--Controls -->
    	<a class="left carousel-control" href="#text-carousel" data-slide="prev">
    		<span class="glyphicon glyphicon-chevron-left"></span>
  		</a>
 		<a class="right carousel-control" href="#text-carousel" data-slide="next">
    		<span class="glyphicon glyphicon-chevron-right"></span>
  		</a>

	</div>';
?>