<div class="row">
    <ul id="sortable1" class="col-xl-4 col-lg-4 col-md-12 col-sm-12 droptrue">
        <li data-name="Your Message Inbox" data-id="1" class="ml-3 mb-3 mb-md-4 mb-sm-3">
            <div class="card">
                <i class="icon-move">&#8596;</i>
                <div class="card-body pt-2">
                    <h5 class="card-title">Your Message Inbox</h5>
                    @include('dashboard.cards.recent-messages-card')
                    <a href="/messages" class="btn btn-sm btn-primary">Go to Messages</a>
                </div>
            </div>
        </li>
        <li data-name="Recent Posts" data-id="2" class="ml-3 mb-3 mb-md-4 mb-sm-3">
            <div class="card">
                <i class="icon-move">&#8596;</i>
                <div class="card-body pt-2">
                    <h5 class="card-title">Recent Posts</h5>
                    @include('dashboard.cards.recent-posts-card')
                    @hasanyrole('Staff|Moderator')
                        <a href="/posts/create" class="btn btn-sm btn-primary">New Post</a>
                    @endhasanyrole
                    <a href="/posts" class="btn btn-sm btn-primary">Go to Posts</a>
                </div>
            </div>
        </li>
        @hasanyrole('Casemanager')
        <li data-name="Recently Added Casefiles" data-id="3" class="ml-3 mb-3 mb-md-4 mb-sm-3">
            <div class="card">
                <i class="icon-move">&#8596;</i>
                <div class="card-body pt-2">
                    <h5 class="card-title">Recently Added Casefiles</h5>
                    @include('dashboard.cards.recent-casefiles-card')
                    @hasanyrole('Casemanager')
                        <a href="/casefiles/create" class="btn btn-sm btn-primary">New Casefile</a>
                    @endhasanyrole
                    <a href="/casefiles" class="btn btn-sm btn-primary">Go to Casefiles</a>
                </div>
            </div>
        </li>
        @endhasanyrole
        @hasanyrole('Casemanager')
            <li data-name="Recently Added Subjects" data-id="11" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recently Added Subjects</h5>
                        @include('dashboard.cards.recent-subjects-card')
                        @hasanyrole('Casemanager')
                            <a href="/subjects/create" class="btn btn-sm btn-primary">New Subject</a>
                        @endhasanyrole
                        <a href="/subjects" class="btn btn-sm btn-primary">Go to Subjects</a>
                    </div>
                </div>
            </li>
        @endhasanyrole
    </ul>
    <ul id="sortable2" class="col-xl-4 col-lg-4 col-md-12 col-sm-12 droptrue">
        @hasanyrole('Casemanager')
            <li data-name="Recently Modified Casefiles" data-id="4" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recently Updated Casefiles</h5>
                        @include('dashboard.cards.recent-updated-casefiles-card')
                        @hasanyrole('Casemanager')
                            <a href="/casefiles/create" class="btn btn-sm btn-primary">New Casefile</a>
                        @endhasanyrole
                        <a href="/casefiles" class="btn btn-sm btn-primary">Go to Casefiles</a>
                    </div>
                </div>
            </li>
        @endhasanyrole
        @hasanyrole('Investigator')
            <li data-name="Cases Assigned To You" data-id="5" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Cases Assigned To You</h5>
                        @include('dashboard.cards.recent-casefiles-user-card')
                        @hasanyrole('Casemanager')
                            <a href="/casefiles/create" class="btn btn-sm btn-primary">New Casefile</a>
                        @endhasanyrole
                        <a href="/casefiles" class="btn btn-sm btn-primary">Go to Cases</a>
                    </div>
                </div>
            </li>
        @endhasanyrole
        @hasanyrole('Relations|Casemanager')
            <li data-name="Recently Added Clients" data-id="6" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recently Added Clients</h5>
                        @include('dashboard.cards.recent-clients-card')
                        @hasanyrole('Relations')
                            <a href="/clients/create" class="btn btn-sm btn-primary">New Client</a>
                        @endhasanyrole
                        <a href="/clients" class="btn btn-sm btn-primary">Go to Clients</a>
                    </div>
                </div>
            </li>
        @endhasanyrole
        @hasanyrole('Manager|Owner')
        <li data-name="License Due Dates" data-id="12" class="ml-3 mb-3 mb-md-4 mb-sm-3">
            <div class="card">
                <i class="icon-move">&#8596;</i>
                <div class="card-body pt-2">
                    <h5 class="card-title">License Due Dates</h5>
                    @include('dashboard.cards.licenses-card')
                    <a href="#" class="btn btn-sm btn-primary">Go to Licenses</a>
                </div>
            </div>
        </li>
        @endhasanyrole
    </ul>
    <ul id="sortable3" class="col-xl-4 col-lg-4 col-md-12 col-sm-12 droptrue">
        @hasanyrole('Manager|Owner')
            <li data-name="Recent User Logins" data-id="7" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recent User Logins</h5>
                        <p class="card-text">This feature is under construction. It will be soon available to you.</p>
                        @hasanyrole('Manager|Owner')
                            <a href="/users/create" class="btn btn-sm btn-primary">New User</a>
                        @endhasanyrole
                        <a href="#" class="btn btn-sm btn-primary">Go to Users</a>
                    </div>
                </div>
            </li>
        @endhasanyrole
        @hasanyrole('Manager|Owner')
            <li data-name="Statistics" data-id="8" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Statistics</h5>
                        <p class="card-text">This feature is under construction. It will be soon available to you.</p>
                        <img src="{{url('/images/smalldiagram.jpg')}}" class="img-fluid" alt="">
                        <a href="#" class="btn btn-sm btn-primary">Go to Statistics</a>
                    </div>
                </div>
            </li>
        @endhasanyrole
        @hasanyrole('Manager|Owner')
            <li data-name="Recent User Actions" data-id="9" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Recent User Actions</h5>
                        @include('dashboard.cards.action-logs-card')
                        @hasanyrole('Manager|Owner')
                            <a href="/users/create" class="btn btn-sm btn-primary">New User</a>
                        @endhasanyrole
                        <a href="#" class="btn btn-sm btn-primary">Go to Action Log</a>
                    </div>
                </div>
            </li>
        @endhasanyrole
        @hasanyrole('Administrator|Owner')
            <li data-name="Administrative Tasks" data-id="10" class="ml-3 mb-3 mb-md-4 mb-sm-3">
                <div class="card">
                    <i class="icon-move">&#8596;</i>
                    <div class="card-body pt-2">
                        <h5 class="card-title">Administrative Tasks</h5>
                        @include('dashboard.cards.administrator-card')
                    </div>
                </div>
            </li>
        @endhasanyrole
    </ul>
