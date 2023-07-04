<?php
session_start();
?>
<nav class="flex items-center lg:justify-between sm:justify-center flex-wrap bg-gray-500 p-6 shadow-lg shadow-black/50 sticky top-4 opacity-100 mb-24"> <!--dark:bg-black-->
      <div class="block lg:hidden cursor-pointer flex:none mr-4" id="HamburgerInactive">
        <button id="btn" class="flex flex-col items-center px-3 py-[0.4375rem] border rounded text-teal-200 border-teal-400">
          <span class="block h-0.5 w-5 mb-1 origin-center rounded-full bg-teal-200"></span>
          <span class="block h-0.5 w-5 mb-1 origin-center rounded-full bg-teal-200"></span>
          <span class="block h-0.5 w-5 origin-center rounded-full bg-teal-200"></span>
        </button>
      </div>
      <div id="HamburgerActive" class="hidden lg:hidden flex:none cursor-pointer mr-4 block">
        <button class="space-y-2 px-3 py-2 border rounded text-teal-200 border-teal-400" >
          <span class="block h-0.5 w-5 origin-center rounded-full bg-teal-200 translate-y-1.5 rotate-45"></span>
          <span class="block h-0.5 w-5 origin-center rounded-full bg-teal-200 -translate-y-1 -rotate-45"></span>
          <span class="hidden h-0.5 w-5 origin-center rounded-full bg-white"></span>
        </button>
      </div>
      <div class="flex items-center flex-shrink-0 text-white mr-6 w-full lg:w-auto flex-1 lg:flex-none justify-center">
        <svg id="logo" class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
        <span class="font-semibold text-xl tracking-tight">G-Link</span>
      </div>
      <div id="menu-options" class="bg-gray-500 w-full lg:block flex-grow lg:flex lg:items-center lg:w-auto hidden mr-4">
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
          <a href="/" class="block mt-4 lg:inline-block lg:mt-0 bg-blue-600 brightness-125 border border-blue-500 rounded text-teal-200 hover:text-black py-1 px-3">
            Products (Form)
          </a>
        </div>

	<?php if (!isset($_SESSION['user'])) { ?>
        <div>
          <a href="signup.html" class="inline-block <%= signup %> text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0 mr-4">
            Sign up
          </a>
        </div>
	<?php } ?>

        <?php if (!isset($_SESSION['user'])) { ?>
        <div>
          <a href="login.html" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">
            Log in
          </a>
        </div>
	<?php } else {?>
        <div>
          <a href="logout.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">
            Log out
          </a>
        </div>
	<?php } ?>

      </div>
      <div class="w-9 h-9 rounded-full bg-emerald-800 cursor-pointer outline outline-offset-2 outline-4 outline-white hover:bg-emerald-700">
        <button class="w-full h-full bg-white rounded-full" id="dropdownDefaultButton" data-dropdown-toggle="dropdown">

        </button>
      </div>
      <div class="relative">
        <button dropdown-trigger aria-expanded="false" type="button" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-sm ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">Dropdown</button>
        <p class="hidden transform-dropdown-show"></p>
        <ul dropdown-menu class="z-10 text-sm lg:shadow-soft-3xl duration-250 before:duration-350 before:font-awesome before:ease-soft min-w-44 before:text-5.5 transform-dropdown pointer-events-none absolute left-auto top-1/2 m-0 -mr-4 mt-2 list-none rounded-lg border-0 border-solid border-transparent bg-white bg-clip-padding px-0 py-2 text-left text-slate-500 opacity-0 transition-all before:absolute before:right-7 before:left-auto before:top-0 before:z-40 before:text-white before:transition-all before:content-['\f0d8']">
          <li>
            <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300" href="javascript:;">Action</a>
          </li>
          <li>
            <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300" href="javascript:;">Another action</a>
          </li>
          <li>
            <a class="py-1.2 lg:ease-soft clear-both block w-full whitespace-nowrap border-0 bg-transparent px-4 text-left font-normal text-slate-500 hover:bg-gray-200 hover:text-slate-700 dark:text-white dark:hover:bg-gray-200/80 dark:hover:text-slate-700 lg:transition-colors lg:duration-300" href="javascript:;">Something else here</a>
          </li>
        </ul>
      </div>
      <script>
        let active = document.getElementById("HamburgerActive");
        let inactive = document.getElementById("HamburgerInactive");
        let options = document.querySelector("#menu-options");
        active.addEventListener("click", ()=>{
          active.classList.add("hidden");
          inactive.classList.remove("hidden");
          options.classList.toggle("hidden");
        })
        inactive.addEventListener("mouseup", ()=>{
          inactive.classList.add("hidden");
          active.classList.remove("hidden");
          options.classList.toggle("hidden");
        });
      </script>
</nav>
