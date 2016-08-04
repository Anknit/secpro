<?php
?>
<div class="page-container offset-header">
    <div class="container" data-ng-controller="imageDataController">
        <div class="row">
            <button class="btn btn-theme" data-ng-click="getManualModeStream()">Manual Mode</button>
            <button class="btn btn-theme" data-ng-click="getAutoModeStream()">Auto Mode</button>
        </div>
        <div class="row" id="image-data-section">
            <div class="image-container">
                <div class="image-overlay"></div>
                <img class="data-image" id="main-stream-image" data-ng-src="{{streamdata.imgsrc}}" alt=""/>
            </div>
        </div>
    </div>
    <h1>Hello World!</h1>
</div>