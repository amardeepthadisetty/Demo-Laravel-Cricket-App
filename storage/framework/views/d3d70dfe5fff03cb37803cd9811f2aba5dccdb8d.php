<style>

        img
        {
            vertical-align: middle;
        }
        .img-responsive
        {
            display: block;
            height: auto;
            max-width: 100%;
        }
        .img-rounded
        {
            border-radius: 3px;
        }
        .img-thumbnail
        {
            background-color: #fff;
            border: 1px solid #ededf0;
            border-radius: 3px;
            display: inline-block;
            height: auto;
            line-height: 1.428571429;
            max-width: 100%;
            moz-transition: all .2s ease-in-out;
            o-transition: all .2s ease-in-out;
            padding: 2px;
            transition: all .2s ease-in-out;
            webkit-transition: all .2s ease-in-out;
        }
        .img-circle
        {
            border-radius: 50%;
        }
        .timeline-centered {
            position: relative;
            margin-bottom: 30px;
        }

            .timeline-centered:before, .timeline-centered:after {
                content: " ";
                display: table;
            }

            .timeline-centered:after {
                clear: both;
            }

            .timeline-centered:before, .timeline-centered:after {
                content: " ";
                display: table;
            }

            .timeline-centered:after {
                clear: both;
            }

            .timeline-centered:before {
                content: '';
                position: absolute;
                display: block;
                width: 4px;
                background: #f5f5f6;
                left: 50%;
                top: 20px;
                bottom: 20px;
                margin-left: -4px;
            }

            .timeline-centered .timeline-entry {
                position: relative;
                width: 50%;
                float: right;
                margin-bottom: 70px;
                clear: both;
            }

                .timeline-centered .timeline-entry:before, .timeline-centered .timeline-entry:after {
                    content: " ";
                    display: table;
                }

                .timeline-centered .timeline-entry:after {
                    clear: both;
                }

                .timeline-centered .timeline-entry:before, .timeline-centered .timeline-entry:after {
                    content: " ";
                    display: table;
                }

                .timeline-centered .timeline-entry:after {
                    clear: both;
                }

                .timeline-centered .timeline-entry.begin {
                    margin-bottom: 0;
                }

                .timeline-centered .timeline-entry.left-aligned {
                    float: left;
                }

                    .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner {
                        margin-left: 0;
                        margin-right: -18px;
                    }

                        .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-time {
                            left: auto;
                            right: -100px;
                            text-align: left;
                        }

                        .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-icon {
                            float: right;
                        }

                        .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-label {
                            margin-left: 0;
                            margin-right: 70px;
                        }

                            .timeline-centered .timeline-entry.left-aligned .timeline-entry-inner .timeline-label:after {
                                left: auto;
                                right: 0;
                                margin-left: 0;
                                margin-right: -9px;
                                -moz-transform: rotate(180deg);
                                -o-transform: rotate(180deg);
                                -webkit-transform: rotate(180deg);
                                -ms-transform: rotate(180deg);
                                transform: rotate(180deg);
                            }

                .timeline-centered .timeline-entry .timeline-entry-inner {
                    position: relative;
                    margin-left: -22px;
                }

                    .timeline-centered .timeline-entry .timeline-entry-inner:before, .timeline-centered .timeline-entry .timeline-entry-inner:after {
                        content: " ";
                        display: table;
                    }

                    .timeline-centered .timeline-entry .timeline-entry-inner:after {
                        clear: both;
                    }

                    .timeline-centered .timeline-entry .timeline-entry-inner:before, .timeline-centered .timeline-entry .timeline-entry-inner:after {
                        content: " ";
                        display: table;
                    }

                    .timeline-centered .timeline-entry .timeline-entry-inner:after {
                        clear: both;
                    }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time {
                        position: absolute;
                        left: -100px;
                        text-align: right;
                        padding: 10px;
                        -webkit-box-sizing: border-box;
                        -moz-box-sizing: border-box;
                        box-sizing: border-box;
                    }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time > span {
                            display: block;
                        }

                            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time > span:first-child {
                                font-size: 15px;
                                font-weight: bold;
                            }

                            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-time > span:last-child {
                                font-size: 12px;
                            }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon {
                        background: #fff;
                        color: #737881;
                        display: block;
                        width: 40px;
                        height: 40px;
                        -webkit-background-clip: padding-box;
                        -moz-background-clip: padding;
                        background-clip: padding-box;
                        -webkit-border-radius: 20px;
                        -moz-border-radius: 20px;
                        border-radius: 20px;
                        text-align: center;
                        -moz-box-shadow: 0 0 0 5px #f5f5f6;
                        -webkit-box-shadow: 0 0 0 5px #f5f5f6;
                        box-shadow: 0 0 0 5px #f5f5f6;
                        line-height: 40px;
                        font-size: 15px;
                        float: left;
                    }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-primary {
                            background-color: #303641;
                            color: #fff;
                        }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-secondary {
                            background-color: #ee4749;
                            color: #fff;
                        }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-success {
                            background-color: #00a651;
                            color: #fff;
                        }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-info {
                            background-color: #21a9e1;
                            color: #fff;
                        }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-warning {
                            background-color: #fad839;
                            color: #fff;
                        }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-icon.bg-danger {
                            background-color: #cc2424;
                            color: #fff;
                        }

                    .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label {
                        position: relative;
                        background: #f5f5f6;
                        padding: 1.7em;
                        margin-left: 70px;
                        -webkit-background-clip: padding-box;
                        -moz-background-clip: padding;
                        background-clip: padding-box;
                        -webkit-border-radius: 3px;
                        -moz-border-radius: 3px;
                        border-radius: 3px;
                    }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label:after {
                            content: '';
                            display: block;
                            position: absolute;
                            width: 0;
                            height: 0;
                            border-style: solid;
                            border-width: 9px 9px 9px 0;
                            border-color: transparent #f5f5f6 transparent transparent;
                            left: 0;
                            top: 10px;
                            margin-left: -9px;
                        }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2, .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label p {
                            color: #737881;
                            font-family: "Noto Sans",sans-serif;
                            font-size: 12px;
                            margin: 0;
                            line-height: 1.428571429;
                        }

                            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label p + p {
                                margin-top: 15px;
                            }

                        .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 {
                            font-size: 16px;
                            margin-bottom: 10px;
                        }

                            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 a {
                                color: #303641;
                            }

                            .timeline-centered .timeline-entry .timeline-entry-inner .timeline-label h2 span {
                                -webkit-opacity: .6;
                                -moz-opacity: .6;
                                opacity: .6;
                                -ms-filter: alpha(opacity=60);
                                filter: alpha(opacity=60);
                            }

