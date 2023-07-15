<?php
session_start();
?>

<div class="navbar bg-base-100 rounded-lg shadow-xl shadow-black/50 z-[4] sticky top-0 mb-10">
      <div class="flex-1 lg:ml-4 ml-2 my-2">
        <!--Hamburger menu-->
        <div class="lg:hidden" >
          <ul class="menu menu-horizontal px-1">
              <label class="btn btn-circle swap swap-rotate ">
                <input type="checkbox" class="opacity-0 w-full h-full "/>
                <svg class="swap-off fill-emerald-400 brightness-125" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z"/></svg>
                <div class="dropdown dropdown-open swap-on">
                    <svg class="fill-emerald-400 brightness-125" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 512 512"><polygon points="400 145.49 366.51 112 256 222.51 145.49 112 112 145.49 222.51 256 112 366.51 145.49 400 256 289.49 366.51 400 400 366.51 289.49 256 400 145.49"/></svg>
                  <ul tabindex="0" class="menu dropdown-content z-[1] p-2 shadow bg-base-100 rounded-box w-36 mt-4">
                    <li><a class="text-emerald-400 brightness-125">Create</a></li>
                    <li><a class="text-emerald-400 brightness-125">Signup</a></li>
                    <li><a class="text-emerald-400 brightness-125">Login</a></li>
                  </ul>
                </div>
              </label>
          </ul>
        </div>
        <!-- Hamburger Menu ended -->

        <div class="flex lg:justify-start lg:items-start justify-center items-center lg:w-auto w-full">
          <a href="/" class="btn btn-ghost normal-case text-xl text-emerald-400 brightness-125"><img src="GLink-Logo-alt.svg" class="h-full "></a>
        </div>
        <div class="w-full justify-center items-center lg:flex hidden">
        <?php if(isset($_SESSION['user'])) { ?>
          <a class="btn btn-outline btn-success brightness-125 lg:text-xl text-sm" href="/form.html">Create</a>
          <?php } ?>
        </div>
      </div>
      <div class="justify-center items-center lg:flex mr-10 my-2 hidden">
      <?php if(!isset($_SESSION['user'])) { ?>
        <a class="btn btn-outline btn-success brightness-125 lg:text-xl mr-4 text-sm" href="signup.html">Sign Up</a>
        <a class="btn btn-outline btn-success brightness-125 lg:text-xl text-sm" href="login.html">Log in</a>
       <?php } ?>
      </div>

	<?php if(isset($_SESSION['user'])) { ?>
      <div class="flex-none my-2">
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-ghost btn-circle avatar border border-2 border-emerald-500 brightness-125 hover:border-none hover:ring-2 hover:ring-emerald-400 focus:ring-2 focus:ring-emerald-400">
            <div class="w-10 rounded-full cursor-pointer ">
              <div class="w-full h-full bg-white rounded-full text-center"></div>
            </div>
          </label>
          <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-36">
            <li><a href="dashboard.html">My Links</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
	<?php } ?>
    </div>
