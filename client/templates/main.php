<body>
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">
                <div class="page-header mb-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="page-pretitle">
                                Statisctics
                            </div>
                            <h2 class="page-title">
                                <?=date('d M Y')?>
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row row-deck row-cards">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Sessions</div>
                                </div>
                                <div class="h1 mb-3" id="sessions_num">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">New Clients</div>
                                </div>
                                <div class="h1 mb-3" id="new_clients_num">0</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Money</div>
                                </div>
                                <div class="h1 mb-3"><span id="total_money_num">0</span>$</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    New Session
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <form class="col-6">
                                        <input type="hidden" id="client_id">
                                        <div class="mb-3">
                                            <label class="form-label">Car Number</label>
                                            <input type="text" class="form-control" id="car_number_input" name="car_number" placeholder="AA0000XX" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Client Name</label>
                                            <input type="text" class="form-control" id="client_name_input" name="car_number" placeholder="John Doe" required>
                                        </div>

                                    </form>
                                    <div class="col-6">
                                        <div class="mb-3" id="services_list">
                                            <div class="form-label">Choose services</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 h2"><span id="new_session_hours">0</span> hours</div>
                                    <div class="col-6 h2"><span id="new_session_money">0</span> $</div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" id="add_new_session_btn" class="btn btn-primary w-100">
                                        Add new session
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    Last Sessions
                                </div>
                            </div>
                            <div class="card-table table-responsive">
                                <table class="table table-vcenter">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Car number</th>
                                            <th>Total</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody id="last_sessions_list">
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/client/js/main.js"></script>
</body>