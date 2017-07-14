<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a id='navbarbrand' class="navbar-brand" href="home.php">BoulderTracker!</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <div class="btn-group">
                    <button id='navbarsubmitbutton' type="button" class="btn btn-primary dropdown-toggle"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Submit a Route! <span class="caret"></span>
                    </button>
                    <ul id="navbarsubmitdrop" class="dropdown-menu">
                        <form id='navbarsubmitdrop' class="navbar-form navbar-left" method="post"
                              action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                            Route Name: <input id="filterfield" type="text" name="routeName"
                                               placeholder="Route Name"><br>
                            Grade (V):
                            <select id="filterfield" id="grade" name="grade">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                                <option>11</option>
                                <option>12</option>
                                <option>13</option>
                                <option>14</option>
                                <option>15</option>
                            </select><br>
                            Date Sent:<input id="filterfield" type="date" name="date"
                                             value="<?php echo date('Y-m-d'); ?>"/><br>
                            <button id="filterfield" type="submit" value="Submit" name="btn-route">SUBMIT ROUTE</button>
                        </form>
                    </ul>
                </div>

                <div class="btn-group">

                    <button id="navbarsearch" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">
                        Search Climbers! <span class="caret"></span>
                    </button>

                    <ul id="navbarsearchdrop" class="dropdown-menu">
                        <li>
                            <form method="post" autocomplete="off">
                                Climber's Email: <input id="filterfield" type="text" name="emailSearch"
                                                        placeholder="E-mail goes here"><br>
                                <button id="filterfield" type="submit" value="Submit" name="btn-search">Search</button>
                            </form>
                        </li>

                    </ul>
                </div>

                <div class="btn-group">
                    <a class="listbtn" href="list.php">List of Climbers</a>
                </div>

                <div class="btn-group">
                    <a class="profilebtn" href="#">Your Profile</a>
                </div>

                <div class="btn-group">
                    <a class="logoutbtn" href="logout.php?logout">Log Out</a>
                </div>

                <div class="btn-group">
                    <a class="backbtn" href='home.php'>Back to Home</a>
                </div>


</nav>
