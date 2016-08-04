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
        <div class="row" id="comments-data-section">
            <div class="comments-container">
                <p data-ng-bind="streamdata.comments"></p>
            </div>
        </div>
        <div class="row" id="data-store">
            <div class="">
                <ul class="list-inline">
                    <li data-ng-repeat="(key, value) in streamdata.dataObj">
                        <div class="image-container">
                            <img class="data-image" data-ng-src="{{value.url}}" alt=""/>
                        </div>
                        <div class="text-center">{{(value.timestamp * 1000) |  date:'HH:mm:ss'}}</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>