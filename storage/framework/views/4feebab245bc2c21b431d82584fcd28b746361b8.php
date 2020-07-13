<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container">
    <div id="mainnav">

        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">

                    <!--Profile Widget-->
                    <!--================================-->
                    


                    <!--Shortcut buttons-->
                    <!--================================-->
                    <div id="mainnav-shortcut" class="hidden">
                        <ul class="list-unstyled shortcut-wrap">
                            <li class="col-xs-3" data-content="My Profile">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-mint">
                                    <i class="demo-pli-male"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Messages">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-warning">
                                    <i class="demo-pli-speech-bubble-3"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Activity">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-success">
                                    <i class="demo-pli-thunder"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="col-xs-3" data-content="Lock Screen">
                                <a class="shortcut-grid" href="#">
                                    <div class="icon-wrap icon-wrap-sm icon-circle bg-purple">
                                    <i class="demo-pli-lock-2"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--================================-->
                    <!--End shortcut buttons-->


                    <ul id="mainnav-menu" class="list-group">
                          

                          

                            <li class="active">
                                <a class="nav-link" href="<?php echo e(route('teams.index')); ?>">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title"><?php echo e(__('Teams')); ?></span>
                                </a>
                            </li>

                             <li class="active">
                                <a class="nav-link" href="<?php echo e(route('players.index')); ?>">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title"><?php echo e(__('Players')); ?></span>
                                </a>
                            </li> 

                              <li class="active">
                                <a class="nav-link" href="<?php echo e(route('fixtures.index')); ?>">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title"><?php echo e(__('Fixtures')); ?></span>
                                </a>
                            </li>  

                             <li class="active">
                                <a class="nav-link" href="<?php echo e(route('points.index')); ?>">
                                    <i class="fa fa-home"></i>
                                    <span class="menu-title"><?php echo e(__('Points')); ?></span>
                                </a>
                            </li>


                          
                       
                    </ul>
                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
<?php /**PATH C:\xampp\htdocs\cricket\resources\views/inc/admin_sidenav.blade.php ENDPATH**/ ?>