</div>
<br style="clear:both">



{{--<ul class="row sortableContainer">--}}
{{--    <li data-name="Your Message Inbox" data-id="1" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Your Message Inbox</h5>--}}
{{--                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Messages</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li data-name="Recent Posts" data-id="2" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Recent Posts</h5>--}}
{{--                @include('dashboard.cards.recent-posts-card')--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Posts</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li data-name="Recently Added Casefiles" data-id="3" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Recently Added Casefiles</h5>--}}
{{--                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Casefiles</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li data-name="Recently Modified Casefiles" data-id="4" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Recently Modified Casefiles</h5>--}}
{{--                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Casefiles</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li data-name="Cases Assigned To You" data-id="5" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Cases Assigned To You</h5>--}}
{{--                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Cases</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li data-name="Recently Added Clients" data-id="6" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Recently Added Clients</h5>--}}
{{--                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Clients</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li data-name="Recent User Logins" data-id="7" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Recent User Logins</h5>--}}
{{--                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Users</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li data-name="Statistics" data-id="8" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Statistics</h5>--}}
{{--                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Statistics</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--    <li data-name="Recent User Actions" data-id="9" class="col-xl-4 col-md-6 col-sm-12 mb-3 mb-md-4 mb-sm-3 sortableCard">--}}
{{--        <div class="card">--}}
{{--            <i class="icon-move">&#8596;</i>--}}
{{--            <div class="card-body pt-2">--}}
{{--                <h5 class="card-title">Recent User Actions</h5>--}}
{{--                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>--}}
{{--                <a href="#" class="btn btn-sm btn-primary">Go to Action Log</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}
{{--</ul>--}}