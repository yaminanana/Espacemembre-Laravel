<?php if(!empty($success));?>
   <div class="alert alert-success"><p><?=$sucess;?></p></div>
    

    <?php if(!empty($errors));?>
        <div class="alert alert=danger">
            <?php forEach($errors as $error):?>
<p><?=$error;?></p>

                <?php endforEach;?>
        </div>