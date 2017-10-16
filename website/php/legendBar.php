<?php
	//A collapse that has the legend for items (The meanings for the colours and icons)
	echo '<div class="panel-group testing">
        <div class="panel panel-default">
			<div class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseLegend">
                <h4 class="panel-title">
                    <a class="accordion-toggle" data-parent="#panel-group">Legend</a>
                </h4>
            </div>
            <div id="collapseLegend" class="panel-collapse collapse websiteLegend">
				<label class="legendDetails">Available: <span class="dontHideBadge" style="color: #229954;">Green <span class="glyphicon glyphicon-ok-sign dontHideBadge"></span></span></label>
				<label class="legendDetails">Reserved: <span class="dontHideBadge" style="color: #D68910;">Yellow <span class="glyphicon glyphicon-exclamation-sign dontHideBadge"></span></span></label>
				<label class="legendDetails">Unavailable: <span class="dontHideBadge" style="color: #337ab7;">Blue <span class="glyphicon glyphicon-remove-sign dontHideBadge"></span></span></label>
				</br>
				<label class="legendDetails">Request: <span class="fa fa-shopping-cart dontHideBadge" ></span></label>
				<label class="legendDetails">Supply: <span class="glyphicon glyphicon-gift dontHideBadge"></span></label>
			</div>
		</div>
	</div>';
?>