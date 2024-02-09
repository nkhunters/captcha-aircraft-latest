<nav class="bg-darkslateblue">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false" id="mobile-menu-btn">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-white text-xl font-bold">Aircraft Captcha Services</span>
                </div>
                <div class="hidden sm:block sm:ml-6 w-full" id="desktop-menu">
                    <ul class="flex justify-end space-x-4 w-full text-white font-medium">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <li class="nav-item active">
                            <a class="nav-link text-white" href="viewusers.php">Home</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbardrop"
                                data-toggle="dropdown">
                                Plans
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="viewusers-plan.php?n=<?= time() ?>&plan=500">500$</a>
                                <a class="dropdown-item" href="viewusers-plan.php?n=<?= time() ?>&plan=999">999$</a>
                                <a class="dropdown-item" href="viewusers-plan.php?n=<?= time() ?>&plan=1499">1499$</a>
                                <a class="dropdown-item" href="viewusers-plan.php?n=<?= time() ?>&plan=1999">1999$</a>
                                <a class="dropdown-item" href="viewusers-plan.php?n=<?= time() ?>&plan=2499">2499$ </a>
                                <a class="dropdown-item" href="viewusers-plan.php?n=<?= time() ?>&plan=2999">2999$</a>
                            </div>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbardrop"
                                data-toggle="dropdown">
                                User Management
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="createuser.php">Create User</a>
                                <a class="dropdown-item" href="viewusers.php">View Users</a>
                                <a class="dropdown-item" href="view-users-offer.php?n=<?= time() ?>">View
                                    Users -
                                    Offer</a>
                                <a class="dropdown-item" href="view-users-old.php?n=<?= time() ?>">View Users
                                    -
                                    Old</a>
                                <a class="dropdown-item" href="inactiveUsers.php?n=<?= time() ?>">View
                                    Inactive
                                    Users</a>
                                <a class="dropdown-item" href="users-on-hold.php?n=<?= time() ?>&password=1234">View
                                    Users on hold</a>
                                <a class="dropdown-item"
                                    href="users-on-mannual-approval.php?n=<?= time() ?>&password=1234">View
                                    Users not on auto approve</a>
                                <a class="dropdown-item" href="approverequests.php?n=<?= time() ?>">Next
                                    Order
                                    Requests</a>
                                <a class="dropdown-item" href="dayWiseHistory.php?n=<?= time() ?>">Daily
                                    Order
                                    History</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbardrop"
                                data-toggle="dropdown">
                                Captcha Management
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="createCaptchaTerminal2.php">Create Captcha</a>
                                <!-- <a class="dropdown-item" href="viewcaptcha.php?n=<?= time() ?>">View
                                    Captcha</a> -->
                                <a class="dropdown-item" href="viewcaptchaterminal.php?n=<?= time() ?>">View
                                    Captcha
                                    Terminal</a>
                                <a class="dropdown-item" href="createTerminal.php">Create Terminal</a>
                                <a class="dropdown-item" href="viewTerminal.php?n=<?= time() ?>">View
                                    Terminals</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbardrop"
                                data-toggle="dropdown">
                                Live App
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="sendMsg.php?n=<?= time() ?>">Send Messages</a>
                                <a class="dropdown-item" href="viewMessages.php">View Messages</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbardrop"
                                data-toggle="dropdown">
                                Demo App
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="sendMsgDemo.php?n=<?= time() ?>">Send Messages - Demo
                                    App</a>
                                <a class="dropdown-item" href="viewMessagesDemo.php?n=<?= time() ?>">View Messages -
                                    Demo
                                    App</a>
                                <!-- <a class="dropdown-item" href="composeDemoMsg.php">Compose Demo App Message</a> -->
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <!-- Profile dropdown -->
                <div class="ml-3 relative">
                    <div>
                        <button type="button"
                            class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8 rounded-full" src="man.png" alt="" />
                        </button>
                    </div>

                    <div class="hidden z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1"
                        id="menu">
                        <!-- Active: "bg-gray-100", Not Active: "" -->

                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 uppercase font-bold" role="menuitem"
                            tabindex="-1" id="user-menu-item-0"><?= $_SESSION['admin_username']; ?></a>
                        <a href="changeAdminPassword.php?password=123" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">Change password</a>
                        <a href="support.php?password=123" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                            tabindex="-1" id="user-menu-item-0">Change Support Details</a>
                        <a href="change-lock-password.php?password=123" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">Change security password</a>
                        <a href="watchlist.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
                            tabindex="-1" id="user-menu-item-0">Watchlisted users</a>
                        <a href="main-website-view-plans.php?password=123" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">Main website Plans</a>
                        <a href="main-website-content.php?password=123" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">Main website Content</a>
                        <a href="main-website-social.php?password=123" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">Main website Social</a>
                        <a href="main-website-enquiries.php" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">Main website Enquiries</a>
                        <a href="demo-whatsapp-numbers.php" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">Demo Whatsapp Numbers</a>
                        <a href="deletedEnquiries.php?password=1234" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">View deleted Enquiries</a>
                        <a href="deletedWhatsapp.php?password=1234" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">View deleted Whatsapp Numbers</a>
                        <a href="deletedUsers.php?password=1234" class="block px-4 py-2 text-sm text-gray-700"
                            role="menuitem" tabindex="-1" id="user-menu-item-0">View deleted users</a>
                        <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                            id="user-menu-item-2">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="hidden lg:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <ul class="navbar-nav mr-auto flex items-center">

                <li class="nav-item active">
                    <a class="nav-link" href="viewusers.php?n=<?= time() ?>">Home <span
                            class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        User Management
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="createuser.php">Create User</a>
                        <a class="dropdown-item" href="viewusers.php?n=<?= time() ?>">View Users</a>
                        <a class="dropdown-item" href="view-users-offer.php?n=<?= time() ?>">View Users - Offer</a>
                        <a class="dropdown-item" href="view-users-old.php?n=<?= time() ?>">View Users - Old</a>
                        <a class="dropdown-item" href="inactiveUsers.php?n=<?= time() ?>">View Inactive Users</a>
                        <a class="dropdown-item" href="approverequests.php?n=<?= time() ?>">Next Order Requests</a>
                        <a class="dropdown-item" href="dayWiseHistory.php?n=<?= time() ?>">Daily Order History</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        Captcha Management
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="admindashboard.php">Create Captcha</a>
                        <!-- <a class="dropdown-item" href="viewcaptcha.php?n=<?= time() ?>">View Captcha</a> -->
                        <a class="dropdown-item" href="viewcaptchaterminal.php?n=<?= time() ?>">View Captcha
                            Terminal</a>
                        <a class="dropdown-item" href="createTerminal.php">Create Terminal</a>
                        <a class="dropdown-item" href="viewTerminal.php?n=<?= time() ?>">View Terminals</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        Live App
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="sendMsg.php?n=<?= time() ?>">Send Messages</a>
                        <a class="dropdown-item" href="viewMessages.php">View Messages</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        Demo App
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="sendMsgDemo.php?n=<?= time() ?>">Send Messages - Demo App</a>
                        <a class="dropdown-item" href="viewMessagesDemo.php?n=<?= time() ?>">View Messages - Demo
                            App</a>
                        <!-- <a class="dropdown-item" href="composeDemoMsg.php">Compose Demo App Message</a> -->
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <?= $_SESSION['admin_username']; ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="changeAdminPassword.php">Change Password</a>
                        <a class="dropdown-item" href="support.php">Change Support Details</a>
                        <a class="dropdown-item" href="deletedUsers.php?password=1234">View deleted users</a>
                        <a class="dropdown-item" href="watchlist.php">Watchlisted users</a>


                        <a class="dropdown-item" href="logout.php?n=<?= time() ?>">Logout</a>
                    </div>
                </li>


            </ul>
        </div>
    </div>

    <script>
    const profile = document.querySelector("#user-menu-button");
    const menu = document.querySelector("#menu");

    const mobilemenubtn = document.querySelector("#mobile-menu-btn");
    const mobilemenu = document.querySelector("#mobile-menu");

    profile.addEventListener("click", () => {
        menu.classList.toggle("hidden");
    });
    mobilemenubtn.addEventListener("click", () => {
        mobilemenu.classList.toggle("hidden");
    });
    </script>
</nav>