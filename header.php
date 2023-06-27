<?php
session_start();
?>
<nav class="flex items-center justify-between flex-wrap bg-gray-500 p-6 shadow-lg shadow-black/50 sticky top-0"> <!--dark:bg-black-->
    <div class="flex items-center flex-shrink-0 text-white mr-6">
        <svg id="logo" class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
        <span class="font-semibold text-xl tracking-tight">G-Link</span>
    </div>
    <div class="block lg:hidden">
        <button id="hamburger-menu" class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
            <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
        </button>
    </div>
    <div id="menu-options" class="w-full lg:block flex-grow lg:flex lg:items-center lg:w-auto hidden">
        <div class="text-sm lg:flex-grow">
            <a href="#head" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-black mr-4 hover:bg-gray-200 hover:border hover:border-gray-200 hover:rounded text-teal-200 py-1 px-3">
                A
            </a>
            <a href="#head" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-black mr-4 hover:bg-gray-200 hover:border hover:border-gray-200 hover:rounded text-teal-200 py-1 px-3">
                B
            </a>
            <a href="#head" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-black mr-4 hover:bg-gray-200 hover:border hover:border-gray-200 hover:rounded text-teal-200 py-1 px-3">
                C
            </a>
            <a href="/index.html" class="block mt-4 lg:inline-block lg:mt-0 bg-blue-600 brightness-125 border border-blue-500 rounded text-teal-200 hover:text-black py-1 px-3">
                Products (Form)
            </a>
        </div>
        <div>
	    <?php if (isset($_SESSION['user'])) { ?>
		        <a href="logout.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">
                		Log Out
		        </a>
	    <?php } ?>
        </div>
    </div>
    <script>
        menu = document.querySelector("#hamburger-menu");
        options = document.querySelector("#menu-options");
        menu.addEventListener("click", () => {
            options.classList.toggle("hidden");
        })

    </script>
</nav>
