<div class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.html"><img src="<?php echo base_url()   ?>images/logo_light.png" alt=""></a>

            <ul class="nav navbar-nav visible-xs-block">
                <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
                <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile">


            <p class="navbar-text">
                <span class="label bg-success">Online</span>
            </p>

            <div class="navbar-right">
                <ul class="nav navbar-nav">
                  

  

                    <li class="dropdown dropdown-user">
                        <a class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo base_url()     ?>images/placeholders/placeholder.jpg" alt="">
                            <span><?php echo ucwords($this->session->userdata('username')) ?></span>
                            <i class="caret"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="<?php echo base_url() ?>Admin/logout"><i class="icon-switch2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url() ?>">