<nav class="navbar header-top fixed-top navbar-expand-lg  navbar-dark bg-dark">
    <a  id="navWpsIndepth" class="navbar-brand" href="#" >WPS - INDEPTH</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="timeBar" class="col-md-2 col-md-offset-2">
        <iframe src="http://free.timeanddate.com/clock/i6ua3k0i/n776/tlae/fn6/fs16/fcfff/tct/pct/ftb/pa8/tt0/th2/tb4" frameborder="0" width="266" height="56" allowTransparency="true"></iframe>
    </div>
    <div class="collapse navbar-collapse" id="navbarText">

        <ul style="float: right; padding-right: 20px" class="navbar-nav ml-md-auto d-md-flex">
            <li id='navSifCreator' class="nav-item">
                <a class="nav-link" href="generateSIF.php">GENERATE SIF
                    <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a id='navEmployees' class="nav-link" href="employees.php">EMPLOYEE LISTS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">PAYSLIPS</a>
            </li>
            <li class="nav-item dropdown" >
                <a class="nav-link dropdown-toggle" href="#" id="navAccess" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ACCESS CONTROL
                </a>
                <div class="dropdown-menu" aria-labelledby="navAccess">
                    <a id='navUserActivity' class="dropdown-item" href="userActivity.php">User Activity</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">User Management</a>

                </div>
            </li>

        </ul>


    </div>
    <form action="logout.php">
        <button  type ='submit' href='logout.php' class="btn btn-danger btn-sm">
            <span class="glyphicon glyphicon-log-out"></span> Log out
        </button>
    </form>

</nav>
