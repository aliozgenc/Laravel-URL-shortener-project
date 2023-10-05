<html>
    <?php

    if(DB::connection()->getPDO()){
        echo "Successfully connected to DB and DB name is " . DB::connection()->getDatabaseName();
    }

    ?>
</html>