<nav class="navbar navbar-expand-sm navbar-dark" style="background-color: #0074d9;">
    <div class="container-fluid">
        <a href="homepage.php" class="navbar-brand">Landscaping | Supervisor</a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a href="homepage.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="<?php $_SESSION['equip']=1; echo 'equipmentpage.php';?>" class="nav-link">Equipments</a>
                </li>
<!--                 <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Messages</a>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item">Inbox</a>
                        <a href="#" class="dropdown-item">Drafts</a>
                        <a href="#" class="dropdown-item">Sent Items</a>
                        <div class="dropdown-divider"></div>
                        <a href="#"class="dropdown-item">Trash</a>
                    </div>
                </li> -->
                <li class="nav-item">
                    <a href="<?php $_SESSION['request_']=1; echo 'requestpage.php';?>" class="nav-link">Requests</a>
                </li>
                <li class="nav-item">
                    <a href="<?php $_SESSION['attend']=1; echo 'attendance.php';?>" class="nav-link">Attendance</a>
                </li>
                <li class="nav-item">
                    <a href="<?php $_SESSION['roster']=1; echo 'dutyroster.php';?>" class="nav-link">Duty Roster</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" style="color: white;">Admin</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="<?php $_SESSION['change']=1; echo 'changepassword.php';?>" class="dropdown-item">Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>