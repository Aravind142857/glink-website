<?php
session_start();
?>

    <div class="navbar dark:from-gray-800 dark:to-gray-800 rounded-lg bg-gradient-to-r from-rose-400 via-blue-400 to-emerald-400 shadow-xl shadow-black/50 z-[4] sticky top-0 mb-10">
      <div class="flex-1 lg:ml-4 ml-2 my-2">
        <!--Hamburger menu-->
        <div class="lg:hidden" >
          <ul class="menu menu-horizontal px-1">
              <label class="group btn btn-circle bg-transparent dark:bg-gray-800 swap swap-rotate border-emerald-300">
                <input type="checkbox" class="opacity-0 w-full h-full "/>
                <svg class="swap-off fill-emerald-300 group-hover:fill-black dark:fill-emerald-400 dark:group-hover:fill-white brightness-125" xmlns="http://www.w3.org/2000/svg" width="32" height="32"  viewBox="0 0 512 512"><path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z"/></svg>
                <div class="dropdown dropdown-open swap-on">
                    <svg class="fill-emerald-300 group-hover:fill-black dark:fill-emerald-400 dark:group-hover:fill-white brightness-125" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><polygon points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49"/></svg>
                  <ul tabindex="0" class="menu dropdown-content z-[1] p-2 shadow bg-green-100 dark:bg-gray-800 rounded-box w-36 mt-4">
                    <li><a class="text-emerald-700 brightness-125 dark:text-emerald-400 dark:hover:text-white">Create</a></li>
                    <li><a class="text-emerald-700 brightness-125 dark:text-emerald-400 dark:hover:text-white">Signup</a></li>
                    <li><a class="text-emerald-700 brightness-125 dark:text-emerald-400 dark:hover:text-white">Login</a></li>
                  </ul>
                </div>
              </label>
          </ul>
        </div>
        <!-- Hamburger Menu ended -->

        <div class="flex lg:justify-start lg:items-start justify-center items-center lg:w-auto w-full">
          <a class="btn btn-ghost normal-case text-xl text-emerald-400 brightness-125" href="/"><img src="GLink-Logo-alt.svg" class="h-full "></a>
        </div>
        <div class="w-full justify-center items-center lg:flex hidden">
	<?php if(isset($_SESSION['user'])) { ?>
          <a class="btn btn-outline dark:btn-success dark:bg-transparent border-yellow-300 text-yellow-300 hover:bg-yellow-400 hover:border-none hover:text-black brightness-125 lg:text-xl text-sm" href="/form.html">Create</a>
	<?php } ?>
        </div>
      </div>
      <div class="justify-center items-center lg:flex mr-10 my-2">
	<?php if(!isset($_SESSION['user'])) { ?>
        <a class="btn btn-outline dark:btn-success dark:text-success dark:bg-transparent border-yellow-300 text-yellow-300 hover:bg-yellow-400 hover:border-none hover:text-black brightness-125 lg:text-xl text-sm mr-4 lg:flex hidden" href="login.html">Log In</a>
        <a class="btn btn-outline dark:btn-success dark:text-success dark:bg-transparent border-yellow-300 text-yellow-300 hover:bg-yellow-400 hover:border-none hover:text-black brightness-125 lg:text-xl text-sm mr-8 lg:flex hidden" href="signup.html">Sign up</a>
	<?php } ?>
          <label class="swap swap-rotate">

              <!-- this hidden checkbox controls the state -->
              <input type="checkbox" id="theme-switcher" class="h-full w-full hidden" onclick="changeMode()"/>

              <!-- sun icon -->
              <svg id="sun" class="swap-on fill-yellow-500 w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41Z" fill="yellow"/>
                  <path d="M12,6.5A5.5,5.5,0,1,0,17.5,12A5.51,5.51,0,0,0,12,6.5Z" fill="yellow" /></svg>

              <!-- moon icon -->
              <svg id="moon" class="swap-off fill-white w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" fill="white"/></svg>

          </label>
          <script>
              // window.onload = function(){
              //         if (document.getElementById("html-tag").contains("dark")) {
              //             console.log("dark");
              //             document.getElementById("sun").classList.add("swap-active");
              //         } else {
              //             console.log("light");
              //             document.getElementById("moon").classList.add("swap-active");
              //         }
              //   }

              window.addEventListener('load', function(){
                if (window.matchMedia &&
                      window.matchMedia('(prefers-color-scheme: dark)').matches) {
                      document.getElementById("theme-switcher").checked = true;
                     console.log("prefers dark");
                      changeMode();
                  } else {
                      document.getElementById("theme-switcher").checked = false;
                      console.log("prefers light");
                      changeMode();
                  }
              });
              window.matchMedia('(prefers-color-scheme: dark)')
              .addEventListener('change',({ matches }) => {
              if (matches) {
                  console.log("change to dark mode!");
                  document.getElementById("theme-switcher").checked = true;
                  changeMode();
              } else {
                  console.log("change to light mode!");
                  document.getElementById("theme-switcher").checked = false;
                  changeMode();
              }
              });

              function changeMode() {
                  let html_tag = document.getElementById("html-tag")
                  let box = document.getElementById("theme-switcher");
                  if (box.checked) {
                      if (!html_tag.classList.contains("dark")) {
                          html_tag.classList.add("dark");
                      }
                  }
                  if (!box.checked) {
                      if (html_tag.classList.contains("dark")) {
                          html_tag.classList.remove("dark");
                      }
                  }
              }
          </script>
      </div>

<?php if(isset($_SESSION['user'])) { ?>
      <div class="flex-none my-2 mr-2">
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost btn-circle avatar border border-2 border-gray-800 dark:border-emerald-500 brightness-125 hover:border-none hover:ring-2 hover:ring-gray-800 dark:hover:ring-emerald-400 focus:ring-2 focus:ring-gray-800 dark:focus:ring-emerald-400">
            <div class="w-10 rounded-full cursor-pointer ">
              <div class="w-full h-full bg-yellow-200 rounded-full flex justify-center items-center"><h1 class="self-center text-xl font-bold font-serif"><?php echo(strtoupper(substr($_SESSION['user'],0,1)));?></h1></div>
            </div>
          </label>
          <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-green-100 dark:bg-gray-800 rounded-box w-36">
            <li><a class="text-emerald-700 brightness-125 dark:text-emerald-400 font-bold uppercase dark:hover:text-white" href="dashboard.html">My Links</a></li>
            <li><a class="text-emerald-700 brightness-125 dark:text-emerald-400 font-bold uppercase dark:hover:text-white" href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
<?php } ?>

    </div>
