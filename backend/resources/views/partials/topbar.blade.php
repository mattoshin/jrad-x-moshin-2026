<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                    <span class="logo">
                        <img src="https://cdn.discordapp.com/attachments/946134529758863380/984571944227704842/Mocean_transparent-01.png" alt="" height="30">
                       	Admin Dashboard
                    </span>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>

        <div class="d-flex">


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-none d-xl-inline-block ms-1">
			<img class="rounded-circle header-profile-user" src="https://cdn.discordapp.com/avatars/{{
                                json_decode(Cookie::get('admin'), true)["discord"]
                        }}/{{ 
				json_decode(Cookie::get('admin'), true)["avatar"]
                        }}.jpg" alt="Header Avatar">
                        {{ 
                            json_decode(Cookie::get('admin'), true)["username"]
                         }}
			</span>
                </button>
            </div>


        </div>
    </div>
</header>
