@extends('layouts.app')

@section('content')
    <div class="row">
        <ul id="sortable1" class="col-xl-4 col-lg-4 col-md-12 col-sm-12 droptrue">
            <li data-name="Your Message Inbox" data-id="1" class="ml-3 mb-3 mb-md-4 mb-sm-3 ui-state-default">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Your Message Inbox</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Messages</a>
                    </div>
                </div>
            </li>
            <li data-name="Recent Posts" data-id="2" class="ml-3 mb-3 mb-md-4 mb-sm-3 ui-state-default">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recent Posts</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Posts</a>
                    </div>
                </div>
            </li>
            <li data-name="Recently Added Casefiles" data-id="3" class="ml-3 mb-3 mb-md-4 mb-sm-3 ui-state-default">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recently Added Casefiles</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Casefiles</a>
                    </div>
                </div>
            </li>
        </ul>

        <ul id="sortable2" class="col-xl-4 col-lg-4 col-md-12 col-sm-12 droptrue">
            <li data-name="Recently Modified Casefiles" data-id="4" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recently Modified Casefiles</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Casefiles</a>
                    </div>
                </div>
            </li>
            <li data-name="Cases Assigned To You" data-id="5" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Cases Assigned To You</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Cases</a>
                    </div>
                </div>
            </li>
            <li data-name="Recently Added Clients" data-id="6" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recently Added Clients</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Clients</a>
                    </div>
                </div>
            </li>
        </ul>

        <ul id="sortable3" class="col-xl-4 col-lg-4 col-md-12 col-sm-12 droptrue">
            <li data-name="Recent User Logins" data-id="7" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recent User Logins</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Users</a>
                    </div>
                </div>
            </li>
            <li data-name="Statistics" data-id="8" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Statistics</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Statistics</a>
                    </div>
                </div>
            </li>
            <li data-name="Recent User Actions" data-id="9" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recent User Actions</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-sm btn-primary">Go to Action Log</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <br style="clear:both">

@endsection