</style>

<?php if($comments): ?>

<div class="container">
    <div class="row">
        <div class="timeline-centered">

    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <article class="timeline-entry <?php if($comment->posted_by=='3') { echo 'left-aligned'; } ?>">
        
            <div class="timeline-entry-inner">
                <time class="timeline-time" datetime="2014-01-10T03:45">
                    <span title="<?php echo e(date('d-m-Y', strtotime( $comment->created_at ) )); ?>"><?php echo e(date('h:i A', strtotime( $comment->created_at ) )); ?></span>
                 <span><?php echo e(humanTiming(strtotime( $comment->created_at ) )); ?> ago </span>
             </time>
                
                <div class="timeline-icon 
                <?php 
                if( $comment->posted_by=='1'){
                    echo 'bg-warning';
                }elseif($comment->posted_by=='2'){
                   echo 'bg-info';
                }else{
                    echo 'bg-secondary';
                } ?> ">
                    <i class="entypo-camera"></i>
                </div>
                
                <div class="timeline-label">
                    <h2>
                    <a href="#">
                        <?php if( $comment->posted_by=="1"): ?>
                            System generated
                        <?php elseif($comment->posted_by=="2"): ?>
                            User posted
                        <?php else: ?>
                            Admin  posted      
                        <?php endif; ?>
                    </a> <span>  Comment</span></h2>
                    <p><?php echo e($comment->comments); ?></p>
                </div>
            </div>
            
        </article>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>
    </div>
</div>

<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\laramongo\resources\views/orders/timeline.blade.php ENDPATH**/ ?>